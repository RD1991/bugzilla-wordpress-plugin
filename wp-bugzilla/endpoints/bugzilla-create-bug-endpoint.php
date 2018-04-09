<?php
/*
 * Call to create bug rest API with $_POST parameters
 * */
function createBugEndpoint() {
    require_once(ABSPATH.'wp-content/plugins/wp-bugzilla/endpoints/bugzilla-base-endpoint.php');
    $current_user = wp_get_current_user();
    $login = $current_user->bugzilla_username;
    $password = $current_user->bugzilla_password;
    $data_get = array(
        "login"        => $login,
        "password"     => $password,
        "product"      => $_POST['product'],
        "component"    => $_POST['component'],
        "version"      => $_POST['version'],
        "summary"      => $_POST['summary'],
        "alias"        => $_POST['alias'],
        "op_sys"       => $_POST['op_sys'],
        "priority"     => $_POST['priority'],
        "rep_platform" => $_POST['rep_platform'],
        "description"  => $_POST['desc'],
        "platform"     => $_POST['platform']);
    $data = json_encode($data_get);
    $response = executeRestAPIWith('POST', '/rest.cgi/bug', $data);
    $result = $response[0];
    $http_code = $response[1];
    $error = $response[2];

    if ($http_code == 0) {
        return ['Error', '<div><h1> Please specify the BASE URL in settings of "Bugzilla Integrator" plugin. </h1></div>'];
    } else if ($error || ($http_code != 200)) {
        return ['Error', '<div><h1> Something went wrong. <?php echo $error ?> </h1></div>'];
    } else {
        return ['Success', $result];
    }
}