<?php


namespace Alex19pov31\BitrixDateHelper\Traits;


use Alex19pov31\BitrixDateHelper\DateTime;

trait TestTrait
{
    /**
     * @var DateTime|null
     */
    protected static $fakeDate;

    public static function setFakeDate(DateTime $date)
    {
        static::$fakeDate = $date;
    }

    public static function resetDate()
    {
        static::$fakeDate = null;
    }
}