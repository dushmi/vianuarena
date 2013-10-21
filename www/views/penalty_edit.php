<?php
    include('header.php');
?>

<h1><?= html_escape($title) ?></h1>

<p>Modifica punctajele per problema.</p>

<?php echo $view['total_score']; ?>

<?php
    include('footer.php');
?>
