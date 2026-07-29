<?php

namespace App\Filament\Resources\Invitacions\Tables;

use App\Services\InvitacionService;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InvitacionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('rol')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state->label())
                    ->color(fn ($state) => $state->color()),

                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->state(function ($record) {

                        if ($record->accepted_at) {
                            return 'Aceptada';
                        }

                        if ($record->expires_at->isPast()) {
                            return 'Vencida';
                        }

                        return 'Pendiente';
                    })
                    ->color(function ($state) {
                        return match ($state) {
                            'Aceptada' => 'success',
                            'Pendiente' => 'warning',
                            'Vencida' => 'danger',
                        };
                    }),

                TextColumn::make('expires_at')
                    ->label('Vence')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('usuario.name')
                    ->label('Usuario')
                    ->placeholder('-')
                    ->searchable(),
            ])

            ->filters([
                //
            ])

            ->recordActions([

                ViewAction::make(),

                Action::make('reenviar')
                    ->icon('heroicon-o-envelope')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->hidden(fn ($record, InvitacionService $service) => ! $service->valida($record))
                    ->action(function ($record, InvitacionService $service) {
                        if (! $service->valida($record)) {

                            Notification::make()
                                ->title('La invitación ya no es válida')
                                ->warning()
                                ->send();

                            return;
                        }
                        $service->enviar($record);
                        Notification::make()
                            ->title('Invitación reenviada')
                            ->success()
                            ->send();
                    }),
                Action::make('copiar')
                    ->icon('heroicon-o-link')
                    ->color('gray')
                    ->action(function () {

                        Notification::make()
                            ->title('Próximamente')
                            ->body('Aquí copiaremos el enlace de invitación.')
                            ->info()
                            ->send();
                    }),

                Action::make('renovar')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->hidden(fn ($record) => $record->accepted_at !== null)
                    ->action(function ($record, InvitacionService $service) {
                        if ($record->accepted_at) {
                            Notification::make()
                                ->title('La invitación ya fue aceptada')
                                ->warning()
                                ->send();

                            return;
                        }
                        $service->renovarYEnviar($record);
                        Notification::make()
                            ->title('Invitación renovada')
                            ->body('Se renovo la invitacion.')
                            ->success()
                            ->send();
                    }),

            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
