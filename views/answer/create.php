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
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['/vote/question/index']];
$this->params['breadcrumbs'][] = ['label' => $_GET['question_id'], 'url' => ['/vote/question/view', 'id' => $_GET['question_id']]];
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
                <div class="box-header with-border"><?= Yii::t('app', 'Vote') ?></div>
                <div class="box-body">
                    <?php echo $form->field($model, 'question_id')->hiddenInput(['value'=> $model->question_id])->label(false); ?>
                    <?php echo $form->field($model, 'sort')->dropDownList([1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10]) ?>


                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-file-archive-o"></i> <?= Yii::t('app', 'Create')?></button>
                    <button value="more" name="more" type="submit" class="btn btn-success btn-block"><i class="fa fa-plus-circle"></i>  <?= Yii::t('app', 'Add More')?></button>
                </div>
            </div>

        </div>
    </div>
    <?php ActiveForm::end(); ?>
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
                    <th><?= Yii::t('app', 'Status')?></th>
                    <th><?= Yii::t('app', 'Actions')?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($answers as $items):?>
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
                        <td>
                            <?php echo \abdualiym\vote\helpers\QuestionHelper::statusLabel($items->status); ?>
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
