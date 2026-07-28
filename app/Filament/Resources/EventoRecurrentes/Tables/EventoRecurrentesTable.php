<?php

namespace App\Filament\Resources\EventoRecurrentes\Tables;

use App\Filament\Resources\Eventos\EventoResource;
use App\Services\EventoService;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class EventoRecurrentesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('dia_semana')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        1 => 'Lunes',
                        2 => 'Martes',
                        3 => 'Miércoles',
                        4 => 'Jueves',
                        5 => 'Viernes',
                        6 => 'Sábado',
                        7 => 'Domingo',
                    }),

                TextColumn::make('hora_inicio'),

                IconColumn::make('activo')
                    ->boolean(),
            ])
            ->filters([
                TernaryFilter::make('activo'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('generarEvento')
                    ->label('Generar evento')
                    ->icon('heroicon-o-calendar-days')
                    ->modalHeading('Generar evento')
                    ->modalDescription('Se creará un nuevo evento copiando los roles del evento recurrente.')
                    ->modalSubmitActionLabel('Crear evento')
                    ->schema([
                        DatePicker::make('fecha')
                            ->label('Fecha del evento')
                            ->default(fn ($record) => $record->proximaFecha())
                            ->native(false)
                            ->closeOnDateSelection()
                            ->required(),
                    ])
                    ->action(function (array $data, $record) {

                        $evento = app(EventoService::class)
                            ->crearDesdeRecurrente(
                                $record,
                                Carbon::parse($data['fecha'])
                            );

                        Notification::make()
                            ->title('Evento creado correctamente')
                            ->success()
                            ->send();

                        return redirect(
                            EventoResource::getUrl('edit', [
                                'record' => $evento,
                            ])
                        );
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
