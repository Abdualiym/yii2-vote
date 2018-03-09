<?php

/* @var $this yii\web\View */
/* @var $model backend\modules\vote\forms\QuestionForm */

$this->title = 'Добавить';
?>
<div class="question-create">

    <?php echo $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
