<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Autor extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%autor}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['birth_year'], 'integer'],
            [['country'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 255],
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
            'name',
            'birth_year',
            'country'
        ];
    }

    public function getBooks()
    {
        return $this->hasMany(Book::class, ['autor_id' => 'id']);
    }
}