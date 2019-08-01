<?php
namespace Alex19pov31\BitrixDateHelper;

use Alex19pov31\BitrixDateHelper\Traits\IntervalTrait;
use DateTime;
use Bitrix\Main\Type\DateTime as BitrixDateTime;

class Week
{
    use IntervalTrait;

    private $dayList;

    public function __construct(DateTime $date)
    {
        $dayOfWeek = (int)$date->format('N');
        $from = $date->sub(new \DateInterval('P' . ($dayOfWeek - 1) . 'D'));
        $this->from = new DateTime($from->format('Y-m-d 00:00:00'));
        $this->to = new DateTime($from->format('Y-m-d 23:59:59'));
        for ($i = 1; $i <= 7; $i++) {
            $this->dayList[$i] = new Day($this->to);
            $this->to->add(new \DateInterval('P1D'));
        }
    }

    public function getNum(): int
    {
        return (int)$this->num;
    }

    public function getName(): string
    {
        return (string)$this->name;
    }

    /**
     * @param integer $num
     * @return Day|null
     */
    public function getDayByNum(int $num)
    {
        return $this->dayList[$num];
    }

    /**
     * @return Day|null
     */
    public function getFirstDay()
    {
        return $this->getDayByNum(1);
    }

    /**
     * @return Day|null
     */
    public function getLastDay()
    {
        return $this->getDayByNum(7);
    }

    /**
     * @param DateTime|null $date
     * @return Week|null
     */
    public static function getCurrent($date = null)
    {
        if ($date instanceof DateTime) {
            $currentDate = $date;
        } else {
            $currentDate = new DateTime();
        }

        return new static($currentDate);
    }

    public function getPrevWeek(int $count = 1): Week
    {
        $day = $this->from->sub(new \DateInterval('P' . ($count * 7) . 'D'));
        return new static($day);
    }

    public function getNextWeek(int $count = 1): Week
    {
        $day = $this->from->add(new \DateInterval('P' . ($count * 7) . 'D'));
        return new static($day);
    }
}
