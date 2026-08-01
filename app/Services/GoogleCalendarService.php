<?php

namespace App\Services;

use App\DTO\Calendar\CalendarEventData;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventAttendee;
use Google\Service\Calendar\EventDateTime;
use Google\Service\Calendar\EventReminders;
use RuntimeException;

class GoogleCalendarService
{
    private const TIMEZONE = 'America/Argentina/Buenos_Aires';

    private Calendar $calendar;

    public function __construct()
    {
        $client = new Client;

        $client->setClientId(
            config('services.google.client_id')
        );

        $client->setClientSecret(
            config('services.google.client_secret')
        );

        $client->fetchAccessTokenWithRefreshToken(
            config('services.google.refresh_token')
        );

        $this->calendar = new Calendar($client);
    }

    public function crearEvento(
        string $calendarId,
        CalendarEventData $data,
    ): string {
        $evento = new Event;

        $evento->setSummary($data->summary);
        $evento->setDescription($data->description);
        $evento->setLocation($data->location);

        $evento->setStart(
            $this->crearFecha($data->start)
        );

        $evento->setEnd(
            $this->crearFecha($data->end)
        );

        $evento->setAttendees(
            $this->crearInvitados($data)
        );

        $evento->setReminders(
            $this->crearReminders()
        );

        $googleEvent = $this->calendar
            ->events
            ->insert(
                $calendarId,
                $evento,
                [
                    'sendUpdates' => $data->sendUpdates
                        ? 'all'
                        : 'none',
                ]
            );

        $id = $googleEvent->getId();

        if (! $id) {
            throw new RuntimeException(
                'Google Calendar no devolvió el ID del evento.'
            );
        }

        return $id;
    }

    public function actualizarEvento(
        string $calendarId,
        string $googleEventId,
        CalendarEventData $data,
    ): void {
        $evento = $this->calendar
            ->events
            ->get(
                $calendarId,
                $googleEventId,
            );

        $evento->setSummary($data->summary);
        $evento->setDescription($data->description);
        $evento->setLocation($data->location);

        $evento->setStart(
            $this->crearFecha($data->start)
        );

        $evento->setEnd(
            $this->crearFecha($data->end)
        );

        $evento->setAttendees(
            $this->crearInvitados($data)
        );

        $this->calendar
            ->events
            ->update(
                $calendarId,
                $googleEventId,
                $evento,
                [
                    'sendUpdates' => $data->sendUpdates
                        ? 'all'
                        : 'none',
                ]
            );
    }

    public function eliminarEvento(
        string $calendarId,
        string $googleEventId,
    ): void {
        $this->calendar
            ->events
            ->delete(
                $calendarId,
                $googleEventId,
                [
                    'sendUpdates' => 'all',
                ]
            );
    }

    private function crearFecha(
        string $dateTime,
    ): EventDateTime {
        $fecha = new EventDateTime;

        $fecha->setDateTime($dateTime);
        $fecha->setTimeZone(self::TIMEZONE);

        return $fecha;
    }

    /**
     * @return EventAttendee[]
     */
    private function crearInvitados(
        CalendarEventData $data,
    ): array {
        return array_map(
            function (string $email): EventAttendee {
                $invitado = new EventAttendee;

                $invitado->setEmail($email);

                return $invitado;
            },
            $data->emails,
        );
    }

    private function crearReminders(): EventReminders
    {
        $reminders = new EventReminders;

        $reminders->setUseDefault(true);

        return $reminders;
    }
}
