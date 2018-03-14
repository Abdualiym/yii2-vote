<?php

/* @var $this yii\web\View */

$this->title = 'Голосования';
?>
<div class="site-index">

    <div class="body-content">

        <div class="row">
            <?php echo \abdualiym\vote\widgets\vote\Vote::widget(); ?>
        </div>

    </div>
</div>
