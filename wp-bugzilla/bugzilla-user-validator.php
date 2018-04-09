<?php

/*
 * This php page is landing page of the Issues section
 * Here we are going to ask user to enter his/her bugzilla account username/login and password
 * Then we will authenticate these details with the base URL (entered by admin in the setting
 * menu of plugin) and will get the result.
 *
 * If the result is successful we will save the entry next to current user id as bugzilla_username
 * and bugzilla_password attributes.
 *
 * These attributes later can be used to create a bug / search for existing bug etc.
 * */

if ( ! defined( 'ABSPATH' ) ) exit;

// handle on Authenticate
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['Submit'])) {
        // make sure these actions are made once all plugins are loaded
        // please refer - https://wordpress.stackexchange.com/questions/134796/get-userdata-inside-custom-build-plugin?rq=1
        add_action('plugins_loaded', function () {
            require_once(ABSPATH . 'wp-content/plugins/wp-bugzilla/endpoints/bugzilla-authenticate-endpoint.php');
            require_once(ABSPATH . 'wp-content/plugins/wp-bugzilla/bugzilla-list-bugs.php');
            $response = authenticateUser($_POST['bugzilla_username'], $_POST['bugzilla_password']);
            $result = $response[0];
            $message = $response[1];

            if ($result == 'Success') {
                $user = new stdClass;
                $user->ID = (int)$_POST['hidden'];
                $user->bugzilla_username = $_POST['bugzilla_username'];
                $user->bugzilla_password = $_POST['bugzilla_password'];
                wp_update_user($user);
            } else {
                if ($result == 'Error') {
                    echo $message;
                } else {
                    // need to be thought, what we should show here
                }
            }
        });
    }
}

function check_user()
{
    $current_user = wp_get_current_user();
    $bugzilla_username = $current_user->bugzilla_username;
    $bugzilla_password = $current_user->bugzilla_password;

    if ($bugzilla_username && $bugzilla_password) {
        require_once(ABSPATH . 'wp-content/plugins/wp-bugzilla/bugzilla-list-bugs.php');
        listAllBug();
    } else {
        ?>

        <div class="wrap">
            <form name="bugzilla_credentials_form" method="post"
                  action="<?php echo str_replace('%7E', '~', $_SERVER['REQUEST_URI']); ?>">
                <input type="text" name="bugzilla_username" value="Bugzilla Username" size="50">
                <hr/>
                <input type="password" name="bugzilla_password" value="Bugzilla Password" size="50">
                <hr/>
                <input type="hidden" name="hidden" value="<?php echo $current_user->ID; ?>"/>
                <p class="submit">
                    <input type="submit" name="Submit" value="Authenticate"/>
                </p>
            </form>
        </div>
        <?
    }
}

add_shortcode('isloggedin', 'check_user');