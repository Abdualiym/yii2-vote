<?php

$hostInfo = Yii::$app->params['frontendHostInfo'];
$lang = Yii::$app->language;

?>
<div class="content-section">
    <?php foreach ($questions as $question):?>

        <div class="votes-block">
            <?php if($question->isVoted()): ?>

                <?php $result = \abdualiym\vote\entities\Results::listAnswersResult($question->id); ?>

                <div class="vote-question"><?= $question->translate($question->id); ?></div>

                <?php foreach ($question->voteAnswers as $answer_res):?>

                    <div class="progress-title"><?= $answer_res->translate($answer_res->id); ?>:
                        <strong><?= Yii::t('app', '{n,plural,=0{not voted} =1{# vote} =2{# votes} other{# votes}}', ['n' => $answer_res->countResult($answer_res->id)])?></strong>
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="<?= $result['all'];?>" style="width: <?php $present= $answer_res->countResult($answer_res->id)*100/$result['all'];
                        echo round($present);?>%;">
                            <?php echo round($present);?>%</div>
                    </div>

                <?php endforeach; ?>

            <?php else:?>
                <ul class="list-group">

                    <div class="vote-question"><?= $question->translate($question->id); ?></div>
                    <?php foreach ($question->voteAnswers as $answer):?>
                        <li id="<?= $question->id; ?>">
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
                    <span id="<?= $question->id; ?>-vote-empty" style="display: none"><?= Yii::t('app', 'Please choose one of the answers.');?></span></br>

                    <a id="<?= $question->id; ?>" class="vote-submit btn btn-info"><?= Yii::t('app', 'Vote')?></a>
                </ul>
            <?php endif; ?>
        </div>

    <?php endforeach; ?>
</div>

<script>
    $(document).ready(function() {

        var param = $('meta[name=csrf-param]').attr('content');
        var token = $('meta[name=csrf-token]').attr('content');
        var url = '<?=$hostInfo.'/'.$lang ?>';
        $(document).on('click', '.vote-submit', function(e){
            var form = $(this).attr('id');
            var id = $('.'+form+'-vote-check:checked').val();
            if(form==null){
                $('#vote-empty').show();
                setTimeout(function() { $('#'+form+'vote-empty').hide(); }, 2000);
            }
            $.ajax({
                url: url+'/vote/vote/add',
                type: 'post',
                dataType: 'json',
                data: {'ResultsForm[answer_id]': id},
                success: function(data, response, textStatus, jqXHR) {
                    var message = data['message'];
                    $('#'+form+'-vote-res-message').html(message);

                    setTimeout(function() {     location.reload();  }, 1000);

                    //$('#view-results').show();
                    //$('#vote-submit').remove();

                }
            });
            return false;
        });

    });
</script>