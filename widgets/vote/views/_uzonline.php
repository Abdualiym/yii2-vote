<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13.03.2018
 * Time: 1:56
 */


?>

<div class="ut-vote-bar">
    <h3>Ваш голос</h3>
    <form action="ru/polls/polls_4.html" method="post">

        <input type="hidden" name="vote" value="Y">
        <input type="hidden" name="PUBLIC_VOTE_ID" value="18">
        <input type="hidden" name="VOTE_ID" value="18">

        <p>Как вы оцениваете работу офисов продаж и обслуживания UZONLINE/АК «Узбектелеком» в своем регионе?</p>


        <label for="vote_radio_15_49">
            <table width="100%">
                <tbody>
                <tr>
                    <td width="20"><input type="radio"  name="vote_radio_15" id="vote_radio_15_49" value="49"  checked='checked'  /></td>
                    <td>полностью удовлетворяет</td>
                </tr>
                </tbody>
            </table>
        </label>




        <label for="vote_radio_15_50">
            <table width="100%">
                <tbody>
                <tr>
                    <td width="20"><input type="radio"  name="vote_radio_15" id="vote_radio_15_50" value="50"  /></td>
                    <td>частично удовлетворяет</td>
                </tr>
                </tbody>
            </table>
        </label>

        <label for="vote_radio_15_51">
            <table width="100%">
                <tbody>
                <tr>
                    <td width="20"><input type="radio"  name="vote_radio_15" id="vote_radio_15_51" value="51"  /></td>
                    <td>не удовлетворяет</td>
                </tr>
                </tbody>
            </table>
        </label>

        <input type="submit" class="hidden" name="vote" value="Голосовать" />
    </form>
</div>
