<?php
require_once '../_includes/bootstrap.php';
unset( $_SESSION[ SESSION_AUTH_KEY ] );
unset( $_SESSION[ SESSION_STATE_KEY ] );
header( 'Location: ' . url( 'index' ) );
exit;
?>
