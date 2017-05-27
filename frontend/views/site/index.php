<?php

/* @var $this yii\web\View */
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

$script = <<< JS
    $(":checkbox").click(function() { 
    if($(":checked").length>5) this.checked = false; 
  }); 
JS;
$this->registerJs($script, yii\web\View::POS_LOAD);

$this->title = 'My Yii Application';
?>
<div class="site-index">


    <div class="body-content">

        <div class="row">
          
         <?php $form = ActiveForm::begin(); ?>


    <?php
    /*foreach ($ingr as $ingr_c)
    {
      echo  Html::activeCheckbox($ingr_c, 'active', ['class' => 'agreement']);
    }*/
    echo Html::CheckboxList('ingr', 'id', ArrayHelper::map($ingr, 'id', 'name')) 
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>    
            
            
        </div>

        
        
        <div class="row">
            
            <?php
            if($mess) 
            {echo $mess;} 
            else{
                
           
        echo ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_dishes',
]);
            }
            
            ?>
            
            
        </div>
        
    </div>
</div>
