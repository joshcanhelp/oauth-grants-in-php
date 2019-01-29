<?php
define('META_TITLE', 'Start - Authorization Code with PKCE');
require_once '../_includes/bootstrap.php';
require_once '../_includes/head.php';
?>

<h1>Step 1</h1>
<p>Let's see how authentication works using an authorization code grant with PKCE. We're in a web browser now so, technically, it's not necessary to use this grant for authentication. So, we'll just pretend that this is a mobile browser. You can make your browser window smaller if you think that might help 🤷‍♂️</p>
<p>Let's check what's in our PHP session (<code><?php echo SESSION_AUTH_KEY; ?></code> key):</p>

<?php if ( ! empty( $_SESSION[SESSION_AUTH_KEY] ) ): ?>

  <blockquote>You <strong>are</strong> logged in.</blockquote>
  <p>You can validate and decode the ID token below to determine the user (try pasting this into <a href="https://jwt.io" target="_blank">jwt.io</a>):</p>
  <pre><?php echo $_SESSION[ SESSION_AUTH_KEY ]['id_token'] ?></pre>
  <p>You can now send the access token below to your API (which should validate it as well):</p>
  <pre><?php echo $_SESSION[ SESSION_AUTH_KEY ]['access_token'] ?></pre>
  <p><strong>
    <a href="<?php echo logout_url(); ?>">Log out &rsaquo;</a>
  </strong></p>

<?php else: ?>

  <blockquote>You <strong>are not</strong> logged in.</blockquote>
  <p>OK, set's redirect you to login. We'll send you to your authorization server here:</p>
  <pre><?php echo authorize_url(); ?></pre>
  <p>... along with the following URL parameters:</p>
  <?php
  // This will be sent with the authorization code to the token endpoint.
  $code_verifier = bin2hex( random_bytes( 32 ) );
  $code_verifier = pack( 'H*', $code_verifier );
  $code_verifier = base64_url_encode( $code_verifier );
  $_SESSION[ SESSION_CODE_VERIFIER_KEY ] = $code_verifier;

  // This will be sent to the authorization endpoint.
  $code_challenge = pack('H*', hash( 'sha256', $code_verifier ) );
  $code_challenge = base64_url_encode( $code_challenge );

  $state = random_bytes( 32 );
  $state = base64_url_encode( $state );
  $_SESSION[ SESSION_STATE_KEY ] = $state;

  // These will be appended to the authorize URL.
  $authorize_url_params = [
    'audience'              => AUTH0_ACPKCE_API_AUDIENCE,
    'scope'                 => 'openid email read:messages',
    'response_type'         => 'code',
    'client_id'             => AUTH0_ACPKCE_CLIENT_ID,
    'code_challenge'        => $code_challenge,
    'code_challenge_method' => 'S256',
    'redirect_uri'          => url( 'callback' ),
    'state'                 => $state,
  ];
  ?>
  <ul>
    <li>
      <code>audience</code>:
      The unique identifier of the API the native app wants to access; the API audience here is set to:
      <pre><?php echo $authorize_url_params[ 'audience' ]; ?></pre>
    </li>
    <li>
      <code>scope</code>:
      The scopes that you want to request authorization for. In this case, we want to identify our user so we'll ask for and OIDC scope. We also want to access our API so we'll ask for a valid scope for that. The complete scope being used for this example is:
      <pre><?php echo $authorize_url_params[ 'scope' ]; ?></pre>
    </li>
    <li>
      <code>response_type</code>:
      For this grant, the value here is always:
      <pre><?php echo $authorize_url_params[ 'response_type' ]; ?></pre>
    </li>
    <li>
      <code>client_id</code>:
      The Application identifier from Auth0; this has been set to:
      <pre><?php echo $authorize_url_params[ 'client_id' ]; ?></pre>
    </li>
    <li>
      <code>code_challenge</code>:
      This is the parameter that tells the authorization server that we're using PKCE along with our authorization code. See the PHP source for this file for how it was generated. The challenge that will be sent to the authorize endpoints is:
      <pre><?php echo $authorize_url_params[ 'code_challenge' ]; ?></pre>
      ... and the verifier that will be sent to the token endpoint is:
      <pre><?php echo $code_verifier; ?></pre>
    </li>
    <li>
      <code>code_challenge_method</code>:
      This is the hashing algorithm used to create the code_challenge above; for an Auth0 server, this should always be set to:
      <pre><?php echo $authorize_url_params[ 'code_challenge_method' ]; ?></pre>
    </li>
    <li>
      <code>redirect_uri</code>: The URL to which Auth0 will redirect the browser after authorization has been granted by the user; this has been set to:
      <pre><?php echo $authorize_url_params[ 'redirect_uri' ]; ?></pre>
    </li>
    </li>
    <li>
      <code>state</code>: The state value is sent with the authorization request and verified at the callback to help prevent CSRF attacks; the value used here is:
      <pre><?php echo $authorize_url_params[ 'state' ]; ?></pre>
    </li>
  </ul>
  <p>Our final URL will be:</p>
  <pre><?php echo authorize_url( $authorize_url_params ); ?></pre>
  <p>And this is what we have stored in session before we go:</p>
  <?php var_dump( $_SESSION ) ?>
  <p><strong>
    <a href="<?php echo authorize_url( $authorize_url_params ); ?>">Let's log in &rsaquo;</a>
  </strong></p>
  <p class="subtext">* The click here would be where your mobile device switches context to the system browser or a desktop app loads an embedded browser.</p>

<?php endif; ?>

<?php require_once '../_includes/foot.php' ?>
