<?php

/*
 * function description - execute APIs with provided method type, extended url and params
 * @params -
 * $method - type of method eg. GET/ POST/ PUT
 * $url    - extended URL
 * $data   - body part of the rest API
 *
 * returns -
 * result, http_code and error (mutliple response depending on the execution)
 * */
function executeRestAPIWith($method, $url, $data = false) {
    // get the base URL defined in settings of the plugin
    $base_url = get_option('bugzilla_base_url');

    if (!$base_url) {
        // if the base url is not defined
        return [null, 0, 'BASE URL is not provided'];
    }

    $base_url .= $url;
    $curl = curl_init();
    switch ($method)
    {
        case 'POST':
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type:  application/json'));
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($data) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            }
            break;
        case 'GET':
            break;
        default:
            if ($data) {
                $base_url = sprintf('%s?%s', $base_url, http_build_query($data));
            }
    }

    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_URL, $base_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($curl);
    curl_close($curl);
    return [$result, $http_status, $curl_error];
}