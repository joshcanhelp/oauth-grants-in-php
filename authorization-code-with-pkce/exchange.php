<?php
define('META_TITLE', 'Token Exchange - Authorization Code with PKCE');

require_once '../_includes/bootstrap.php';
require_once '../_includes/head.php';

$token_post_body = [
    'grant_type'    => 'authorization_code',
    'client_id'     => AUTH0_ACPKCE_CLIENT_ID,
    'code_verifier' => $_SESSION[SESSION_CODE_VERIFIER_KEY],
    'code'          => $_GET['code'],
    'redirect_uri'  => url( 'callback' ),
];

$error = null;
if (empty( $_SESSION[SESSION_AUTH_KEY] )) {
    $curl_handle = curlHandlePostJson( $token_post_body );
    $output      = curl_exec( $curl_handle );
    $error       = curl_error( $curl_handle );
    curl_close( $curl_handle );
}
?>

<h1>Step 3</h1>
<p>Again, this would typically be part of the callback processing but it's separated here to spell out each step.</p>
<p>Here's what we sent:</p>

<?php var_dump( $token_post_body ); ?>

<?php if ($error) : ?>
  <p>It looks like our call came back with an error:</p>
  <blockquote class="badnews"><?php echo $error; ?></blockquote>
  <p><strong><a href="index.php">&lsaquo; Let's start over</a></strong></p>

<?php else : ?>
  <p>Here's what we got back:</p>

    <?php
    if (empty( $_SESSION[SESSION_AUTH_KEY] )) {
        $token_response             = json_decode( $output, true );
        $_SESSION[SESSION_AUTH_KEY] = $token_response;
    }

    var_dump( $_SESSION[SESSION_AUTH_KEY] );
    ?>

  <p>The authentication is now complete!</p>
  <p><strong><a href="/">&lsaquo; Back home</a></strong></p>

<?php endif; ?>

<?php require_once '../_includes/foot.php'; ?>
