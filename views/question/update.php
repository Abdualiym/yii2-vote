<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\vote\entities\Question */
/* @var $question backend\modules\vote\forms\QuestionForm */


$this->title = Yii::t('app', 'Update');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Question'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $question->translations[1]->question, 'url' => ['view', 'id' => $question->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="vote-update">
    <?php echo $this->render('_form', [
        'model' => $model,
        'question' => $question,
    ]) ?>
</div>
