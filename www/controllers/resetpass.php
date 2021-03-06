<?php

require_once(IA_ROOT_DIR."common/db/smf.php");
require_once(IA_ROOT_DIR."common/db/user.php");
require_once(IA_ROOT_DIR."common/user.php");
require_once(IA_ROOT_DIR."common/email.php");

// displays form to identify user. On submit it sends e-mail with confirmation
// link.

function controller_resetpass() {
    global $identity_user;

    // `data` dictionary is a dictionary with data to be displayed by form view
    $data = array();

    // here we store validation errors.
    // It is a dictionary, indexed by field names
    $errors = array();
    
    $changer_name = getattr($identity_user, 'username');
    $changer = user_get_by_username($changer_name);
    
    if (!user_is_admin($changer))
        redirect(url_home());

    // submit?
    $submit = request_is_post();

    if ($submit) {
        // 1. validate
        // check username
        $data['username'] = getattr($_POST, 'username');
        $new_pass = getattr($_POST, 'new_password');
        if ($data['username']) {
            $user = user_get_by_username($data['username']);
            if (!$user) {
                $errors['username'] = 'Nu exista vreun utilizator cu acest '
                                      .'nume de cont';
            }
        }

        if (isset($user) && $user && !empty($new_pass)) {
            // user was found
            $user['password'] = user_hash_password($new_pass, $user['username']);
            user_update($user);
            redirect(url_home());
        }
        else {
            flash_error('Trebuie sa completezi ambele campuri!');
        }
    }
    else {
        // initial display of form
    }

    // page title
    $view = array();
    $view['title'] = 'Schimbare parola';
    $view['form_errors'] = $errors;
    $view['form_values'] = $data;
    $view['no_sidebar_login'] = true;
    execute_view_die('views/resetpass.php', $view);
}

?>
