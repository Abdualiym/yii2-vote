<?php

$hostInfo = Yii::$app->params['frontendHostInfo'];
$lang = Yii::$app->language;

$this->registerCss("
.modal-body:not(.two-col) { padding:0px }
.glyphicon { margin-right:5px; }
.glyphicon-new-window { margin-left:5px; }
.modal-body .radio,.modal-body .checkbox {margin-top: 0px;margin-bottom: 0px;}
.modal-body .list-group {margin-bottom: 0;}
.margin-bottom-none { margin-bottom: 0; }
.modal-body .radio label,.modal-body .checkbox label { display:block; }
.modal-footer {margin-top: 0px;}
@media screen and (max-width: 325px){
    .btn-close {
        margin-top: 5px;
        width: 100%;
    }
    .btn-results {
        margin-top: 5px;
        width: 100%;
    }
    .btn-vote{
        margin-top: 5px;
        width: 100%;
    }
    
}
.modal-footer .btn+.btn {
    margin-left: 0px;
}
.progress {
    margin-right: 10px;
}");

?>
    <div class="content-section">
        <div class="votes-block">
            <div class="title-cont">
                <h3 class="title"><?= Yii::t('app', 'Your Vote')?></h3>
            </div>
            <?php foreach ($questions as $question):?>
<hr>
                <?php if($question->resultInfo->question_id == $question->id){?>
                    <? $result = $question->resultInfo->listAnswersResult($question->id);

                    ?>
                    <div class="vote-question"><?= $question->translate($question->id); ?></div>
                    <?php foreach ($question->voteAnswers as $answer_res):?>
                                <div class="progress-title"><?= $answer_res->translate($answer->id); ?> : <strong><?= $answer_res->countResult($answer_res->id); ?> <?= Yii::t('app', 'votes')?></strong></div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="<?= $result['all'];?>" style="width: <?= $answer_res->countResult($answer_res->id); ?>%;"><?= $answer_res->countResult($answer_res->id); ?>%</div>
                                </div>
                        <? endforeach; ?>

                <? }else{?>
                    <ul class="list-group">

                        <div class="vote-question"><?= $question->translate($question->id); ?></div>
                        <?php foreach ($question->voteAnswers as $answer):?>
                            <li id="<?= $question->id; ?>" class="list-group-item">
                                <div class="radio">
                                    <label>
                                        <input class="<?= $question->id; ?>-vote-check" type="radio" name="vote-radio" value="<?= $answer->id; ?>">
                                        <?= $answer->translate($answer->id); ?>

                                    </label>
                                </div>
                            </li>

                        <?php endforeach; ?>
                        <span id="vote-res-icon"></span><br>
                        <span id="<?= $question->id; ?>-vote-res-message"></span><br>
                        <span id="vote-empty" style="display: none"><?= Yii::t('app', 'Please choose one of the answers.');?></span></br>

                        <input id="<?= $question->id; ?>" class="vote-submit btn btn-info" value="Голосовать" />
                    </ul>
                <? } ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php $this->registerJs(
    "$(document).ready(function() {
    var param = $('meta[name=csrf-param]').attr('content');
    var token = $('meta[name=csrf-token]').attr('content');
    var url = '$hostInfo/$lang';           
    $(document).on('click', '.vote-submit', function(e){
        var form = $(this).attr('id');
        var id = $('.'+form+'-vote-check:checked').val();
        if(form==null){
            $('#vote-empty').show();
            setTimeout(function() { $('#vote-empty').hide(); }, 2000);
            }  
        $.ajax({
            url: url+'/vote/vote/add',
            type: 'post',
            dataType: 'json',
            data: {'ResultsForm[answer_id]': id},
            success: function(data, response, textStatus, jqXHR) {
                var message = data['message'];
               $('#'+form+'-vote-res-message').html(message);
              //$('#vote-res-icon').html('<span class=\"glyphicon glyphicon-ok\"></span>');
              setTimeout(function() {     location.reload();  }, 1000);
                       
               //$('#view-results').show();
               //$('#vote-submit').remove();
                     
           }
        });
        return false;
    });
    
});

",
    \yii\web\View::POS_READY,
    'my-button-handler'
);

?>