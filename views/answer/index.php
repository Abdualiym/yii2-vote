<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\vote\forms\QuestionSearch */


$this->title = Yii::t('app', 'Answers');

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="answer-index">

    <p>
        <?php echo Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'question_id',
            [
                'attribute' => 'id',
                'value' => function (\abdualiym\vote\entities\Answer $model) {
                    return $model->translations[1]->answer;
                },
                'label' => 'Name',
            ],
            'sort',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
