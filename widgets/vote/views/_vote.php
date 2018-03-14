<div class="content-section">
    <div class="row">
        <div class="col-md-8">
        <?php foreach ($questions as $question):?>
        <?= $question->id; ?>

            <ul class="list-group">
                <h2><?= $question->translations[1]->question; ?></h2>
                <?php foreach ($question->voteAnswers as $answer):?>
                <li class="list-group-item">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios">
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