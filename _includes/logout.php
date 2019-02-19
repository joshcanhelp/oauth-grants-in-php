<?php
require_once '../_includes/bootstrap.php';
$_SESSION = [];
setcookie( 'auth0_id_token', '', 0 );
setcookie( 'auth0_state', '', 0 );
setcookie( 'auth0_nonce', '', 0 );
header( 'Location: '.url( 'index' ) );
exit;
