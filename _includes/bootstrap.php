<?php
// Check for required credentials file.
$credentials_path = '../credentials.php';
if (! file_exists( $credentials_path )) {
    die( 'Missing '.$credentials_path );
}

require $credentials_path;

// Always need a domain for API calls.
if (! defined( 'AUTH0_DOMAIN' )) {
    die( 'Missing AUTH0_DOMAIN constant' );
}

session_start();

define( 'SESSION_AUTH_KEY', 'auth0_session' );
define( 'SESSION_CODE_VERIFIER_KEY', 'auth0_code_verifier' );
define( 'SESSION_STATE_KEY', 'auth0_state' );

if (! defined( 'META_TITLE' )) {
    define('META_TITLE', 'OAuth Grants in PHP');
}

require 'functions.php';
