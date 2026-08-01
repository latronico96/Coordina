<?php

namespace App\DTO\Calendar;

class CalendarEventData
{
    public string $summary;

    public string $description;

    public ?string $location = null;

    public string $start;

    public string $end;

    /** @var string[] */
    public array $emails = [];

    public bool $sendUpdates = true;

    public static function make(): self
    {
        return new self;
    }

    public function summary(string $summary): static
    {
        $this->summary = $summary;

        return $this;
    }

    public function description(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function location(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function start(string $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function end(string $end): static
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @param  string[]  $emails
     */
    public function emails(array $emails): static
    {
        $this->emails = $emails;

        return $this;
    }

    public function sendUpdates(bool $sendUpdates = true): static
    {
        $this->sendUpdates = $sendUpdates;

        return $this;
    }
}
