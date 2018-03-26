<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

//use shop\helpers\SliderHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\vote\entities\Question */

$langList = \abdualiym\languageClass\Language::langList(Yii::$app->params['languages'], true);


$this->title = $question->translations[1]->question;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="vote-view">

    <p>
        <?php echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $question->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('app', 'Create answer'), ['answer/create', 'question_id' => $question->id], ['class' => 'btn btn-default']) ?>
        <?php echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $question->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete the element?'),
                'method' => 'post',
            ]
        ]) ?>
        <?php if ($question->isActive()): ?>
            <?php echo Html::a(Yii::t('app', 'Draft'), ['draft', 'id' => $question->id], ['class' => 'btn btn-default pull-right', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?php echo Html::a(Yii::t('app', 'Activate'), ['activate', 'id' => $question->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
    </p>

    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('app', 'Question')?></div>
                <div class="box-body">
                    <?php echo DetailView::widget([
                        'model' => $question,
                        'attributes' => [
                            [
                                'attribute' => 'type',
                                'value' => \abdualiym\vote\helpers\QuestionHelper::typeLabel($question->type),
                                'format' => 'raw',
                            ],
                            [
                                'attribute' => 'status',
                                'value' => \abdualiym\vote\helpers\QuestionHelper::statusLabel($question->status),
                                'format' => 'raw',
                            ],
                            'id',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('app', 'Question')?></div>
                <div class="box-body">
                    <?php echo DetailView::widget([
                        'model' => $question,
                        'attributes' => [
//                            'id',
                            [
                                'attribute' => 'createdBy.username',
                                'label' => Yii::t('app', 'Created by')
                            ],
                            [
                                'label' => Yii::t('app', 'Count Voted'),
                                'value' => $question->countQuestions($question->id)
                            ],

                            [
                                'attribute' => 'updatedBy.username',
                                'label' => Yii::t('app', 'Updated by')
                            ],
                            [
                                'attribute' => 'created_at',
                                'format' => 'datetime',
                                'label' => Yii::t('app', 'Created At')
                            ],
                            [
                                'attribute' => 'updated_at',
                                'format' => 'datetime',
                                'label' => Yii::t('app', 'Updated At')
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>


    <div class="box box-default">

        <div class="box-header with-border"><?= Yii::t('app', 'Content') ?></div>

        <div class="box-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <?php
                $j = 0;
                foreach ($question->translations as $i => $translation) {
                    if (isset($langList[$translation->lang_id])) {
                        $j++;
                        ?>
                        <li role="presentation" <?php echo $j === 1 ? 'class="active"' : '' ?>>
                            <a href="#<?php echo $langList[$translation->lang_id]['prefix'] ?>"
                               aria-controls="<?php echo $langList[$translation->lang_id]['prefix'] ?>"
                               role="tab" data-toggle="tab">
                                <?php echo '(' . $langList[$translation->lang_id]['prefix'] . ') ' . $langList[$translation->lang_id]['title'] ?>
                            </a>
                        </li>
                    <?php }
                }
                ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <br>
                <?php
                $j = 0;
                foreach ($question->translations as $i => $translation) {
                    if (isset($langList[$translation->lang_id])) {
                        $j++;
                        ?>
                        <div role="tabpanel" class="tab-pane <?php echo $j == 1 ? 'active' : '' ?>"
                             id="<?php echo $langList[$translation->lang_id]['prefix'] ?>">


                            <?php echo DetailView::widget([
                                'model' => $translation,
                                'attributes' => [
                                    'question:html',
                                ],
                            ]) ?>

                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>
    <div class="box box-default">

        <div class="box-header with-border"><?= Yii::t('app', 'Answers') ?></div>
        <a href="<?php echo Url::toRoute(['answer/create', 'question_id' => $question->id])?>" class="btn btn-info pull-right" style="margin-right: 20px;"><i class="fa fa-plus-circle"></i> <?= Yii::t('app', 'Create answer')?></a>
<br>
        <div class="box-body">
            <!-- Nav tabs -->
            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>№</th>
                    <th><?= Yii::t('app', 'Answer')?></th>
                    <th><?= Yii::t('app', 'Status')?></th>
                    <th><?= Yii::t('app', 'Count Votes')?></th>
                    <th><?= Yii::t('app', 'Actions')?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($question->voteAnswers as $items):?>
                <tr>
                    <td>
                        <?php echo $items->id; ?>
                    </td>
                    <td>
                        <?php echo $items->translations[1]->answer; ?>
                    </td>
                    <td>
                        <?php echo \abdualiym\vote\helpers\QuestionHelper::statusLabel($items->status); ?>
                    </td>
                    <td>
                        <?php echo $items->countAnswers; ?>
                    </td>
                    <td><a href="<?php echo Url::toRoute(['/vote/answer/view', 'id' => $items->id])?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                        <a href="<?php echo Url::toRoute(['/vote/answer/update', 'id' => $items->id])?>" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                        <?=Html::a('<i class="fa fa-trash"></i>', '/vote/answer/delete?id='.$items->id, [
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



</div>
