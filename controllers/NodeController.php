<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use app\models\Node;

class NodeController extends ActiveController
{
    public $modelClass = 'app\models\Node';

    public function actions()
    {
        $actions = parent::actions();

        $actions['delete']['class'] = 'app\controllers\DeleteNodeAction';

        return $actions;
    }

    // public function actionDelete($id) {
    //   return $id;
    //     if (($model = Node::findOne($id)) !== null) {
    //         return $model;
    //     } else {
    //         throw new NotFoundHttpException('Node not found.');
    //     }
    // }
}
