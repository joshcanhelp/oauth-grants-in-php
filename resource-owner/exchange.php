<?php
define('META_TITLE', 'Exchange - Resource Owner');

require_once '../_includes/bootstrap.php';
require_once '../_includes/head.php';

$token_post_body = [
  'grant_type'    => $_POST['grant_type'],
  'scope'         => $_POST['scope'],
  'client_id'     => AUTH0_RO_CLIENT_ID,
  'client_secret' => AUTH0_RO_CLIENT_SECRET,
  'username'      => $_POST['username'],
  'password'      => $_POST['password'],
];

$error = null;
if ( empty( $_SESSION[ SESSION_AUTH_KEY ] ) ) {
  $curl_handle = curl_handle_post_json( $token_post_body );
  $output = curl_exec( $curl_handle );
  $error  = curl_error( $curl_handle );
  curl_close( $curl_handle );
}
?>

<h1>Step 2</h1>

<p>Here's what we sent:</p>

<?php
$token_post_body['client_secret'] = censor( $token_post_body['client_secret'] );
$token_post_body['password'] = censor( $token_post_body['password'] );
var_dump( $token_post_body );
?>

<?php if ( $error ): ?>

  <p>It looks like our call came back with an error:</p>
  <blockquote class="badnews"><?php echo $error ?></blockquote>
  <p><strong><a href="index.php">&lsaquo; Let's start over</a></strong></p>

<?php else: ?>

  <p>Here's what we got back:</p>

  <?php
  if ( empty( $_SESSION[ SESSION_AUTH_KEY ] ) ) {
    $token_response = json_decode( $output, true );
    $_SESSION[ SESSION_AUTH_KEY ] = $token_response;
  }
  var_dump( $_SESSION[ SESSION_AUTH_KEY ] );
  ?>

  <p>The authentication is now complete!</p>
  <p><strong><a href="/">&lsaquo; Back home</a></strong></p>

<?php endif; ?>

<?php require_once '../_includes/foot.php' ?>
