<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\vote\forms\QuestionSearch */

$this->title = Yii::t('app', 'Questions');

$this->params['breadcrumbs'][] = $this->title;


?>
<div class="col-md-8">
    <a href="<?php echo Url::toRoute(['question/create'])?>" class="btn btn-default"><i class="fa fa-plus-circle"></i> <?= Yii::t('app', 'Create question')?></a>
    <br>
    </br>


    <div class="panel-group" id="accordion">
        <?php foreach ($models  as $model):?>
        <div class="panel panel-default">
            <div class="panel-heading">

                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour<?php echo $model->id; ?>">
                        №: <?php echo $model->id; ?>  <?= Yii::t('app', 'Name')?>: <?php echo $model->translations['1']->question; ?>
                    </a>
                <span  style="padding-left: 10px;"><?= Yii::t('app', 'Count Votes')?>: <?php echo $model->countQuestions; ?></span>
                        <span class="col-md-3 pull-right"><a href="<?php echo Url::toRoute(['question/view', 'id' => $model->id])?>" class=""><i class="fa fa-eye"></i></a>
                                                    <a href="<?php echo Url::toRoute(['question/update', 'id' => $model->id])?>" class=""><i class="fa fa-edit"></i></a>
                           </span>

            </div>
            <div id="collapseFour<?php echo $model->id; ?>" class="panel-collapse collapse">
                <div class="panel-body">

                    <div class="box box-default">

                        <div class="box-header with-border"><?= Yii::t('app', 'Answers') ?></div>

                        <div class="box-body">
                            <!-- Nav tabs -->

                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th><?= Yii::t('app', 'Answer')?></th>
                                    <th><?= Yii::t('app', 'Count Votes')?></th>
                                    <th><?= Yii::t('app', 'Actions')?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($model->voteAnswers as $items):?>
                                    <tr>
                                        <td>
                                            <?php echo $items->id; ?>
                                        </td>
                                        <td>
                                            <?php echo $items->translations[1]->answer; ?>
                                        </td>
                                        <td>
                                            <?php echo $items->countAnswers; ?>
                                        </td>
                                        <td><a href="<?php echo Url::toRoute(['answer/view', 'id' => $items->id])?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                            <a href="<?php echo Url::toRoute(['answer/update', 'id' => $items->id])?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                            <?=Html::a('<i class="fa fa-trash"></i>', 'answer/delete?id='.$items->id, [
                                                'class' => 'btn btn-danger',
                                                'data' => [
                                                    'confirm' => Yii::t('app', 'Are you sure you want to delete the element?'),
                                                    'method' => 'post',
                                                ],

                                            ])?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php if($model->voteAnswers == null):?>
                        <span><?= Yii::t('app', 'There are no answers!')?></span><hr>
                   <?php endif; ?>
                    <a href="<?php echo Url::toRoute(['answer/create', 'question_id' => $model->id])?>" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= Yii::t('app', 'Create answer')?></a>
                </div>
            </div>

        </div>
        <?php endforeach; ?>

    </div>
</div>

