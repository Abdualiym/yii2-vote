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
        <h3 class="title"><?= Yii::t('vote', 'Your Vote');?></h3>
    </div>
    <div class="vote-question" id="vote-question-id"></div>
<!---- result ---->
    <div class="result-vote">

    </div>
    <!---- result ---->

    <ul class="vote-choise" id="vote-choise-id">

    </ul>
    <div class="text-center">
        <span id="vote-res-icon"></span><br>
        <span id="vote-res-message"></span><br>
        <span id="vote-empty" style="display: none"><?= Yii::t('vote', 'Please choose one of the answers.');?></span></br>
        <a href="#" id="view-results" style="display: none" class="btn btn-primary vote-btn"><?= Yii::t('vote', 'View results')?></a>
    </div>
    <a style="display: none" id="vote-submit" href="#" class="btn btn-primary vote-btn"><?= Yii::t('vote', 'Vote');?></a>
    <a style="display: none" id="vote-view" href="/voteresult" class="btn btn-primary vote-btn"><?= Yii::t('vote', 'View all results');?></a>
</div>

<?php $this->registerJs(
    "$(document).ready(function() {
        var url = '$hostInfo/$lang';
        var param = $('meta[name=csrf-param]').attr('content');
        var token = $('meta[name=csrf-token]').attr('content');
        var fp = new Fingerprint2();
        fp.get(function(result, components) {
        $.post(''+url+'/vote/vote/cookie', {'token': result, '_crsf': token } );
    $.ajax({
            url: url+'/vote/vote/list',
            type: 'get',
            dataType: 'json',
            success: function(data, response, textStatus, jqXHR) {
                if(data['all'] != null){
                        $('#vote-submit').hide();            
                        $('#vote-view').show();            
               
                            $('#vote-question-id').html(data['question']);            
                                var all = data['all'];
                                for(var i in data['items']){
                                var answer = data['items'][i].id;
                                var name = data['items'][i].name;
                                var count_message = data['items'][i].count_message;
                                var answer_count = data['items'][i].count;
                                                     
                                var procent = answer_count * 100 / data['all'];
                               
                                $('.result-vote').append('<div class=\"progress-title\">'+name+'<strong > '+count_message+'</strong></div><div class=\"progress\"><div class=\"progress-bar\" role=\"progressbar\" aria-valuenow=\"30\" aria-valuemin=\"0\" aria-valuemax=\"'+all+'\" style=\"width: '+procent+'%;\">'+Math.round(procent)+'%</div></div>');
                            }   
                }else{
                $('#vote-submit').show();    
                    var question = data['question'];
                    $('#vote-question-id').html(question);
                    var content = '';
                        for(var i in data['answers']){
                         var answer = data['answers'][i].answer;
                         var id = data['answers'][i].id;
                        content += '<li><label><input class=\"vote-check\" type=\"radio\" name=\"vote-radio\" value=\"'+id+'\">'+answer+'</label></li>'
                        }
                        $('#vote-choise-id').html(content);
                }                                          
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
            data: {'ResultsForm[answer_id]': form,  'ResultsForm[cookie_token]': result, '_csrf':token },
            success: function(data, response, textStatus, jqXHR) {
                var message = data['message'];
               $('#vote-res-message').html(message);
               setTimeout(function() { window.location.href = '/voteresult';  }, 1000);
           }
        });
        return false;
    });
   });
});

",
    \yii\web\View::POS_READY,
    'my-button-handler'
);

?>
