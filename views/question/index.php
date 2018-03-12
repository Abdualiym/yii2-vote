<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\vote\forms\QuestionSearch */

$this->title = Yii::t('app', 'Questions');

$this->params['breadcrumbs'][] = $this->title;
$this->registerCss("
.faqHeader {
    font-size: 27px;
    margin: 20px;
}

.panel-heading [data-toggle=\"collapse\"]:after {
    font-family: 'FontAwesome';
    content: \"\f078\"; /* \"play\" icon */
    float: right;
    color: #F58723;
    font-size: 18px;
    line-height: 32px;
    /* rotate \"play\" icon from > (right arrow) to down arrow */
/*    -webkit-transform: rotate(-90deg);
    -moz-transform: rotate(-90deg);
    -ms-transform: rotate(-90deg);
    -o-transform: rotate(-90deg);
    transform: rotate(-90deg); */
}

.panel-heading [data-toggle=\"collapse\"].collapsed:after {
    /* rotate \"play\" icon from > (right arrow) to ^ (up arrow) */
/*    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg); */
    color: #454444;
}
.panel-heading a{
 margin-left: 8px;
 font-size: 16px;
}
.panel-body a{
 margin-left: 8px;
}

");

?>
<div class="col-md-8">
    <a href="<?php echo Url::toRoute(['question/create'])?>" class="btn btn-default"><i class="fa fa-plus-circle"></i> Добавить вопрос</a>
    <br>
    </br>
    <div class="panel-group" id="accordion">
        <?php foreach ($models  as $model):?>
        <div class="panel panel-default">
            <div class="panel-heading">

                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour<?php echo $model->id; ?>">
                        <?php echo $model->id; ?> | <?php echo $model->translations['1']->question; ?>
                    </a>
<span class="pull-right"><a href="<?php echo Url::toRoute(['question/view', 'id' => $model->id])?>" class=""><i class="fa fa-eye"></i></a>
                            <a href="<?php echo Url::toRoute(['question/update', 'id' => $model->id])?>" class=""><i class="fa fa-edit"></i></a>
    <?=Html::a('', 'question/delete?id='.$model->id, [
        'class' => 'fa fa-trash',
        'data' => [
            'confirm' => 'Are you sure you want to delete the campaign?',
            'method' => 'post',
        ],

    ])?></span>

            </div>
            <div id="collapseFour<?php echo $model->id; ?>" class="panel-collapse collapse">
                <div class="panel-body">

                    <?php foreach ($model->voteAnswers as $items):?>
                        <h3 style="font-size: 16px" ><?php echo $items->id; ?> | <?php echo $items->translations[1]->answer; ?>
                            <span class="pull-right">
                            <a href="<?php echo Url::toRoute(['answer/view', 'id' => $items->id])?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            <a href="<?php echo Url::toRoute(['answer/update', 'id' => $items->id])?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                <?=Html::a('delete', 'answer/delete?id='.$items->id, [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete the campaign?',
                                        'method' => 'post',
                                    ],

                                ])?>
                            </span>
                        </h3>
                        <hr>
                    <?php endforeach; ?>
                    <?php if($model->voteAnswers == null):?>
                        <span>Нет ответов!</span><hr>
                   <?php endif; ?>
                    <a href="<?php echo Url::toRoute(['answer/create', 'question_id' => $model->id])?>" class="btn btn-info"><i class="fa fa-plus-circle"></i> Добавить ответ</a>
                </div>
            </div>

        </div>
        <?php endforeach; ?>

    </div>
</div>

