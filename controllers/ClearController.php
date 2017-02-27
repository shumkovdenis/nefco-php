<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Node;
use app\models\Edge;

class ClearController extends Controller
{
    public function actionIndex()
    {
        Node::deleteAll();
        Edge::deleteAll();

        Yii::$app->getResponse()->setStatusCode(204);
    }
}
