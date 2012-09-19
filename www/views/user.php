<?php
require_once(IA_ROOT_DIR.'www/wiki/wiki.php');
require_once(IA_ROOT_DIR.'www/format/format.php');
require_once(IA_ROOT_DIR.'www/format/list.php');

require_once(IA_ROOT_DIR.'common/tags.php');

$username = $user['username'];

// site header
include('header.php');

// display user info across all user profile pages
echo wiki_include($template_userheader, array('user' => $username));

// show profile tabs
$options = array(
    'stats' => format_link(url_user_stats($username), 'Statistici'),
    'rating' => format_link(url_user_rating($username), 'Rating'),
);

if ($action == 'view') {
    $action = 'stats';
    $template = 'template/userstats';
}

// mark selected action with class 'active'
$options[$action] = array($options[$action], array('class' => 'active'));
echo format_ul($options, 'htabs');

// showing ratings / statistics
echo wiki_include($template, array('user' => $user['username']));

// site footer
include('footer.php');

?>
