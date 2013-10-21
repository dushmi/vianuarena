<?php

require_once(IA_ROOT_DIR."common/db/smf.php");
require_once(IA_ROOT_DIR."common/db/user.php");
require_once(IA_ROOT_DIR."common/db/score.php");
require_once(IA_ROOT_DIR."common/user.php");
require_once(IA_ROOT_DIR."common/email.php");

function controller_penalty_edit() {
    global $identity_user;

    //security check
    $changer_name = getattr($identity_user, 'username');
    $changer = user_get_by_username($changer_name);
    
    if (!user_is_admin($changer))
       redirect(url_home());

    $user_id = request('user_id');
    $round_id = request('round_id');

    if (!$user_id || !$round_id)
        redirect(url_penalty());

    

    controller_penalty_solve($user_id, $round_id);
}

function controller_penalty_solve($user_id, $round_id) {
    $scores = scores_get_by_user_id_and_round_id($user_id, $round_id);
    $total_score = total_score_get_by_user_id_and_round_id($user_id, $round_id);

    $view = array();
    $view['title'] = 'Penalty Edit';
    $view['total_score'] = $total_score['score'];
    $view['tasks'] = $scores;
    $view['user'] = user_get_by_id($user_id);
    $view['round'] = round_get($round_id);

    execute_view_die('views/penalty_edit.php', $view);
}

?>
