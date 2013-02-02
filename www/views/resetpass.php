<?php
    include('header.php');
?>

<h1><?= html_escape($title) ?></h1>

<p>Introdu numele de utilizator al celui caruia vrei sa ii schimbi parola si noua parola.</p>

<form action="<?= html_escape(url_resetpass()) ?>" method="post" class="login clear">
<fieldset>
    <legend>Date de identificare</legend>
    <ul class="form">
        <li>
            <label for="form_username">Cont de utilizator</label>
            <?= ferr_span('username') ?>
            <input type="text" name="username" id="form_username" value="<?= fval('username') ?>" />
        </li>
        
        <li>
            <label for="form_new_password">Parola noua</label>
            <?= ferr_span('new_password') ?>
            <input type="text" name="new_password" id="form_new_password" value="<?= fval('new_password') ?>" />
        </li>

    </ul>
</fieldset>
<ul class="form clear">
    <li>
        <input type="submit" value="Schimbare parola" id="form_submit" class="button important" />
    </li>
</ul>
</form>

<?php #wiki_include('template/resetarea-parolei'); ?>

<?php
    include('footer.php');
?>
