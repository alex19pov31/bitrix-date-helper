<?php
namespace Alex19pov31\BitrixDateHelper\Traits;

use Alex19pov31\BitrixDateHelper\DateTime;

trait IntervalTrait
{
    /**
     * @var DateTime
     */
    protected $from;

    /**
     * @var DateTime
     */
    protected $to;

    public function getFrom(): DateTime
    {
        return $this->from;
    }

    public function getTo(): DateTime
    {
        return $this->to;
    }

    /**
     * @param DateTime $date
     * @return DateTime
     */
    public static function getLastDayInMonth(DateTime $date): DateTime
    {
        $strDate = $date->format('Y-m-t H:i:s');
        return DateTime::createFromFormat('Y-m-d H:i:s', $strDate);
    }
}