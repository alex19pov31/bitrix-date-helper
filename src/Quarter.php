<?php
namespace Alex19pov31\BitrixDateHelper;

use Alex19pov31\BitrixDateHelper\Traits\IntervalTrait;
use Bitrix\Main\Type\DateTime as BitrixDateTime;

class Quarter
{
    use IntervalTrait;

    /**
     * @var integer
     */
    private $num;

    public function __construct(DateTime $from, DateTime $to, int $num)
    {
        $this->from = clone $from;
        $this->to = clone $to;
        $this->num = $num;
    }

    public function getNum(): int
    {
        return (int)$this->num;
    }

    /**
     * @param DateTime|null $date
     * @return boolean
     */
    public function isCurrent($date = null): bool
    {
        $now = ($date instanceof DateTime) ? $date->getTimestamp() : time();
        return $now >= $this->getFrom()->getTimestamp() && $now <= $this->getTo()->getTimestamp();
    }

    /**
     * @param DateTime|null $date
     * @return Quarter|null
     */
    public static function getCurrent($date = null)
    {
        if ($date instanceof DateTime) {
            $list = static::getList((int)$date->format('Y'));
        } else {
            $list = static::getList();
        }

        /**
         * @var Quarter $quarter
         */
        foreach ($list as $quarter) {
            if ($quarter->isCurrent($date)) {
                return $quarter;
            }
        }

        return null;
    }

    /**
     * @param int|null $year
     * @return array
     */
    public static function getList($year = null): array
    {
        $list = [];
        $year = $year ? $year : 'Y';
        $num = 1;
        $now = DateTime::now();
        $timestamp = $now->getTimestamp();
        for ($i = 1; $i < 12; $i += 3) {

            $list[] = new static(
                DateTime::createFromFormat(
                    'd.m.Y H:i:s', 
                    date('01.' . static::formatNum($i) . '.' . $year . ' 00:00:00', $timestamp)
                ),
                static::getLastDayInMonth(
                    DateTime::createFromFormat(
                        'd.m.Y H:i:s', 
                        date('01.' . static::formatNum($i+2) . '.' . $year . ' 23:59:59')
                    )
                ),
                $num++
            );
        }

        return $list;
    }
}
