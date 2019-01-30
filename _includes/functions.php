<?php

/**
 * Get a direct URL to a script in the flow.
 *
 * @param string $script PHP script name without extension.
 *
 * @return string
 */
function url($script = 'index')
{
    return 'http://'.$_SERVER['HTTP_HOST'].'/'.$script.'.php';
}

/**
 * Get the URL to the authorize endpoint.
 *
 * @param array $params Parameters to add to the URL.
 *
 * @return string
 */
function authorizeUrl(array $params = [])
{
    $authorize_url = 'https://'.AUTH0_DOMAIN.'/authorize';
    if (! empty( $params )) {
        $authorize_url .= '?'.http_build_query( $params );
    }

    return $authorize_url;
}

/**
 * Get the token endpoint URL.
 *
 * @return string
 */
function tokenEndpointUrl()
{
    return 'https://'.AUTH0_DOMAIN.'/oauth/token';
}

/**
 * Get the Auth0 logout URL.
 *
 * @return string
 */
function logoutUrl()
{
    return sprintf(
        'https://%s/v2/logout?client_id=%s&returnTo=%s',
        AUTH0_DOMAIN,
        AUTH0_ACPKCE_CLIENT_ID,
        url( 'logout' )
    );
}

/**
 * URL-safe base64 encoding recommended by IETF.
 *
 * @param string $input String to encode.
 *
 * @return mixed|string
 */
function base64UrlEncode($input)
{
    $input = base64_encode($input);
    $input = explode('=', $input)[0];
    $input = str_replace('+', '-', $input);
    $input = str_replace('/', '_', $input);
    return $input;
}

/**
 * Get a cURL handle for a JSON POST request.
 *
 * @param array $post_body Key, value representation of data to POST.
 *
 * @return resource
 */
function curlHandlePostJson(array $post_body)
{
    $curl_handle = curl_init();

    curl_setopt( $curl_handle, CURLOPT_FAILONERROR, true );
    curl_setopt( $curl_handle, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl_handle, CURLOPT_CONNECTTIMEOUT, 10 );
    curl_setopt( $curl_handle, CURLOPT_TIMEOUT, 10 );
    curl_setopt( $curl_handle, CURLOPT_CUSTOMREQUEST, 'POST' );
    curl_setopt( $curl_handle, CURLOPT_URL, tokenEndpointUrl() );
    curl_setopt( $curl_handle, CURLOPT_POSTFIELDS, json_encode( (object) $post_body ) );
    curl_setopt( $curl_handle, CURLOPT_HTTPHEADER, [ 'Content-Type: application/json' ] );

    return $curl_handle;
}

/**
 * Replace all characters with a censoring one.
 *
 * @param string $string String to censor.
 *
 * @return string
 */
function censor($string)
{
    return str_repeat( '•', strlen( $string ) );
}
