<?php

use abdualiym\languageClass\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model abdualiym\vote\forms\AnswerForm */
/* @var $question abdualiym\vote\entities\Answer */

$langList = Language::langList(Yii::$app->params['languages'], true);
foreach ($model->translations as $i => $translation) {
    if (!$translation->lang_id) {
        $q = 0;
        foreach ($langList as $k => $l) {
            if ($i == $q) {
                $translation->lang_id = $k;
            }
            $q++;
        }
    }
}
?>

<div class="slide-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-body">
                    <?= $form->errorSummary($model) ?>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $j = 0;
                        foreach ($model->translations as $translation) {
                            if (isset($langList[$translation->lang_id])) {
                                $j++;
                                ?>
                                <li role="presentation" <?= $j === 1 ? 'class="active"' : '' ?>>
                                    <a href="#<?= $langList[$translation->lang_id]['prefix'] ?>"
                                       aria-controls="<?= $langList[$translation->lang_id]['prefix'] ?>"
                                       role="tab" data-toggle="tab">
                                        <?= '(' . $langList[$translation->lang_id]['prefix'] . ') ' . $langList[$translation->lang_id]['title'] ?>
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
                        foreach ($model->translations as $i => $translation) {
                            if (isset($langList[$translation->lang_id])) {
                                $j++;
                                ?>
                                <div role="tabpanel" class="tab-pane <?= $j == 1 ? 'active' : '' ?>"
                                     id="<?= $langList[$translation->lang_id]['prefix'] ?>">

                                    <?= $form->field($translation, '[' . $i . ']answer')->textarea(); ?>
                                    <?= $form->field($translation, '[' . $i . ']lang_id')->hiddenInput(['value' => $translation->lang_id])->label(false) ?>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border">Vote</div>
                <div class="box-body">
                    <?= $form->field($model, 'vote_id')->hiddenInput(['value'=> $model->vote_id])->label(false); ?>
                    <?= $form->field($model, 'sort')->dropDownList([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10]) ?>
                    <?= Html::submitButton('<i class="fa fa-edit"></i> Изменить', ['class' => 'btn btn-success btn-block']) ?>
                </div>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
