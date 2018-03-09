<?php

/* @var $this yii\web\View */
/* @var $model abdualiym\vote\entities\Question */
/* @var $question abdualiym\vote\forms\QuestionForm */


$this->title = 'Update: №-' . $_GET['id'];
?>
<div class="vote-update">

    <?= $this->render('_form', [
        'model' => $model,
        'question' => $question,
    ]) ?>

</div>
