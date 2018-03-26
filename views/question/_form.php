<?php

use abdualiym\languageClass\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

/* @var $form yii\widgets\ActiveForm */
/* @var $model backend\modules\vote\forms\QuestionForm */
/* @var $question backend\modules\vote\entities\Question */

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

<div class="question-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <div class="row">
        <div class="col-md-8">


            <div class="box box-default">
                <div class="box-body">
                    <?= Yii::t('app', 'The form of creating question')?>
                    <?= $form->errorSummary($model) ?>
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $j = 0;
                        foreach ($model->translations as $translation) {
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
                        foreach ($model->translations as $i => $translation) {
                            if (isset($langList[$translation->lang_id])) {
                                $j++;
                                ?>
                                <div role="tabpanel" class="tab-pane <?php echo $j == 1 ? 'active' : '' ?>"
                                     id="<?php echo $langList[$translation->lang_id]['prefix'] ?>">
                                    
                                    <?php echo $form->field($translation, '[' . $i . ']question')->textarea(); ?>
                                    <?php echo $form->field($translation, '[' . $i . ']lang_id')->hiddenInput(['value' => $translation->lang_id])->label(false) ?>
                                </div>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header with-border"><?= Yii::t('app', 'The form of creating question')?></div>
                <div class="box-body">
                    <?= $form->field($model, 'type')->dropDownList($model->typesList()) ?>



                    <?php echo Html::submitButton(Yii::t('app', $this->title), ['class' => 'btn btn-success btn-block']) ?>

                </div>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
