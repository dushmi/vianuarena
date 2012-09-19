<?php

require_once(IA_ROOT_DIR."common/db/user.php");
require_once(IA_ROOT_DIR."common/db/score.php");

// This controller serves real time data for plots (graphs) rendered
// with Open Flash Chart.
function controller_plot($suburl) {
    switch ($suburl) {
        case 'rating':
            // Display user rating history
            $username = request('user');

            // validate user
            $user = user_get_by_username($username);
            if (!$user) {
                die_http_error();
            }

            // get rating history
            $history = rating_history($user['id']);

            // view
            $view = array(
                'history' => $history,
                'user' => $user,
            );

            // output data for Open Flash Chart
            execute_view_die('views/plot_rating.php', $view);

        case 'distribution':
            // Display rating distribution
            // If there is a username specified, plot given user in rating
            // distribution.

            // validate user
            $username = request('user');
            $user = user_get_by_username($username);

            if (!$user && $username) {
                die_http_error();
            }

            // get rating history
            //
            // Note: This bucket size is relative to the absolute ratings
            // ranging from ~1000 to ~2500
            $bucket_size = 60;
            $distribution = rating_distribution($bucket_size);

            // view
            $view = array(
                'distribution' => $distribution,
                'bucket_size' => $bucket_size,
                'user' => $user,
            );

            // output data for Open Flash Chart
            execute_view_die('views/plot_distribution.php', $view);

        default:
            flash('Actiunea nu este valida.');
            redirect(url_home());
    }
}
?>
