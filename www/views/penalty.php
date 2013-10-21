<?php
    include('header.php');
?>

<h1><?= html_escape($title) ?></h1>

<p>Introduceti numele celui caruia vreti sa ii modificati punctajul si id-ul concursului.</p>

<form action="<?= html_escape(url_penalty()) ?>" method="post" class="login clear">
<fieldset>
    <legend>Date generale</legend>
    <ul class="form">
        <li>
            <label for="form_username">Nume utilizator</label>
            <?= ferr_span('username') ?>
            <input type="text" name="username" id="form_username" value="<?= fval('username') ?>" />
        </li>
        
        <li>
            <label for="form_round_id">I concurs</label>
            <?= ferr_span('round_id') ?>
            <input type="text" name="round_id" id="form_round_id" value="<?= fval('round_id') ?>" />
        </li>

    </ul>
</fieldset>
<ul class="form clear">
    <li>
        <input type="submit" value="Inainte" id="form_submit" class="button important" />
    </li>
</ul>
</form>

<?php
    include('footer.php');
?>
