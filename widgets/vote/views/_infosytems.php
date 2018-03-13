<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.03.2018
 * Time: 1:56
 */
?>
<div class="votes-block">
    <div class="title-cont">
        <h3 class="title"><?= Yii::t('app', 'Your voice');?></h3>
    </div>
    <div class="vote-question" id="vote-question-id">Какими услугами Вы пользуетесь больше всего?</div>
    <ul class="vote-choise" id="vote-choise-id">

    </ul>
    <div class="text-center">
        <span id="vote-res-message"></span>
        <span id="vote-res-icon"></span>
    </div>
    <a id="vote-submit" class="btn btn-primary vote-btn"><?= Yii::t('app', 'Vote');?></a>
</div>

<?php $this->registerJs(
    "$(document).ready(function() {
    var param = $('meta[name=csrf-param]').attr('content');
    var token = $('meta[name=csrf-token]').attr('content');
    $.ajax({
            url: 'vote/votes/listvote',
            type: 'get',
            dataType: 'json',
            success: function(data, response, textStatus, jqXHR) {
                    var vote = data['vote'];
                    var message = data['message'];
                   $('#vote-question-id').remove();
                   $('#vote-res-message').html(message);
                if (data.status === 1) {
                   var content = '';
                        for(var i in data['answers']){
                         var answer = data['answers'][i].answer;
                         var id = data['answers'][i].id;
                        content += '<li><label><input class=\"vote-check\" type=\"radio\" name=\"vote-radio\" value=\"'+id+'\">'+answer+'</label></li>'
                        }
                        $('#vote-choise-id').html(content);
                }else {
                    $('#vote-submit').remove();
                }
            }
        });
    $(document).on('click', '#vote-submit', function(e){
        var form = $('.vote-check:checked').val();
        $.ajax({
            url: 'vote/votes/vote',
            type: 'post',
            dataType: 'json',
            data: {'selected': form, 'param': token},
            success: function(data, response, textStatus, jqXHR) {
                var message = data['message'];
           if(data['status'] === 1){
               
               $('#vote-choise-id').html('');
               $('#vote-res-message').html(message);
               $('#vote-choise-id').remove();
               $('#vote-submit').remove();
            }else{
                    
                    $('#vote-res-message').html(message);
                }           
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
