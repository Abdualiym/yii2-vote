<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//use shop\helpers\AnswerHelper;

/* @var $this yii\web\View */
/* @var $model abdualiym\vote\entities\Answer */

$langList = \abdualiym\languageClass\Language::langList(Yii::$app->params['languages'], true);


$this->title = $answer->translations[1]->answer;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['/vote/question/index']];
$this->params['breadcrumbs'][] = ['label' => preg_replace("#(.{,10}).*#", "$1", $answer->question->id), 'url' => ['/vote/question/view', 'id' => $answer->question_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="vote-view">

    <p>
        <?php echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $answer->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $answer->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete the element?'),
                'method' => 'post',
            ]
        ]) ?>
        <?php if ($answer->isActive()): ?>
            <?php echo Html::a(Yii::t('app', 'Draft'), ['draft', 'id' => $answer->id], ['class' => 'btn btn-default pull-right', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?php echo Html::a(Yii::t('app', 'Activate'), ['activate', 'id' => $answer->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
    </p>

    <br>
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border"><?= Yii::t('app', 'Vote')?></div>
                <div class="box-body">
                    <?php echo DetailView::widget([
                        'model' => $answer,
                        'attributes' => [
                            'sort',

                            [
                                'label' => Yii::t('app', 'Count Voted'),
                                'value' => $answer->countAnswers
                            ],
                            [
                                'label' => Yii::t('app', 'Question'),
                                'value' => $answer->question->translate($answer->question->id)
                            ],

                            [
                                'attribute' => 'status',
                                'value' => \abdualiym\vote\helpers\AnswerHelper::statusLabel($answer->status),
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
                <div class="box-header with-border"><?= Yii::t('app', 'Answer')?></div>
                <div class="box-body">
                    <?php echo DetailView::widget([
                        'model' => $answer,
                        'attributes' => [
//                            'id',
                            [
                                'attribute' => 'createdBy.username',
                                'label' => Yii::t('app', 'Created by')
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

        <div class="box-header with-border"><?= Yii::t('app', 'Content')?></div>

        <div class="box-body">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <?php
                $j = 0;
                foreach ($answer->translations as $i => $translation) {
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
                foreach ($answer->translations as $i => $translation) {
                    if (isset($langList[$translation->lang_id])) {
                        $j++;
                        ?>
                        <div role="tabpanel" class="tab-pane <?php echo $j == 1 ? 'active' : '' ?>"
                             id="<?php echo $langList[$translation->lang_id]['prefix'] ?>">
                            <?php echo DetailView::widget([
                                'model' => $translation,
                                'attributes' => [
                                    'answer:html',
                                ],
                            ]) ?>

                        </div>
                    <?php }
                } ?>
            </div>
        </div>
    </div>

</div>
