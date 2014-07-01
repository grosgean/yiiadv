<?php
/**
 * @var yii\web\View $this
 */
 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
 
?>
<h1>categories-products/index</h1>

<table>
	<tr>
		<td valign="top">
			<ul>
			<?php
				foreach ($categories_tree as $category) {
					if ($category['categoryID'] != 1) {
						echo '<li>';
						echo str_repeat('<span class="tab">&nbsp;</span>', $category['level']-1);
						echo '<a href='.(\Yii::$app->urlManager->createUrl(['categories-products/index', 'categoryID'=> $category['categoryID']])).'>'.$category['name'].'</a>';
						echo '</li>';
					}
				}
			?>
			</ul>
			
			<?= Html::submitButton('Добавить категорию', ['class' => 'btn goto', 'rel'=> \Yii::$app->urlManager->createUrl(['category/create'])]); ?>
		</td>
		
		<td valign="top">

			<p>
				<?php if ($categoryID != 1) { ?>
				<?= Html::submitButton('Редактировать категорию', ['class' => 'btn goto', 'rel'=> \Yii::$app->urlManager->createUrl(['category/update', 'id'=>$categoryID])]); ?>
				<?= Html::submitButton('Добавить продукт', ['class' => 'btn goto', 'rel'=> \Yii::$app->urlManager->createUrl(['product/create', 'categoryID'=>$categoryID])]); ?>
				<?php } ?>
			</p>

			<?= GridView::widget([
				'dataProvider' => $dataProvider,
				/* 'filterModel' => $searchModel, */
				'columns' => [
					['class' => 'yii\grid\SerialColumn'],

					'product_code',
					'name',
					'Price',
					'in_stock',
					['class' => 'backend\components\MyActionColumn'],
					//['class' => 'yii\grid\ActionColumn'],
				],
			]); ?>
			
			<div class="category-form">

				<?php $form = ActiveForm::begin([
					'options' => ['class' => 'form-horizontal'],
					'fieldConfig' => [
						'template' => "{label}\n<div class='col-md-10'>{input}</div>\n<div class='col-md-offset-2 col-md-10'>{error}</div>",
						'labelOptions'=> ['class'=>'control-label col-md-2'],
					],
				]); ?>

				<input class="form-control" type="text" name="ProductSearch[name]">


				<div class="form-group">
					<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
				</div>

				<?php ActiveForm::end(); ?>

			</div>



		</td>
	</tr>
</table>