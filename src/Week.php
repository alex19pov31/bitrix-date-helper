<?php
namespace Alex19pov31\BitrixDateHelper;

use Alex19pov31\BitrixDateHelper\Traits\IntervalTrait;

class Week
{
    use IntervalTrait;

    private $dayList;

    public function __construct(DateTime $date)
    {
        $dayOfWeek = (int)$date->format('N');
        $from = $date->subDays($dayOfWeek - 1);
        $this->from = new DateTime($from->format('Y-m-d 00:00:00'), 'Y-m-d H:i:s');
        $this->to = new DateTime($from->format('Y-m-d 23:59:59'), 'Y-m-d H:i:s');
        for ($i = 1; $i <= 7; $i++) {
            $this->dayList[$i] = new Day($this->to);
            $this->to->addDays(1);
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
     * Понедельник
     *
     * @return Day|null
     */
    public function getMonday()
    {
        return $this->getDayByNum(1);
    }

    /**
     * Вторник
     *
     * @return Day|null
     */
    public function getTuesday()
    {
        return $this->getDayByNum(2);
    }

    /**
     * Среда
     *
     * @return Day|null
     */
    public function getWednesday()
    {
        return $this->getDayByNum(3);
    }

    /**
     * Четверг
     *
     * @return Day|null
     */
    public function getThursday()
    {
        return $this->getDayByNum(4);
    }

    /**
     * Пятница
     *
     * @return Day|null
     */
    public function getFriday()
    {
        return $this->getDayByNum(5);
    }

    /**
     * Суббота
     *
     * @return Day|null
     */
    public function getSaturday()
    {
        return $this->getDayByNum(6);
    }

    /**
     * Воскресенье
     *
     * @return Day|null
     */
    public function getSunday()
    {
        return $this->getDayByNum(7);
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
        $date = $this->from->subWeeks(1);
        return new static($date);
    }

    public function getNextWeek(int $count = 1): Week
    {
        $date = $this->from->addWeeks(1);
        return new static($date);
    }
}
