<?php

namespace app\models;

use yii\db\ActiveRecord;
use app\models\Edge;

class Node extends ActiveRecord
{
    public static function tableName()
    {
        return 'node';
    }

    public function rules()
    {
        return [
            [['x', 'y', 'color'], 'required'],
            [['id', 'x', 'y'], 'integer'],
            [['color'], 'string'],
        ];
    }
}
