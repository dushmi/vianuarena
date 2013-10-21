<?php
    include('header.php');
?>

<h1><?= html_escape($title) ?></h1>

<p>Modifica punctajele per problema.</p>

<form action="<?= html_escape(url_penalty_edit()) ?>" method="post" class="login clear">
<fieldset>
    <legend>Probleme</legend>
    

</fieldset>

</form>

<?php
    include('footer.php');
?>
