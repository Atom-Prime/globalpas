<?php
namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\models\Book;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;


class BookController extends ActiveController
{
    public $modelClass = Book::class;


    public function actions()
    {
        $arActions = parent::actions();
        unset($arActions['index']);
        unset($arActions['delete']);
        unset($arActions['update']);

        return $arActions;
    }

    public function actionIndex()
    {
        $request = Yii::$app->request;
        $obQuery = Book::find()->with('autor');
        $search = $request->get('search');
        if ($search !== null && $search !== '') {
            $obQuery->andWhere(['or',
                ['ilike', 'title', $search],
                ['ilike', 'description', $search],
            ]);
        }

        $arAutors = $request->get('autor');
        if ($arAutors !== null && $arAutors !== '') {
            $arAutors = array_map('intval', $arAutors);
            if (!empty($arAutors)) {
                $obQuery->andWhere(['autor_id' => $arAutors]);
            }
        }

        $obProvider = new ActiveDataProvider([
            'query' => $obQuery,
        ]);

        return $obProvider;
    }

    public function actionCreate()
    {
        $obBook = new Book();
        $obBook->load(Yii::$app->request->getBodyParams(), '');

        if ($obBook->save()) {
            Yii::$app->getResponse()->setStatusCode(200);
            return $obBook;
        }
        return $obBook;
    }

    public function actionUpdate($id)
    {
        $obBook = Book::findOne($id);
        if (!$obBook) {
            throw new NotFoundHttpException(sprintf('Книга с id:%s не найдена', $id));
        }
        $obBook->load(Yii::$app->request->getBodyParams(), '');
        if (!$obBook->save()) {
           throw new BadRequestHttpException('Ошибка при обновлении книги');
        }
        return $obBook;
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $obBook = Book::findOne($id);
        if ($obBook === null) {
            throw new NotFoundHttpException(sprintf('Книга с id:%s не найдена', $id));
        }

        if ($obBook->delete() === false) {
            Yii::$app->response->statusCode = 500;
            return [
                'status' => 'error',
                'message' => sprintf('Ошибка удаления книги с id:%s', $id)
            ];
        }

        Yii::$app->response->statusCode = 200;
        return [
            'status' => 'success',
            'message' => 'Книга успешно удалена'
        ];
    }
}
