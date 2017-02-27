<?php

namespace app\controllers;

use Yii;
use yii\rest\Action;
use yii\web\ServerErrorHttpException;
use app\models\Edge;

class DeleteNodeAction extends Action
{
    public function run($id)
    {
        $node = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $node);
        }

        $transaction = $node->getDb()->beginTransaction();
        try {
            $node->delete();

            $edges = Edge::find()
                ->select('id')
                ->where('a = :id', [':id' => $id])
                ->orWhere('b = :id', [':id' => $id])
                ->column();

            Edge::deleteAll(['id' => $edges]);

            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        Yii::$app->getResponse()->setStatusCode(200);

        return $edges;
    }
}
