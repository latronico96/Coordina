<?php

namespace App\Filament\Resources\Servidors\Pages;

use App\Filament\Resources\Servidors\ServidorResource;
use App\Models\Servidor;
use App\Services\ServidorService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditServidor extends EditRecord
{
    protected static string $resource = ServidorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),

            DeleteAction::make(),

            Action::make('crearUsuario')
                ->label('Crear usuario e invitar')
                ->icon('heroicon-o-user-plus')
                ->color('success')
                ->visible(fn () => ! $this->servidor()->tieneUsuario())
                ->disabled(fn () => empty($this->servidor()->email))
                ->tooltip(
                    fn () => empty($this->servidor()->email)
                        ? 'Debe completar un email para crear el usuario.'
                        : null
                )
                ->requiresConfirmation()
                ->modalHeading('Crear usuario e invitar')
                ->modalDescription(
                    'Se guardarán los cambios del servidor y se creará el usuario con el email configurado.'
                )
                ->action(function () {

                    // Guarda cualquier cambio pendiente del formulario
                    $this->save();

                    /** @var Servidor $servidor */
                    $servidor = $this->record;

                    app(ServidorService::class)
                        ->crearUsuarioEInvitar($servidor);

                    $this->record->refresh();
                    $this->record->load('user');

                    Notification::make()
                        ->title('Usuario creado correctamente')
                        ->success()
                        ->send();

                    // Ir a la ficha del servidor
                    $this->redirect(
                        ServidorResource::getUrl(
                            'view',
                            [
                                'record' => $this->record,
                            ]
                        )
                    );
                }),

            Action::make('reenviarInvitacion')
                ->label('Reenviar invitación')
                ->icon('heroicon-o-paper-airplane')
                ->color('warning')
                ->visible(
                    fn () => $this->servidor()->tieneUsuario()
                        && ! $this->servidor()->usuarioActivo()
                )
                ->requiresConfirmation()
                ->action(function () {

                    /** @var Servidor $servidor */
                    $servidor = $this->record;

                    app(ServidorService::class)
                        ->reenviarInvitacion($servidor);

                    Notification::make()
                        ->title('Invitación reenviada')
                        ->success()
                        ->send();
                }),
        ];
    }

    private function servidor(): Servidor
    {
        /** @var Servidor $servidor */
        $servidor = $this->record;

        return $servidor;
    }
}
