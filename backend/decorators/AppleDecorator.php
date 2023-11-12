<?php
namespace backend\decorators;

use backend\models\Apple;

class AppleDecorator
{
    public function getStatus(Apple $apple)
    {
        $statuses = [
            Apple::STATUS_HANGING => 'Висит',
            Apple::STATUS_FELL => 'Лежит',
            Apple::STATUS_ROTTEN => 'Гнилое',
        ];
        return $statuses[$apple->status] ?? '';
    }
}