<?php

namespace App\Helpers;

use App\Models\Event;
class Carbon extends \Carbon\Carbon
{
    private array $holidays = [];

    public function addBusinessDays(int $nb): Carbon
    {
        if($nb > 0) {
            for($a = 0; $a < $nb; $a++) {
                $this->addBusinessDay();
            }
        }

        return $this;
    }

    public function addBusinessDay(): Carbon
    {
        if($this->isFriday()) {
            $this->addDays(3);
        } elseif($this->isSaturday()) {
            $this->addDays(2);
        } else {
            $this->addDay();
        }

        // Check for holidays
        while(!$this->isBusinessDay()) {
            $this->addBusinessDay();
        }
        return $this;
    }

    public function isBusinessDay(): bool
    {
        return !$this->isWeekend() && !$this->isHoliday();
    }

    public function diffInBusinessDays($date): int
    {
        return $this->diffInDaysFiltered(function ($date) {
            return $date->isBusinessDay();
        }, $date);
    }

    public function diffInBusinessHours($date): int
    {
        return $this->diffInHoursFiltered(function ($date) {
            return $date->isBusinessDay();
        }, $date);
    }

    public function getHolidays(): array
    {
        return $this->holidays;
    }

    public function setHolidays(array $holidays = []): Carbon
    {
        if (empty($holidays))
            $this->holidays = Event::query()->whereYear('start', '=', date('Y'))
                ->pluck('start')->toArray();
        else
            $this->holidays = $holidays;

        if (!$this->isBusinessDay())
            $this->addBusinessDay();

        return $this;
    }

    public function isHoliday(): bool
    {
        return in_array($this->format('Y-m-d'), $this->holidays);
    }

    /**
     * @param $day dd-mm-yyyy
     * Ex: $this->addHoliday('06-12-2018');
     * @return Carbon
     */
    public function addHoliday($day): Carbon
    {
        if(preg_match('/^[0-9]{2}-[0-9]{2}-20[0-9]{2}$/', $day)) {
            $this->holidays[] = $day;
        }
        if (!$this->isBusinessDay())
            $this->addBusinessDay();

        return $this;
    }
}
