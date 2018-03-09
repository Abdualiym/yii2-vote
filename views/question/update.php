<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\vote\entities\Question */
/* @var $question backend\modules\vote\forms\QuestionForm */


$this->title = 'Update: №-' . $_GET['id'];
?>
<div class="vote-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'question' => $question,
    ]) ?>

</div>
