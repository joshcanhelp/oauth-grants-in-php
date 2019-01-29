<?php
$credentials_path = '../credentials.php';
if ( ! file_exists( $credentials_path ) ) {
  die( 'Missing ' . $credentials_path );
}

require $credentials_path;

if ( ! defined( 'AUTH0_DOMAIN' ) ) {
  die( 'Missing AUTH0_DOMAIN constant' );
}

session_start();

function url( $script = 'index' ) {
  return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $script . '.php';
}

function authorize_url( $params = null ) {
  $authorize_url = 'https://' . AUTH0_DOMAIN . '/authorize';
  if ( is_array( $params ) ) {
    $authorize_url .= '?' . http_build_query( $params );
  }
  return $authorize_url;
}

function token_url( $params = null ) {
  return 'https://' . AUTH0_DOMAIN . '/oauth/token';
}

function logout_url() {
  return sprintf(
    'https://%s/v2/logout?client_id=%s&returnTo=%s',
    AUTH0_DOMAIN,
    AUTH0_ACPKCE_CLIENT_ID,
    url( 'logout' )
  );
}

function base64_url_encode($input) {
  $input = base64_encode($input);
  $input = explode('=', $input)[0];
  $input = str_replace('+', '-', $input);
  $input = str_replace('/', '_', $input);
  return $input;
}

define( 'SESSION_AUTH_KEY', 'auth0_session' );
define( 'SESSION_CODE_VERIFIER_KEY', 'auth0_code_verifier' );
define( 'SESSION_STATE_KEY', 'auth0_state' );

if ( ! defined( 'META_TITLE' ) ) {
  define('META_TITLE', 'OAuth Grants in PHP');
}
