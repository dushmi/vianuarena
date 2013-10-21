<?php
    include('header.php');
?>

<h1><?= html_escape($title) ?></h1>

<?php 
echo "Modifica punctajele per problema pentru utilizatorul <b>".$view['user']['username']."</b> la concursul <b>".$view['round']['title']."</b>.";

echo '<form action="<?= html_escape(url_penalty()) ?>" method="post" class="login clear">';
echo '<fieldset>';
echo '<legend>Scor total: '.$view['total_score'].'</legend>';
echo '<ul class="form">';

foreach ($view['tasks'] as $task) {
	echo '<li>';
	echo '<label for="form_'.$task['task_id'].'">'.$task['task_id'].'</label>';
	echo '<?= ferr_span("'.$task['task_id'].'") ?>';
	echo '<input type="text" name="username" id="form_username" value="'.$task['score'].'" />';
	echo '</li>';
}

echo '</ul>';
echo '</fieldset>';
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
