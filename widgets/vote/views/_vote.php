<div class="content-section">
    <div class="row">
        <div class="col-md-8">
        <?php foreach ($questions as $question):?>
        <?= $question->id; ?>

            <ul class="list-group">
                <li class="list-group-item">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios">
                            Excellent
                        </label>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios">
                            Good
                        </label>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios">
                            Can Be Improved
                        </label>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios">
                            Bad
                        </label>
                    </div>
                </li>
                <li class="list-group-item">
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios">
                            No Comment
                        </label>
                    </div>
                </li>
            </ul>
        <?php endforeach; ?>
        </div>
    </div>

</div>