<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m231112_054019_seed_test_user
 */
class m231112_054019_seed_test_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = new User();
        $user->username = 'test';
        $user->password_hash = \Yii::$app->getSecurity()->generatePasswordHash('pass12345');
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->email = 'test@mail.ru';
        $user->status = 10;
        $user->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        User::findOne(['username' => 'test'])->delete();
    }
}
