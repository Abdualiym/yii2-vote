<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\vote\forms\QuestionForm */


$this->title = Yii::t('app', 'Create question');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Question'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-create">

    <?php

    echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
