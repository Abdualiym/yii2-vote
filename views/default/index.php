<?php

/* @var $this yii\web\View */

$this->title = 'Голосования';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?= \abdualiym\vote\widgets\vote\Vote::widget(); ?>
        </div>

    </div>
</div>
