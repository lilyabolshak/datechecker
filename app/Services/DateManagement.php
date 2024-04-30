<?php

namespace App\Services;

use App\Models\Holiday;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class DateManagement
{
    /**
     * @var ?string
     */
    protected $holidayName;

    /**
     * @var Collection
     */
    protected $holidays;

    /**
     * @param \DateTime $date
     * @return bool
     * @throws \Exception
     */
    public function isHoliday(\DateTime $date): bool
    {
        $currentDay = date('N', $date->getTimestamp());

        foreach ($this->getHolidays() as $holiday) {
            if ($this->checkOnDateHoliday($date, $holiday)) {
                $this->holidayName = $holiday->getName();
                return true;
            }

            if ($this->isDateOnRangeHoliday($date, $holiday)) {
                $this->holidayName = $holiday->getName();
                return true;
            }

            if ($this->checkSpecificDayOfWeekHoliday($date, $holiday)) {
                $this->holidayName = $holiday->getName();
                return true;
            }
        }

        //if it is Monday need to check Saturday or Sunday
        if ($currentDay == 1) {
            $newDateToCheck = new \DateTime($date->format('Y-m-d'));
            $nearestSunday = $newDateToCheck->modify('-1 day');
            if ($this->isHoliday($nearestSunday)) {
                return true;
            }

            $nearestSaturday = $newDateToCheck->modify('-1 day');
            return $this->isHoliday($nearestSaturday);
        }

        return false;
    }

    /**
     * @return Collection
     */
    public function getHolidays(): Collection
    {
        if ($this->holidays == null) {
            $this->holidays = Holiday::all();
        }

        return $this->holidays;
    }

    /**
     * @return string|null
     */
    public function getHolidayName(): ?string
    {
        return $this->holidayName;
    }

    /**
     * @param \DateTime $date
     * @param Holiday $holiday
     * @return bool
     */
    protected function checkOnDateHoliday($date, $holiday): bool
    {
        if (!$holiday->getDate()) {
            return false;
        }

        return Carbon::instance($date)->isSameAs('m-d', $holiday->getDate());
    }

    /**
     * @param \DateTime $date
     * @param Holiday $holiday
     * @return bool
     * @throws \Exception
     */
    protected function isDateOnRangeHoliday($date, $holiday): bool
    {
        if ($holiday->getDate() || !$holiday->getStartDate() || !$holiday->getEndDate()) {
            return false;
        }

        $year = $date->format('Y');
        $startDate = new \DateTime($holiday->getStartDate());
        $endDate = new \DateTime($holiday->getEndDate());

        return Carbon::instance($date)->isBetween(
            $startDate->format($year . '-m-d'),
            $endDate->format($year . '-m-d')
        );
    }

    /**
     * We need to decide how the first week of the month will be determined. The ISO 8601 standard defines the first week of the YEAR as: ordinal number which identifies a calendar week within its
     * calendar year according to the rule that the first calendar week of a year is that one which includes the first Thursday of that year and that the last calendar week of a calendar year is the
     * week immediately preceding the first calendar week of the next calendar year.  There is nothing in this standard about the first week of the month because, the definition varies by country and
     * is definite in larbor laws. In most countries it is considered  that the 1st week of a month must follow the same ISO rules as the 1st week of the year
     *
     * @param \DateTime $date
     * @param Holiday $holiday
     * @return bool
     * @throws \Exception
     */
    protected function checkSpecificDayOfWeekHoliday($date, $holiday): bool
    {
        if (!$holiday->getWeekNumber() || !$holiday->getDayOfWeek() || !$holiday->getMonth()) {
            return false;
        }

        $lastDayOfMonth = date('t', $date->getTimestamp());
        $dayOfMonth = date('j', $date->getTimestamp());
        $firstDayOfMonth = date('Y-m-01', $date->getTimestamp());
        $dayOfWeek = date('N', strtotime($firstDayOfMonth));
        $currentDay = date('N', $date->getTimestamp());
        $currentMonth = date('n', $date->getTimestamp());

        if ($holiday->getDayOfWeek() != $currentDay
            || $holiday->getMonth() != $currentMonth) {
            return false;
        }

        //if first day of the month is date from Monday to Thursday (ISO)
        if ($dayOfWeek <= 4) {
            $weekInMonth = (int) ceil($lastDayOfMonth / 7);
            $currentWeek = (int) ceil($dayOfMonth / 7);
        } else {
            $dateObject = new \DateTime($firstDayOfMonth);
            $firstDate = $dateObject->modify('next monday');
            $firstDayOfMonth = $firstDate->format('Y-m-d');

            $offset = date('j', strtotime($firstDayOfMonth)) - 1;
            $weekInMonth = (int) ceil(($lastDayOfMonth - $offset)/ 7);
            $currentWeek = (int) ceil(($dayOfMonth - $offset) / 7);
        }

        // if $holiday->getWeekNumber() == -1 it means last week in the month
        if ($holiday->getWeekNumber() == $currentWeek
            || ($holiday->getWeekNumber() == -1 && $currentWeek == $weekInMonth)) {
            return true;
        }

        return false;
    }
}
