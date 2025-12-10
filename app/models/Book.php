<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Book extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%book}}';
    }

    public function rules()
    {
        return [
            [['title', 'autor_id'], 'required'],
            [['autor_id', 'pages'], 'integer'],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['language'], 'string', 'max' => 50],
            [['genre'], 'string', 'max' => 100],
            ['autor_id', 'exist', 'targetClass' => Autor::class, 'targetAttribute' => ['autor_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'autor_id' => function () {
                return $this->autor_id ?: null;
            },
            'pages',
            'language',
            'genre',
            'description'
        ];
    }

    public function getAutor()
    {
        return $this->hasOne(Autor::class, ['id' => 'autor_id']);
    }
}