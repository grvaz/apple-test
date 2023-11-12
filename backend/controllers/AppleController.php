<?php

namespace backend\controllers;

use backend\models\Apple;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Site controller
 */
class AppleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['generate', 'index', 'fall', 'eat'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'generate' => ['post'],
                    'fall' => ['post'],
                    'eat' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Страница со списком яблок.
     *
     * @return string
     */
    public function actionIndex()
    {
        $apples = Apple::find()->all();
        return $this->render('index', compact('apples'));
    }

    /**
     * Создать яблоки.
     *
     * @return string
     * @throws Exception
     */
    public function actionGenerate()
    {
        Yii::$app->db->createCommand()->truncateTable(Apple::getTableSchema()->name)->execute();
        for ($i = 0; $i < rand(5, 20); $i++) {
            $colors = ['red', 'green', 'yellow'];
            shuffle($colors);
            $apple = new Apple($colors[0]);
            $apple->save();
        }
        return $this->redirect(['apple/index']);
    }

    /**
     * Уронить яблоко.
     * @throws Exception
     */
    public function actionFall()
    {
        $apple = $this->findModel(Yii::$app->request->post('id'));
        $apple->fallToGround();
        return $this->redirect(['apple/index']);
    }

    /**
     * Откусить яблоко.
     *
     * @throws InvalidConfigException
     * @throws Exception
     * @throws \Throwable
     */
    public function actionEat()
    {
        $params = Yii::$app->getRequest()->getBodyParams();
        $apple = $this->findModel($params['id']);
        $apple->eat($params['percent']);
        return $this->redirect(['apple/index']);
    }

    /**
     * @param $id
     * @return Apple
     * @throws Exception
     */
    private function findModel($id)
    {
        $apple = Apple::findOne(['id' => $id]);
        if (!$apple) {
            throw new Exception('Яблоко не найдено.', 404);
        }
        return $apple;
    }
}
