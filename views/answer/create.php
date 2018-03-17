<?php

use abdualiym\languageClass\Language;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */

/* @var $form yii\widgets\ActiveForm */
/* @var $model backend\modules\vote\forms\AnswerForm */
/* @var $question backend\modules\vote\entities\Answer */

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

$this->title = Yii::t('app', 'Create answer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Answer'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="slide-form">
<h3>Вопрос: </h3>
    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8">
            <div class="box box-default">
                <div class="box-body">
                    <?= Yii::t('app', 'Create answer')?>

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

                                    <?php echo $form->field($translation, '[' . $i . ']answer')->textarea(); ?>
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
                <div class="box-header with-border">Vote</div>
                <div class="box-body">
                    <?php echo $form->field($model, 'question_id')->hiddenInput(['value'=> $model->question_id])->label(false); ?>
                    <?php echo $form->field($model, 'sort')->dropDownList([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10]) ?>
                    <?php echo Html::submitButton('<i class="fa fa-plus-circle"></i> Добавить ещё', ['class' => 'btn btn-success btn-block']) ?>
                </div>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>

    <div class="col-md-12">
        <h3><?= Yii::t('app', 'The list of answers associated with this question')?></h3>
        <table class="table">
            <thead>
            <tr>
                <th>№</th>
                <th><?= Yii::t('app', 'Name')?></th>
                <th><?= Yii::t('app', 'Order of')?></th>
                <th><?= Yii::t('app', 'Actions')?></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($answers as $item_answers):?>
                <tr>
                    <td><?php echo $item_answers->id; ?></td>
                    <td><?php echo $item_answers->translations[1]->answer; ?></td>
                    <td><?php echo $item_answers->sort; ?></td>
                    <td>
                        <a href="<?php echo Url::toRoute(['view', 'id' => $item_answers->id])?>" class="btn btn-info"><i class="fa fa-eye"></i></a> |
                        <a href="<?php echo Url::toRoute(['update', 'id' => $item_answers->id])?>" class="btn btn-warning"><i class="fa fa-edit"></i></a> |

                        <?=Html::a('delete', 'delete?id='.$item_answers->id, [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete the element?'),
                                'method' => 'post',
                            ],

                        ])?>

                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>

</div>
