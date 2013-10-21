<?php
    include('header.php');
?>

<h1><?= html_escape($title) ?></h1>

<p>Modifica punctajele per problema.</p>

<?php 
echo "<p>Scor total: ".$view['total_score']."</p>"; 

foreach ($view['tasks'] as $task)
        echo $task['task_id']."  ".$task['score']."    ";
 ?>

<ul class="form clear">
    <li>
        <input type="submit" value="Submit" id="form_submit" class="button important" />
    </li>
</ul>

<?php
    include('footer.php');
?>
