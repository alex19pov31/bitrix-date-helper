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

    /**
     * Текущее время
     *
     * @return DateTime
     */
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
        return new static($time, $format, $timezone);
    }

    /**
     * Начало дня Y.m.d 00:00:00
     *
     * @return DateTime
     */
    public function resetTime(): DateTime
    {
        
        $this->value = \DateTime::createFromFormat(
            'Y.m.d H:i:s', 
            $this->format('Y.m.d 00:00:00')
        );
        return $this;
    }

    /**
     * Конец дня Y.m.d 23:59:59
     *
     * @return DateTime
     */
    public function setTimeEndDay(): DateTime
    {
        $this->value = \DateTime::createFromFormat(
            'Y.m.d H:i:s', 
            $this->format('Y.m.d 23:59:59')
        );
        return $this;
    }

    public function setTime(int $hour, int $minutes, int $seconds): DateTime
    {
        $this->value = \DateTime::createFromFormat(
            'Y.m.d H:i:s', 
            $this->format(
                'Y.m.d '.
                static::formatNum($hour).':'.
                static::formatNum($minutes).':'.
                static::formatNum($seconds)
            )
        );

        return $this;
    }

    public function sub(string $interval): DateTime
    {
        $this->value->sub(new \DateInterval($interval));
        return $this;
    }

    /**
     * Вычесть секунды от текущего времени
     *
     * @param integer $countSeconds
     * @return DateTime
     */
    public function subSeconds(int $countSeconds): DateTime
    {
        return $this->sub('T'.$countSeconds.'S');
    }

    /**
     * Вычесть минуты от текущего времени
     *
     * @param integer $countMinutes
     * @return DateTime
     */
    public function subMinutes(int $countMinutes): DateTime
    {
        return $this->sub('T'.$countMinutes.'M');
    }

    /**
     * Вычесть часы от текущего времени
     *
     * @param integer $countHours
     * @return DateTime
     */
    public function subHours(int $countHours): DateTime
    {
        return $this->sub('T'.$countHours.'H');
    }


    /**
     * Вычесть дни от текущей даты
     *
     * @param integer $countDays
     * @return DateTime
     */
    public function subDays(int $countDays): DateTime
    {
        return $this->sub('P'.$countDays.'D');
    }

    /**
     * Вычесть недели от текущей даты
     *
     * @param integer $countWeeks
     * @return DateTime
     */
    public function subWeeks(int $countWeeks): DateTime
    {
        return $this->sub('P'.($countWeeks*7).'D');
    }

    /**
     * Вычесть месяцы от текущей даты
     *
     * @param integer $countMonth
     * @return DateTime
     */
    public function subMonth(int $countMonth): DateTime
    {
        return $this->sub('P'.$countMonth.'M');
    }

    /**
     * Вычесть годы от текущей даты
     *
     * @param integer $countYears
     * @return DateTime
     */
    public function subYears(int $countYears): DateTime
    {
        return $this->sub('P'.$countYears.'Y');
    }

    /**
     * Прибавить секунды к текущему времени
     *
     * @param integer $countSeconds
     * @return DateTime
     */
    public function addSeconds(int $countSeconds): DateTime
    {
        return $this->add('T'.$countSeconds.'S');
    }

    /**
     * Прибавить минуты к текущему времени
     *
     * @param integer $countMinutes
     * @return DateTime
     */
    public function addMinutes(int $countMinutes): DateTime
    {
        return $this->add('T'.$countMinutes.'M');
    }

    /**
     * Прибавить часы к текущему времени
     *
     * @param integer $countHours
     * @return DateTime
     */
    public function addHours(int $countHours): DateTime
    {
        return $this->add('T'.$countHours.'H');
    }

    /**
     * Прибавить дни к текущему времени
     *
     * @param integer $countDays
     * @return DateTime
     */
    public function addDays(int $countDays): DateTime
    {
        return $this->add('P'.$countDays.'D');
    }

    /**
     * Прибавить недели к текущему времени
     *
     * @param integer $countWeeks
     * @return DateTime
     */
    public function addWeeks(int $countWeeks): DateTime
    {
        return $this->add('P'.($countWeeks*7).'D');
    }

    /**
     * Прибавить месяцы к текущему времени
     *
     * @param integer $countMonth
     * @return DateTime
     */
    public function addMonth(int $countMonth): DateTime
    {
        return $this->add('P'.$countMonth.'M');
    }

    /**
     * Прибавить года к текущему времени
     *
     * @param integer $countYears
     * @return DateTime
     */
    public function addYears(int $countYears): DateTime
    {
        return $this->add('P'.$countYears.'Y');
    }

    public function getOrginalValue(): \DateTime
    {
        return $this->value;
    }

    public function diff(DateTime $datetime2, bool $absolute = false): DateInterval
    {
        return $this->value->diff($datetime2->getOrginalValue(), $absolute);
    }

    private static function formatNum(int $num): string
    {
        return $num < 10 ? '0'.$num : $num;
    }
}
