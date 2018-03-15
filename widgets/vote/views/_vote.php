<?php $this->registerCss("
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
    <div class="row">
        <div class="col-md-12">
            <?php foreach ($questions as $question):?>
                <?= $question->id; ?>
                <?php if($question->resultInfo->question_id == $question->id){

                }
                ?>
                <ul class="list-group">
                    <h2><?= $question->translations[1]->question; ?></h2>
                    <?php foreach ($question->voteAnswers as $answer):?>
                        <li class="list-group-item">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="optionsRadios" value=""<?= $answer->id; ?>>
                                    <?= $answer->id; ?>
                                </label>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>

</div>
