<?php

namespace backend\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Widget;



class NavPanel extends Widget
{

	//public $title;

	public function init()
	{
/* 		if ($this->title === null) {
			$this->title = Yii::t('categories', 'Категории');
		} */
	}


	public function run()
	{
		$connection = \Yii::$app->db;
		$command = $connection->createCommand('SELECT * FROM divisions WHERE parentID=0 ORDER BY priority');
		$divisions = $command->queryAll();
		
		$get_str = explode('/', $_GET['r']);
		$unicKey = $get_str[0];
		
		$current_div = (new \yii\db\Query())
			->select('*')
			->from('divisions')
			->where('unicKey=:key', [':key' => $unicKey])
			->one();
			
		$parent_div = (new \yii\db\Query())
			->select('*')
			->from('divisions')
			->where('id=:key', [':key' => $current_div['parentID']])
			->one();

		
		$inner_html = '';
		foreach ($divisions as $division) {
			$command = $connection->createCommand('SELECT * FROM divisions WHERE parentID=:parentID ORDER BY priority LIMIT 1');
			$command->bindValue(':parentID', $division['id']);
			$first_sub_div = $command->queryOne();

			$inner_html .= '<li>'.Html::a($division['name'], [$first_sub_div['unicKey'].'/index'], ['class' => 'btn btn-default'.($parent_div['id']==$division['id']?' active':'')]).'</li>';
		} 
		$inner_html = '<ul class="nav-panel">'.$inner_html.'</ul>';
		
		$command = $connection->createCommand('SELECT * FROM divisions WHERE parentID=:parentID ORDER BY priority');
		$command->bindValue(':parentID', $parent_div['id']);
		$sub_divisions = $command->queryAll();
		
		$inner_html2 = '';
		foreach ($sub_divisions as $sub_division) {
			$inner_html2 .= '<li>'.Html::a($sub_division['name'], [$sub_division['unicKey'].'/index'], ['class' => 'btn btn-default'.($unicKey==$sub_division['unicKey']?' active':'')]).'</li>';
		} 
		$inner_html2 = '<ul class="nav-subpanel">'.$inner_html2.'</ul>';
		
		echo $inner_html.$inner_html2;

/* 		$models = Category::find()->published()->orderBy('ordering')->asArray()->all();
		
		// Рендерим представление
    	echo $this->render('index', [
    		'models' => $models,
    		'title' => $this->title
    	]); */
  	}
}
