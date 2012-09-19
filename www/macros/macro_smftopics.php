<?php

require_once(IA_ROOT_DIR.'www/macros/macro_remotebox.php');

// Displays last topics in given SMF board. This macro is a wrapper
// for the more generic macro RemoteBox()
//
// Arguments:
//      board_id (optional) SMF numeric board id
//               default displays topics from all over the forum
//      count    (optional) number of recent topics to display
//               default is 5
// Examples:
//      SmfTopics( board_id="4" )
//      SmfTopics()
function macro_smftopics($args) {
    $board_id = getattr($args, 'board_id');
    $count = getattr($args, 'count', 5);

    if (!$board_id) {
        $board_id = '';
    }
    if (!is_numeric($count) || 0 >= $count) {
        return macro_error('Invalid `count` argument');
    }

    $url = IA_SMF_URL.'/ia_recenttopics.php?board_id='.$board_id.'&count='.$count;

    return macro_remotebox($url, true);
}

?>
