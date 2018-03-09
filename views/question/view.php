<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

//use shop\helpers\SliderHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\vote\entities\Question */

$langList = \abdualiym\languageClass\Language::langList(Yii::$app->params['languages'], true);
?>
<div class="vote-view">

    <p>
        <?php echo Html::a('Изменить', ['update', 'id' => $question->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Удалить', ['delete', 'id' => $question->id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => 'Вы хотите удалить?',
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
                <div class="box-header with-border">Vote</div>
                <div class="box-body">
                    <?php echo DetailView::widget([
                        'model' => $question,
                        'attributes' => [
                            'type',
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
                <div class="box-header with-border">Vote</div>
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

        <div class="box-header with-border">Контент</div>

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

</div>
