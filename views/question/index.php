<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\vote\forms\QuestionSearch */

$this->title = Yii::t('vote', 'Questions');

$this->params['breadcrumbs'][] = $this->title;


?>
<a href="<?php echo Url::toRoute(['question/create'])?>" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= Yii::t('vote', 'Create question')?></a>
<br>
<div class="panel">
    <table class="table table-hover">
        <thead>
        <th></th>
        <th>ID </th>
        <th>&nbsp;<i aria-hidden="true"></i><?= Yii::t('vote', 'Question'); ?></th>
        <th><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Number of Votes')?></th>
        <th><i class="fa fa-hourglass-o" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Status')?></th>
        <th><i class="fa fa-navicon" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Type')?></th>
        <th>&nbsp;<i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Actions')?></th>
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
                    <h5><?= Yii::t('vote', 'Answer') ?> > <?= Yii::t('vote', 'Question') ?> > <?php echo $model->id; ?></h5><br>
                    <a href="<?php echo Url::toRoute(['answer/create', 'question_id' => $model->id])?>" class="btn btn-info"><i class="fa fa-plus-circle"></i> <?= Yii::t('vote', 'Create answer')?></a>
                    <br>
                    <?php if($model->voteAnswers == null):?>
                        <span><?= Yii::t('vote', 'There are no answers!')?></span><hr>
                    <?php endif; ?>


                        <table class="table">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th><?= Yii::t('vote', 'Sort')?></th>
                                <th><?= Yii::t('vote', 'Answers') ?></th>
                                <th><?= Yii::t('vote', 'Number of Votes')?></th>
                                <th><?= Yii::t('vote', 'Status')?></th>
                                <th><?= Yii::t('vote', 'Actions')?></th>
                            </tr>
                            </thead>
                            <tbody style="background-color: #e8ecf4">
                            <?php foreach ($model->voteAnswers as $items):?>

                            <tr>

                                <td><?php echo $items->id; ?></td>
                                <td><?php echo $items->sort; ?></td>
                                <td><?php echo $items->translate($items->id); ?></td>
                                <td><?php echo $items->countAnswers; ?></td>
                                <td><?php echo \abdualiym\vote\helpers\QuestionHelper::statusLabel($items->status); ?></td>
                                <td><a href="<?php echo Url::toRoute(['/vote/answer/view', 'id' => $items->id])?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                    <a href="<?php echo Url::toRoute(['/vote/answer/update', 'id' => $items->id])?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    <?=Html::a('<i class="fa fa-trash"></i>', '/vote/answer/delete?id='.$items->id, [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => Yii::t('vote', 'Are you sure you want to delete the element?'),
                                            'method' => 'post',
                                        ],

                                    ])?></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>





                </div>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>



