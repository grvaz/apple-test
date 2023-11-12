<?php

use backend\models\Apple;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var array $apples */
/** @var Apple $apple */

$this->title = 'Я-я-яблоки ела';
?>
<div class="site-index">
    <?php $form = ActiveForm::begin(['action' =>['apple/generate']]); ?>
    <div class="form-group">
        <?= Html::submitButton('Создать яблоки', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Цвет</th>
                <th>Осталось</th>
                <th>Состояние</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($apples as $apple): ?>
        <tr>
            <td>Яблоко-<?= $apple->id ?></td>
            <td><?= $apple->color ?></td>
            <td><?= $apple->size ?></td>
            <td><?= $apple->status ?></td>
            <td>
                <?php if ($apple->status === Apple::STATUS_HANGING): ?>
                <?php $form = ActiveForm::begin(['action' =>['apple/fall']]); ?>
                <?= Html::hiddenInput('id', $apple->id) ?>
                <?= Html::submitButton('Уронить', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
                <?php endif; ?>
            </td>
            <td>
                <?php $form = ActiveForm::begin(['action' =>['apple/eat']]); ?>
                <?= Html::hiddenInput('id', $apple->id) ?>
                <?= Html::input('number', 'percent', 25) ?>%
                <?= Html::submitButton('Откусить', ['class' => 'btn btn-primary']) ?>
                <?php ActiveForm::end(); ?>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>