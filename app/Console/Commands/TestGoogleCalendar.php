<?php

namespace App\Console\Commands;

use App\DTO\Calendar\CalendarEventData;
use App\Services\GoogleCalendarService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TestGoogleCalendar extends Command
{
    protected $signature = 'google:test';

    protected $description = 'Prueba la integración con Google Calendar';

    public function handle(GoogleCalendarService $calendar): int
    {
        $inicio = Carbon::tomorrow()
            ->setTime(10, 0);

        $fin = $inicio->copy()->addHours(1);

        $data = CalendarEventData::make()
            ->summary('Hola Mundo')
            ->description('Evento de prueba creado desde Coordina.')
            ->location('La Plata, Buenos Aires')
            ->start($inicio->toIso8601String())
            ->end($fin->toIso8601String())
            ->emails(['ignacio.latronico96@gmail.com', 'joaquin.latronico96@gmail.com'])
            ->sendUpdates(true);

        $calendarId = config('services.google.calendar_id');
        // $calendarID = '23c8b4f2529c00537c4cd03cda7d119e67278b9d66844c3aaf5ef3d8de100527@group.calendar.google.com';

        if (! $calendarId) {
            $this->error('No está configurado services.google.calendar_id.');

            return self::FAILURE;
        }

        $googleEventId = $calendar->crearEvento(
            $calendarId,
            $data
        );

        $this->info('Evento creado correctamente.');
        $this->line("Google Event ID: {$googleEventId}");

        return self::SUCCESS;
    }
}
