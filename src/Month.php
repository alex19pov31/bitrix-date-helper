<?php
namespace Alex19pov31\BitrixDateHelper;

use Alex19pov31\BitrixDateHelper\Traits\IntervalTrait;
use Bitrix\Main\Type\DateTime as BitrixDateTime;

class Month
{
    use IntervalTrait;

    /**
     * @var string
     */
    private $name;

    private $num;

    public function __construct(DateTime $from, DateTime $to, string $name, int $num)
    {
        $this->from = clone $from;
        $this->to = clone $to;
        $this->name = $name;
        $this->num = $num;
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
     * @param DateTime|null $date
     * @return Month|null
     */
    public static function getCurrent($date = null)
    {
        if ($date instanceof DateTime) {
            $list = static::getList((int)$date->format('Y'));
        } else {
            $list = static::getList();
        }

        $monthId = $date ? (int)$date->format('m') : (int)date('m');
        return $list[$monthId];
    }

    /**
     * @param int|null $year
     * @return array
     */
    public static function getList($year = null): array
    {
        $list = [];
        $nameList = [
            '',
            'Январь',
            'Февраль',
            'Март',
            'Апрель',
            'Май',
            'Июнь',
            'Июль',
            'Август',
            'Сентябрь',
            'Октябрь',
            'Ноябрь',
            'Декабрь',
        ];
        $year = $year ? $year : 'Y';
        $now = DateTime::now();
        $timestamp = $now->getTimestamp();
        for ($i = 1; $i <= 12; $i++) {
            $list[$i] = new static(
                DateTime::createFromFormat('d.m.Y H:i:s', date('01.' . $i . '.' . $year . ' 00:00:00')),
                static::getLastDayInMonth('d.m.Y H:i:s', date('01.' . $i . '.' . $year . ' 23:59:59')),
                (string)$nameList[$i],
                $i
            );
        }

        return $list;
    }
}
