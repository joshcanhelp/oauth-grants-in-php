<?php
define('META_TITLE', 'Start - Authorization Code');

require_once '../_includes/bootstrap.php';
require_once '../_includes/head.php';
?>

<h1>Step 1</h1>
<p>
  Let's see how authentication works using an authorization code grant. This grant is
  typically used in regular web applications. For more information about this
  grant and how it should be used, please see the <a
  href="https://github.com/joshcanhelp/oauth-grants-in-php/blob/master/authorization-code/README.md"
  target="_blank">README here</a>
</p>
<p>Let's check what's in our PHP session (<code><?php echo SESSION_AUTH_KEY; ?></code> key):</p>

<?php if (! empty( $_SESSION[SESSION_AUTH_KEY] )) : ?>
  <blockquote>You <strong>are</strong> logged in.</blockquote>
  <p>
    You can validate and decode the ID token below to determine the user
    (try pasting this into <a href="https://jwt.io" target="_blank">jwt.io</a>):
  </p>
  <pre><?php echo $_SESSION[SESSION_AUTH_KEY]['id_token']; ?></pre>
  <p>You can now send the access token below to your API (which should validate it as well):</p>
  <pre><?php echo $_SESSION[SESSION_AUTH_KEY]['access_token']; ?></pre>
  <p><a href="<?php echo logoutUrl(); ?>" class="go-link go-link--next">Log out</a></strong></p>

<?php else : ?>
  <blockquote>You <strong>are not</strong> logged in.</blockquote>
  <p>OK, let's redirect you to login. We'll send you to your authorization server here:</p>
  <pre><?php echo authorizeUrl(); ?></pre>
  <p>... along with the following URL parameters:</p>

    <?php
    $state                       = random_bytes( 32 );
    $state                       = base64UrlEncode( $state );
    $_SESSION[SESSION_STATE_KEY] = $state;

    // These will be appended to the authorize URL.
    $authorize_url_params = [
        'scope'                 => 'openid email',
        'response_type'         => 'code',
        'client_id'             => AUTH0_AC_CLIENT_ID,
        'redirect_uri'          => url( 'callback' ),
        'state'                 => $state,
    ];

    if (defined( 'AUTH0_AC_API_AUDIENCE' )) {
        $authorize_url_params['audience'] = AUTH0_AC_API_AUDIENCE;
        $authorize_url_params['scope']   .= ' read:messages';
    }
    ?>

  <ul>
    <li>
      <code>scope</code>:
      The scopes that you want to request authorization for. In this case, we want to identify our user so we'll
      include an OIDC scope. The complete scope being used for this example is:
      <pre><?php echo $authorize_url_params['scope']; ?></pre>
    </li>
    <li>
      <code>response_type</code>:
      For this grant, the value here is always:
      <pre><?php echo $authorize_url_params['response_type']; ?></pre>
    </li>
    <li>
      <code>client_id</code>:
      The Application identifier from Auth0; this has been set to:
      <pre><?php echo $authorize_url_params['client_id']; ?></pre>
    </li>
    <li>
      <code>redirect_uri</code>:
      The URL to which Auth0 will redirect the browser after authorization has been granted by the user;
      this has been set to:
      <pre><?php echo $authorize_url_params['redirect_uri']; ?></pre>
    </li>
    <li>
      <code>state</code>:
      The state value is sent with the authorization request and verified at the callback to help prevent CSRF attacks;
      the value used here is:
      <pre><?php echo $authorize_url_params['state']; ?></pre>
    </li>
    <?php if (defined( 'AUTH0_AC_API_AUDIENCE' )) : ?>
      <li>
          <code>audience</code>:
          The unique identifier of the API the native app wants to access; the API audience here is set to:
          <pre><?php echo $authorize_url_params['audience']; ?></pre>
      </li>
    <?php endif; ?>
  </ul>
  <p>Our final URL will be:</p>
  <pre><?php echo authorizeUrl( $authorize_url_params ); ?></pre>
  <p>And this is what we have stored in session before we go:</p>
    <?php var_dump( $_SESSION ); ?>
  <p>
    <a href="<?php echo authorizeUrl( $authorize_url_params ); ?>"
      class="go-link go-link--next">Let's log in</a></strong>
  </p>

<?php endif; ?>

<?php require_once '../_includes/foot.php'; ?>
