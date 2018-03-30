<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model backend\modules\vote\forms\QuestionSearch */

$this->title = Yii::t('vote', 'Questions');

$this->params['breadcrumbs'][] = $this->title;


?>
<a href="<?php echo Url::toRoute(['question/create'])?>" class="btn btn-success" style="margin: 0px 10px 10px 0px;"><i class="fa fa-plus-circle"></i> <?= Yii::t('vote', 'Create question')?></a>
<br>
<div class="panel">
    <table class="table table-hover">
        <thead>
        <th>№</th>
        <th>&nbsp;<i aria-hidden="true"></i><?= Yii::t('vote', 'Question'); ?></th>
        <th><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Number of Votes')?></th>
        <th><i class="fa fa-hourglass-o" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Status')?></th>
        <th><i class="fa fa-navicon" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Type')?></th>
        <th class="pull-right"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Actions')?></th>
        </thead>

        <tbody>
        <?php $i = 0; foreach ($models  as $model): $i++;?>
        <tr  style="background-color: #e8ecf4">
            <td><?php echo $i; ?></td>
            <td width="200px"  data-toggle="collapse" data-target="#accordion-<?php echo $model->id; ?>" class="clickable"><?php echo $model->translate($model->id); ?></td>
            <td data-toggle="collapse" data-target="#accordion-<?php echo $model->id; ?>" class="clickable" ><?php echo $model->countQuestions($model->id); ?></td>
            <td data-toggle="collapse" data-target="#accordion-<?php echo $model->id; ?>" class="clickable" >
                <?php echo \abdualiym\vote\helpers\QuestionHelper::statusLabel($model->status); ?>
            </td>
            <td><?php echo \abdualiym\vote\helpers\QuestionHelper::typeLabel($model->type); ?></td>

            <td class="pull-right">
                <a class="btn btn-info" href="<?php echo Url::toRoute(['question/view', 'id' => $model->id])?>" class=""><i class="fa fa-eye"></i></a>
                <a class="btn btn-warning" href="<?php echo Url::toRoute(['question/update', 'id' => $model->id])?>" class=""><i class="fa fa-edit"></i></a>
            </td>

        </tr>
        <tr>
            <td colspan="6" style="padding: 0px;">
                <div id="accordion-<?php echo $model->id; ?>" class="collapse">
                    <?php if($model->voteAnswers == null):?>
                        <span><?= Yii::t('vote', 'There are no answers!')?></span><hr>
                    <?php endif; ?>
                        <table class="table" style="background-color: #e8ecf4">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th><?= Yii::t('vote', 'Answers') ?></th>
                                <th><i class="fa fa-check" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Number of Votes')?></th>
                                <th><i class="fa fa-hourglass-o" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Status')?></th>
                                <th><i class="fa fa-navicon" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Sort')?></th>
                                <th class="pull-right"><i class="fa fa-credit-card" aria-hidden="true"></i>&nbsp;<?= Yii::t('vote', 'Actions')?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php  $j = 0; foreach ($model->voteAnswers as $items): $j++;?>
                            <tr>
                                <td><?php echo $j; ?></td>
                                <td width="200px;"><?php echo $items->translate($items->id); ?></td>
                                <td><?php echo $items->countAnswers; ?></td>
                                <td><?php echo \abdualiym\vote\helpers\QuestionHelper::statusLabel($items->status); ?></td>
                                <td><?php echo $items->status; ?></td>
                                <td class="pull-right"><a href="<?php echo Url::toRoute(['/vote/answer/view', 'id' => $items->id])?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                    <a href="<?php echo Url::toRoute(['/vote/answer/update', 'id' => $items->id])?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    <?=Html::a('<i class="fa fa-trash"></i>', '/vote/answer/delete?id='.$items->id, [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => Yii::t('vote', 'Are you sure you want to delete the element?'),
                                            'method' => 'post',
                                        ],

                                    ])?>
                                </td>
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



