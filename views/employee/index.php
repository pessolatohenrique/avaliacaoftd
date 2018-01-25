<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\DateHelper;

$this->title = 'Colaboradores';
$this->params['breadcrumbs'][] = $this->title;

if (strlen($searchModel->birth_date) == 10) {
    $searchModel->birth_date = DateHelper::toBrazilian($searchModel->birth_date);
}

?>
<div class="employee-index">

    <div class="box box-primary">
        <div class="box-body">
            <?php echo $this->render('_search', [
                'model' => $searchModel
            ]); ?>
            <p>
                
            </p>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'options' => ['class' => 'table-responsive'],
                'columns' => [

                    'fullName',
                    'gender',
                    'birth_date',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>

