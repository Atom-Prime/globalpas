<?php
namespace app\controllers;

use app\models\Book;
use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\Autor;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class AutorsController extends ActiveController
{
    public $modelClass = Autor::class;

    public function actions()
    {
        $arActions = parent::actions();
        unset($arActions['index']);
        unset($arActions['update']);
        unset($arActions['delete']);
        return $arActions;
    }

    public function actionIndex()
    {
        $obQuery = Autor::find();

        $obProvider = new ActiveDataProvider([
            'query' => $obQuery,
        ]);

        return $obProvider;
    }

    public function actionCreate()
    {
        $obAutor = new Autor();
        $obAutor->load(Yii::$app->request->getBodyParams(), '');
        if ($obAutor->save()) {
            Yii::$app->getResponse()->setStatusCode(200);
            return $obAutor;
        }
        return $obAutor;
    }

    public function actionUpdate($id)
    {
        $obAutor = Autor::findOne($id);
        if (!$obAutor) {
            throw new NotFoundHttpException(sprintf('Автор с id:%s не найден', $id));
        }
        self::checkParams($arParams = Yii::$app->request->getBodyParams());
        $obAutor->load($arParams, '');
        if (!$obAutor->save()) {
            throw new BadRequestHttpException('Ошибка при обновлении автора');
        }
        return $obAutor;
    }

    public function actionDelete($id)
    {
        throw new NotFoundHttpException('Удаление автора запрещено');

    }

    public static function checkParams(array $arParams)
    {
        if (isset($arParams['birth_year']) && !is_numeric($arParams['birth_year'])) {
            throw new BadRequestHttpException('Год рождения должен быть числом');
        }

        if ($arParams['birth_year'] > date("Y")) {
            throw new BadRequestHttpException('Дата рождения не может быть больше текущей');
        }

    }
}
