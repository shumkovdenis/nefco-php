<?php

namespace app\controllers;

use yii\rest\Controller;
use app\models\Dijkstra;

class DijkstraController extends Controller
{
    public function actionIndex($a, $b)
    {
        $dijkstraModel = new Dijkstra();
        $res = $dijkstraModel->find($a, $b);

        return $res;
    }
}
