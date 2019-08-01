<?php
namespace Alex19pov31\BitrixDateHelper;

use Alex19pov31\BitrixDateHelper\Traits\IntervalTrait;

class Day
{
    use IntervalTrait;

    /**
     * @var integer
     */
    private $numOfWeek;

    /**
     * @var string
     */
    private $name;

    public function __construct(DateTime $currentDate)
    {
        $this->from = new DateTime($currentDate->format('d.m.Y 00:00:00'));
        $this->to = new DateTime($currentDate->format('d.m.Y 23:59:59'));
        $this->numOfWeek = (int)$currentDate->format('N');
        $this->name = (string)static::getListRusNames()[$this->numOfWeek];
    }

    public function getNumOfWeek(): int
    {
        return (int)$this->numOfWeek;
    }

    public function getName(): string
    {
        return (string)$this->name;
    }

    /**
     * @param DateTime|null $date
     * @return Day|null
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

    private static function getListRusNames(): array
    {
        return [
            '',
            'Понедельник',
            'Вторник',
            'Среда',
            'Четверг',
            'Пятница',
            'Суббота',
            'Воскресенье',
        ];
    }
}
