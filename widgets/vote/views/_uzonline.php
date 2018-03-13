<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.03.2018
 * Time: 1:56
 */


?>

<div class="ut-vote-bar">
    <h3><?= Yii::t('app', 'Your voice');?></h3>
    <form action="" method="post">
        <p id="vote-question-id"></p>

                <div id="vote-choise-id">

                </div>


        <input id="vote-submit" type="submit" class="hidden" name="vote" value="<?= Yii::t('app', 'Vote');?>" />
    </form>
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
                    $('#vote-question-id').html(vote);
                if (data.status === 1) {
                   var content = '';
                        for(var i in data['answers']){
                         var answer = data['answers'][i].answer;
                         var id = data['answers'][i].id;
                        content += '<label for=\"vote_radio_15_'+id+'\"><table width=\"100%\"><tbody><tr><td width=\"20\"><input type=\"radio\" name=\"vote_radio_15\" id=\"vote_radio_15_51\" value=\"'+id+'\"  /></td><td>'+answer+'</td></tr></tbody></table></label>'
                        }
                        $('#vote-choise-id').html(content);
                }else {
                    var message = data['message'];
                    $('#vote-res-message').html(message);
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
