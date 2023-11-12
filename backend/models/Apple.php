<?php

namespace backend\models;

use DateInterval;
use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * Class Apple
 * @package backend\models
 *
 * @property string $status
 * @property string $color
 * @property int $eaten
 * @property double $size
 * @property int $dateAppear
 * @property int $dateFall
 */
class Apple extends ActiveRecord
{
    public const STATUS_HANGING = 'hanging';
    public const STATUS_FELL = 'fell';
    public const STATUS_ROTTEN = 'rotten';

    public function __construct(string $color = 'green')
    {
        parent::__construct();
        $this->setDateAppear();
        $this->color = $color;
    }

    /**
     * Откусить яблоко.
     * @param int $percent
     * @throws Exception
     * @throws \Throwable
     */
    public function eat(int $percent)
    {
        $errors = [
            self::STATUS_HANGING => 'Невозможно есть несорванный фрукт.',
            self::STATUS_ROTTEN => 'Нельзя есть просрочку!',
        ];
        if (isset($errors[$this->status])) {
            throw new Exception($errors[$this->status]);
        }
        $this->eaten += abs($percent);
        if ($this->eaten >= 100) {
            $this->delete();
            return;
        }
        $this->save();
    }

    /**
     * Остаток яблока.
     * @return float
     */
    public function getSize() : float
    {
        return (100 - $this->eaten) / 100;
    }

    /**
     * Статус яблока.
     * @return string
     */
    public function getStatus() : string
    {
        if ($this->dateFall && ((time() - $this->dateFall) >= 5 * 3600)) {
            return self::STATUS_ROTTEN;
        }
        return $this->dateFall ? self::STATUS_FELL : self::STATUS_HANGING;
    }

    /**
     * Задать рандомную дату появления яблока.
     */
    public function setDateAppear()
    {
        $this->dateAppear = (new \DateTime())
            ->add(DateInterval::createFromDateString(
                '-' . rand(1, 999999) .' seconds'
            ))->getTimestamp();
    }

    /**
     * Уронить яблоко.
     */
    public function fallToGround()
    {
        $this->dateFall = (new \DateTime())->getTimestamp();
        $this->save();
    }

}