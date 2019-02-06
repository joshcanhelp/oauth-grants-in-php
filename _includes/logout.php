<?php
require_once '../_includes/bootstrap.php';
$_SESSION = [];
header( 'Location: '.url( 'index' ) );
exit;
