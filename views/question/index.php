<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\vote\forms\QuestionSearch */

$this->title = Yii::t('app', 'Questions');

$this->params['breadcrumbs'][] = $this->title;


?>
<a href="<?php echo Url::toRoute(['question/create'])?>" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= Yii::t('app', 'Create question')?></a>
<br>
<div class="panel">
    <table class="table table-hover">
        <thead>
        <th></th>
        <th>ID </th>
        <th>&nbsp;<i aria-hidden="true"></i><?= Yii::t('app', 'Question'); ?></th>
        <th><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<?= Yii::t('app', 'Count Votes')?></th>
        <th><i class="fa fa-hourglass-o" aria-hidden="true"></i>&nbsp;<?= Yii::t('app', 'Status')?></th>
        <th><i class="fa fa-navicon" aria-hidden="true"></i>&nbsp;<?= Yii::t('app', 'Type')?></th>
        <th>&nbsp;<i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?= Yii::t('app', 'Actions')?></th>
        </thead>

        <tbody>
        <?php foreach ($models  as $model):?>
        <tr>
            <td data-toggle="collapse" data-target="#accordion-<?php echo $model->id; ?>" class="clickable text-center" ><i class="fa fa-plus-circle"></i></td>
            <td>   <?php echo $model->id; ?></td>
            <td  data-toggle="collapse" data-target="#accordion-<?php echo $model->id; ?>" class="clickable"><?php echo $model->translations['1']->question; ?></td>
            <td><?php echo $model->countQuestions($model->id); ?></td>
            <td>
                <?php echo \abdualiym\vote\helpers\QuestionHelper::statusLabel($model->status); ?>
            </td>
            <td><?php echo \abdualiym\vote\helpers\QuestionHelper::typeLabel($model->type); ?></td>

            <td>
                <a class="btn btn-info" href="<?php echo Url::toRoute(['question/view', 'id' => $model->id])?>" class=""><i class="fa fa-eye"></i></a>
                <a class="btn btn-warning" href="<?php echo Url::toRoute(['question/update', 'id' => $model->id])?>" class=""><i class="fa fa-edit"></i></a>
            </td>

        </tr>
        <tr>
            <td colspan="4">

                <div id="accordion-<?php echo $model->id; ?>" class="collapse">
                    <h5><?= Yii::t('app', 'Answer') ?> > <?= Yii::t('app', 'Question') ?> > <?php echo $model->id; ?></h5><br>
                    <a href="<?php echo Url::toRoute(['answer/create', 'question_id' => $model->id])?>" class="btn btn-info pull-right"><i class="fa fa-plus-circle"></i> <?= Yii::t('app', 'Create answer')?></a>
                    <br>
                    <?php if($model->voteAnswers == null):?>
                        <span><?= Yii::t('app', 'There are no answers!')?></span><hr>
                    <?php endif; ?>

                    <?php foreach ($model->voteAnswers as $items):?>
                        <hr>
                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b>ID:</b> <?php echo $items->id; ?></br>
                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;<b><?= Yii::t('app', 'Sort')?>:</b> <?php echo $items->sort; ?></br>
                        <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;<b><?= Yii::t('app', 'Answers') ?>:</b> <?php echo $items->translations[1]->answer; ?></br>
                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbsp;<b><?= Yii::t('app', 'Count Votes')?>: </b><?php echo $items->countAnswers; ?></br>
                        <i class="" aria-hidden="true"></i>&nbsp;<b><?= Yii::t('app', 'Status')?>: </b>
                <?php echo \abdualiym\vote\helpers\QuestionHelper::statusLabel($items->status); ?>
            </br>
            </br>
                        <i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<b><?= Yii::t('app', 'Actions')?>: </b>
                            <a href="<?php echo Url::toRoute(['/vote/answer/view', 'id' => $items->id])?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                            <a href="<?php echo Url::toRoute(['/vote/answer/update', 'id' => $items->id])?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                            <?=Html::a('<i class="fa fa-trash"></i>', '/vote/answer/delete?id='.$items->id, [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete the element?'),
                                    'method' => 'post',
                                ],

                            ])?></br>
                    <?php endforeach; ?>

                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>



