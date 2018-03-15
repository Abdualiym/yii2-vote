<?php
/**
 * Created by PhpStorm.
 * User:
 * User
 * Date: 13.03.2018
 * Time: 1:56
 */

$hostInfo = Yii::$app->params['frontendHostInfo'];
$lang = Yii::$app->language;
?>
<div class="votes-block">
    <div class="title-cont">
        <h3 class="title"><?= Yii::t('app', 'Your Vote');?></h3>
    </div>
    <div class="vote-question" id="vote-question-id"></div>
    <ul class="vote-choise" id="vote-choise-id">

    </ul>
    <div class="text-center">
        <span id="vote-res-icon"></span><br>
        <span id="vote-res-message"></span><br>
        <span id="vote-empty" style="display: none"><?= Yii::t('app', 'Please choose one of the answers.');?></span></br>
        <a href="#" id="view-results" style="display: none" class="btn btn-primary vote-btn"><?= Yii::t('app', 'View results')?></a>
    </div>
    <a id="vote-submit" class="btn btn-primary vote-btn"><?= Yii::t('app', 'Vote');?></a>
</div>

<?php $this->registerJs(
    "$(document).ready(function() {
    var param = $('meta[name=csrf-param]').attr('content');
    var token = $('meta[name=csrf-token]').attr('content');
    var url = '$hostInfo/$lang';
    $.ajax({
            url: url+'/vote/vote/list',
            type: 'get',
            dataType: 'json',
            success: function(data, response, textStatus, jqXHR) {
                    var question = data['question'];
                    $('#vote-question-id').html(question);
                    var content = '';
                        for(var i in data['answers']){
                         var answer = data['answers'][i].answer;
                         var id = data['answers'][i].id;
                        content += '<li><label><input class=\"vote-check\" type=\"radio\" name=\"vote-radio\" value=\"'+id+'\">'+answer+'</label></li>'
                        }
                        $('#vote-choise-id').html(content);
                
                    //var message = data['message'];
                    //$('#vote-res-message').html(message);
                    //$('#view-results').show();
                
            }
        });
        
    $(document).on('click', '#vote-submit', function(e){
        var form = $('.vote-check:checked').val();
        if(form==null){
            $('#vote-empty').show();
            setTimeout(function() { $('#vote-empty').hide(); }, 1000);
            }  
        $.ajax({
            url: url+'/vote/vote/add',
            type: 'post',
            dataType: 'json',
            data: {'ResultsForm[answer_id]': form},
            success: function(data, response, textStatus, jqXHR) {
                var message = data['message'];
               $('#vote-res-message').html(message);
               
              //$('#vote-res-icon').html('<span class=\"glyphicon glyphicon-ok\"></span>');
               setTimeout(function() { window.location.href = '/voteresult';  }, 1000);
                       
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
