<?php
    include('header.php');
?>

<h1><?= html_escape($title) ?></h1>

<p>Modifica punctajele per problema pentru utilizatorul</p>

<?php 
echo "Modifica punctajele per problema pentru utilizatorul ".$view['user'];
echo "<h2>Scor total: ".$view['total_score']."</h2>"; 

echo '<form action="<?= html_escape(url_penalty()) ?>" method="post" class="login clear">';
foreach ($view['tasks'] as $task)
        echo $task['task_id']."  ".$task['score']."    ";
echo '</form>';
?>

<ul class="form clear">
    <li>
        <input type="submit" value="Submit" id="form_submit" class="button important" />
    </li>
</ul>

<?php
    include('footer.php');
?>
