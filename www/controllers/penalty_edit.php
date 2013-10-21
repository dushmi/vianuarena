<?php

require_once(IA_ROOT_DIR."common/db/smf.php");
require_once(IA_ROOT_DIR."common/db/user.php");
require_once(IA_ROOT_DIR."common/user.php");
require_once(IA_ROOT_DIR."common/email.php");

// displays form to identify user. On submit it sends e-mail with confirmation
// link.

function controller_penalty_edit() {
    global $identity_user;

    //security check
    $changer_name = getattr($identity_user, 'username');
    $changer = user_get_by_username($changer_name);
    
    if (!user_is_admin($changer))
        redirect(url_home());

    // `data` dictionary is a dictionary with data to be displayed by form view
    $data = array();

    // here we store validation errors.
    // It is a dictionary, indexed by field names
    $errors = array();

    // submit?
    #$submit = request_is_post();

    #if ($submit) {
        // 1. validate

    #}
    #else {
        // initial display of form
    #}

    // page title
    $view = array();
    $view['title'] = 'Penalty Edit';
    $view['form_errors'] = $errors;
    $view['form_values'] = $data;
    $view['no_sidebar_login'] = true;
    #execute_view_die('views/penalty_edit.php', $view);
}

?>
