<?php

namespace App\Console\Commands;

use Google\Client;
use Google\Exception as GoogleException;
use Google\Service\Calendar;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GoogleAuth extends Command
{
    protected $signature = 'google:auth';

    protected $description = 'Autoriza Coordina para acceder a Google Calendar mediante OAuth';

    public function handle(): int
    {
        $this->info('=== Autenticación de Google Calendar ===');
        $this->newLine();

        try {
            $credentialsPath = storage_path('app/google-oauth-client.json');

            if (! file_exists($credentialsPath)) {
                $this->error('No se encontró el archivo de credenciales OAuth.');
                $this->line("Esperado en: {$credentialsPath}");
                $this->newLine();
                $this->line('Descargá el JSON de OAuth desde Google Cloud Console');
                $this->line('y guardalo con ese nombre.');

                Log::error('Google OAuth: no se encontró el archivo de credenciales.', [
                    'path' => $credentialsPath,
                ]);

                return self::FAILURE;
            }

            $client = new Client;

            $client->setAuthConfig($credentialsPath);

            $client->setScopes([
                Calendar::CALENDAR,
            ]);

            $client->setAccessType('offline');
            $client->setPrompt('consent');

            /*
             * Obtenemos automáticamente las credenciales
             * que ya están dentro del JSON de OAuth.
             */
            $clientId = $client->getClientId();
            $clientSecret = $client->getClientSecret();

            if (! $clientId || ! $clientSecret) {
                $this->error('El JSON OAuth no contiene client_id o client_secret.');

                Log::error('Google OAuth: faltan credenciales en el JSON.', [
                    'client_id_present' => ! empty($clientId),
                    'client_secret_present' => ! empty($clientSecret),
                ]);

                return self::FAILURE;
            }

            $authUrl = $client->createAuthUrl();

            $this->info('1. Abrí esta URL en tu navegador:');
            $this->newLine();
            $this->line($authUrl);
            $this->newLine();

            $this->info('2. Iniciá sesión con la cuenta que administra el calendario.');
            $this->info('3. Aceptá los permisos de Google Calendar.');
            $this->info('4. Google te redirigirá a localhost.');
            $this->newLine();

            $input = $this->ask(
                'Pegá acá la URL completa de redirección o el código de autorización'
            );

            if (! $input) {
                $this->error('No se ingresó ningún código ni URL.');

                Log::error('Google OAuth: entrada de autorización vacía.');

                return self::FAILURE;
            }

            /*
             * Si el usuario pegó la URL completa:
             *
             * http://localhost/?code=4/0AX...
             *
             * extraemos automáticamente el parámetro code.
             */
            $code = $this->extraerCodigo($input);

            if (! $code) {
                $this->error('No se pudo encontrar el código de autorización.');
                $this->line('Pegá la URL completa que te dio Google.');

                Log::error('Google OAuth: no se pudo extraer el código.', [
                    'input_length' => strlen($input),
                ]);

                return self::FAILURE;
            }

            $this->info('Solicitando tokens a Google...');
            $this->newLine();

            $token = $client->fetchAccessTokenWithAuthCode($code);

            if (isset($token['error'])) {
                $message = $token['error_description']
                    ?? $token['error'];

                $this->error("Google rechazó la autorización: {$message}");

                Log::error('Google OAuth: Google rechazó la autorización.', [
                    'error' => $token['error'],
                    'description' => $token['error_description'] ?? null,
                ]);

                return self::FAILURE;
            }

            if (empty($token['refresh_token'])) {
                $this->error('Google no devolvió un refresh token.');
                $this->newLine();

                $this->warn(
                    'Revocá el acceso de la aplicación desde tu cuenta de Google '
                    .'y volvé a ejecutar este comando.'
                );

                Log::error('Google OAuth: no se recibió refresh_token.', [
                    'token_keys' => array_keys($token),
                ]);

                return self::FAILURE;
            }

            $refreshToken = $token['refresh_token'];

            /*
             * Guardamos TODO lo necesario en .env.
             */
            $this->info('Guardando credenciales en .env...');

            $variables = [
                'GOOGLE_CLIENT_ID' => $clientId,
                'GOOGLE_CLIENT_SECRET' => $clientSecret,
                'GOOGLE_CALENDAR_REFRESH_TOKEN' => $refreshToken,
            ];

            foreach ($variables as $key => $value) {
                if (! $this->actualizarEnv($key, $value)) {
                    $this->error("No se pudo guardar {$key} en .env.");

                    Log::error('Google OAuth: no se pudo actualizar .env.', [
                        'key' => $key,
                    ]);

                    return self::FAILURE;
                }
            }

            $this->newLine();
            $this->info('✓ Autorización correcta.');
            $this->info('✓ GOOGLE_CLIENT_ID guardado.');
            $this->info('✓ GOOGLE_CLIENT_SECRET guardado.');
            $this->info('✓ GOOGLE_CALENDAR_REFRESH_TOKEN guardado.');
            $this->newLine();

            $this->info(
                'Google podrá renovar automáticamente los access tokens.'
            );

            $this->warn(
                'No compartas el .env ni subas estas credenciales a Git.'
            );

            Log::info('Google OAuth configurado correctamente.');

            return self::SUCCESS;

        } catch (GoogleException $e) {
            $this->error('Error de Google API:');
            $this->error($e->getMessage());

            Log::error('Google OAuth: error de Google API.', [
                'exception' => $e,
            ]);

            return self::FAILURE;

        } catch (\Throwable $e) {
            $this->error('Ocurrió un error inesperado:');
            $this->error($e->getMessage());

            Log::error('Google OAuth: error inesperado.', [
                'exception' => $e,
            ]);

            return self::FAILURE;
        }
    }

    private function extraerCodigo(string $input): ?string
    {
        /*
         * Si pegaron una URL completa, por ejemplo:
         *
         * http://localhost/?iss=https://accounts.google.com&code=4/0AX...
         */
        if (filter_var($input, FILTER_VALIDATE_URL)) {
            $query = parse_url($input, PHP_URL_QUERY);

            if (! $query) {
                return null;
            }

            parse_str($query, $params);

            return $params['code'] ?? null;
        }

        /*
         * Si directamente pegaron el código.
         */
        return trim($input);
    }

    private function actualizarEnv(string $key, string $value): bool
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return false;
        }

        $env = file_get_contents($envPath);

        if ($env === false) {
            return false;
        }

        /*
         * Escapamos comillas y guardamos entre comillas.
         */
        $value = '"'.addslashes($value).'"';

        $pattern = '/^'.preg_quote($key, '/').'=.*$/m';

        if (preg_match($pattern, $env)) {
            $result = preg_replace(
                $pattern,
                "{$key}={$value}",
                $env
            );

            if ($result === null) {
                return false;
            }

            $env = $result;
        } else {
            $env .= PHP_EOL."{$key}={$value}".PHP_EOL;
        }

        return file_put_contents($envPath, $env) !== false;
    }
}
