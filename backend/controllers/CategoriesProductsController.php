<?php

namespace backend\controllers;

use backend\controllers;
use backend\functions\Functions;

use Yii;
use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;


class CategoriesProductsController extends \yii\web\Controller
{

	public function behaviors()
	{
		return [
			'access' => [
				'class' => 'yii\filters\AccessControl',
				'rules' => [
					['allow' => true, 'actions' => ['index'], 'roles' => ['@']]
				],
			],
		];
	}
	
/* 	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction'
			]
		];
	} */

    public function actionIndex()
    {
		$categoryID = (int)(isset($_GET['categoryID'])?$_GET['categoryID']:1);
		$out = Functions::catGetCategoryCompactCList( $categoryID );
		
		$searchModel = new ProductSearch();

		if (Yii::$app->request->post('ProductSearch')) {
			//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
			$dataProvider = $searchModel->search(['ProductSearch'=>['name'=>Yii::$app->request->post('ProductSearch')['name']]]);

		} else {
			$dataProvider = new ActiveDataProvider([
				'query' => Product::find()->where(['categoryID' => $categoryID]),
				'pagination' => [
					'pageSize' => 10,
				],
			]);
		}

		
		
		

		// get the posts in the current page
		//$posts = $dataProvider->getModels();


        return $this->render('index', [
    		'categories_tree' => $out,
    		'categoryID' => $categoryID,
			
		    'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
    	]);
    }

}
