<?php

namespace backend\controllers;

class ProductListsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
