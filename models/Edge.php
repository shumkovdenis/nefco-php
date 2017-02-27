<?php

namespace app\models;

use yii\db\ActiveRecord;

class Edge extends ActiveRecord
{
    public static function tableName()
    {
        return 'edge';
    }

    public function rules()
    {
        return [
            [['a', 'b'], 'required'],
            [['id', 'a', 'b'], 'integer'],
        ];
    }
}
