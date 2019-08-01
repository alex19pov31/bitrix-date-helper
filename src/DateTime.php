<?php
namespace Alex19pov31\BitrixDateHelper;

use Alex19pov31\BitrixDateHelper\Traits\TestTrait;
use Bitrix\Main\Type\DateTime as BitrixDateTime;
use DateInterval;

class DateTime extends BitrixDateTime
{
    use TestTrait;

    public function __construct($time = null, $format = null, \DateTimeZone $timezone = null)
    {
        if (!$time && static::$fakeDate && static::$fakeDate instanceof DateTime) {
            return static::$fakeDate;
        }

        parent::__construct($time, $format, $timezone);
    }

    public static function now(): DateTime
    {
        return new static();
    }

    /**
     * Объект дня
     *
     * @return Day
     */
    public function getExtDay(): Day
    {
        return new Day($this);
    }

    /**
     * Объект недели
     *
     * @return Week
     */
    public function getExtWeek(): Week
    {
        return Week::getCurrent($this);
    }

    /**
     * Объект месяца
     *
     * @return Month
     */
    public function getExtMonth(): Month
    {
        return Month::getCurrent($this);
    }

    /**
     * Объект квартала
     *
     * @return Quarter
     */
    public function getExtQuarter(): Quarter
    {
        return Quarter::getCurrent($this);
    }

    /**
     * @param string $format
     * @param string $time
     * @param DateTimeZone|null $timezone
     * @return DateTime
     */
    public static function createFromFormat( string $format , string $time , $timezone = null) : DateTime
    {
        $dateTime = \DateTime::createFromFormat($format, $timezone, $timezone);
        return new static($dateTime);
    }

    public function sub(DateInterval $interval): DateTime
    {
        return new static($this->value->sub($interval));
    }

    public function getOrginalValue(): \DateTime
    {
        return $this->value;
    }

    public function diff(DateTime $datetime2, bool $absolute = false): DateInterval
    {
        return $this->value->diff($datetime2->getOrginalValue(), $absolute);
    }
}
