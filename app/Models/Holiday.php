<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    use HasFactory;

    const DATE = 'date';
    const START_DATE = 'start_date';
    const END_DATE = 'end_date';
    const WEEK_NUMBER = 'week_number';
    const DAY_OF_WEEK = 'day_of_week';
    const MONTH = 'month';
    const NAME = 'name';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @return ?string
     */
    public function getDate(): ?string
    {
        return $this->{self::DATE};
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setDate(string $date): self
    {
        $this->{self::DATE} = $date;

        return $this;
    }

    /**
     * @return ?string
     */
    public function getStartDate(): ?string
    {
        return $this->{self::START_DATE};
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setStartDate(string $date): self
    {
        $this->{self::START_DATE} = $date;

        return $this;
    }

    /**
     * @return ?string
     */
    public function getEndDate(): ?string
    {
        return $this->{self::END_DATE};
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setEndDate(string $date): self
    {
        $this->{self::END_DATE} = $date;

        return $this;
    }

    /**
     * @return ?int
     */
    public function getWeekNumber(): ?int
    {
        return $this->{self::WEEK_NUMBER};
    }

    /**
     * @param int $weekNumber
     * @return $this
     */
    public function setWeekNumber(int $weekNumber): self
    {
        $this->{self::WEEK_NUMBER} = $weekNumber;

        return $this;
    }

    /**
     * @return ?int
     */
    public function getDayOfWeek(): ?int
    {
        return $this->{self::DAY_OF_WEEK};
    }

    /**
     * @param int $dayOfWeek
     * @return $this
     */
    public function setDayOfWeek(int $dayOfWeek): self
    {
        $this->{self::DAY_OF_WEEK} = $dayOfWeek;

        return $this;
    }

    /**
     * @return ?int
     */
    public function getMonth(): ?int
    {
        return $this->{self::MONTH};
    }

    /**
     * @param int $month
     * @return $this
     */
    public function setMonth(int $month): self
    {
        $this->{self::MONTH} = $month;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->{self::NAME};
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->{self::NAME} = $name;

        return $this;
    }
}
