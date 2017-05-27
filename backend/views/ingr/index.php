<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\IngrSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ingrs';
$this->params['breadcrumbs'][] = $this->title;
$url=Url::toRoute(['ingr/changestatusogingr']);
$script = <<< JS
    function changestatusogingr(active, id) {
        $.ajax({
      type: "POST",
  url: "$url",
  data: {
            'id': id,
        'active': active,
          
        },
  success: function(data){
        alert(data);
}
    });
    }
JS;
$this->registerJs($script, yii\web\View::POS_BEGIN);
?>
<div class="ingr-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить ингридиент', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'desc:ntext',
            [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{check} {view} {update} {delete}',
                        'buttons' => [
                            
                                    
                                    
                            'check' => function ($url,$model) {
                                
                                if ($model->active=='yes') {
                                    return Html::checkbox('status', true,  ['class' => 'agreement', 'value' => $model->active,  'onclick' => 'changestatusogingr(this.value, '.$model->id.')']); 
                                } else
                                {
                                   return Html::checkbox('status', false,  ['class' => 'agreement', 'value' => $model->active,  'onclick' => 'changestatusogingr(this.value, '.$model->id.')']); 
                                }

                            },

                        ],
                    ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
