<?php
define('META_TITLE', 'Start - Implicit Grant');

require_once '../_includes/bootstrap.php';

$state                       = random_bytes( 32 );
$state                       = base64UrlEncode( $state );
setcookie( 'auth0_state', $state, SESSION_COOKIE_EXPIRES, '/' );

$nonce                       = random_bytes( 32 );
$nonce                       = base64UrlEncode( $nonce );
setcookie( 'auth0_nonce', $nonce, SESSION_COOKIE_EXPIRES, '/' );

require_once '../_includes/head.php';
?>

<h1>Step 1</h1>

<p>
  Let's see how authentication works using an Implicit grant.
  For more information about this grant and how it should be used, please see the <a
  href="https://github.com/joshcanhelp/oauth-grants-in-php/blob/master/implicit-grant/README.md"
  target="_blank">README here</a>
</p>

<?php require_once '../_includes/logged-in.php'; ?>

<p>OK, set's redirect you to login. We'll send you to your authorization server here:</p>

<pre><?php echo authorizeUrl(); ?></pre>

<p>... along with the following URL parameters:</p>

<?php

// These will be appended to the authorize URL.
$authorize_url_params = [
    'scope'                 => 'openid email',
    'response_type'         => 'id_token',
    'response_mode'         => 'fragment',
    'client_id'             => AUTH0_IMP_CLIENT_ID,
    'redirect_uri'          => url( 'callback' ),
    'state'                 => $state,
    'nonce'                 => $nonce,
];

if (defined( 'AUTH0_IMP_API_AUDIENCE' )) {
    $authorize_url_params['audience'] = AUTH0_IMP_API_AUDIENCE;
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
    For this grant, we have a few options here, <code>token</code> for an access token, <code>id_token</code> for an ID token, and <code>token id_token</code> for both. Here, we'll use:
    <pre><?php echo $authorize_url_params['response_type']; ?></pre>
  </li>
  <li>
    <code>response_mode</code>:
    The value we're using here is the default so it does not have to be set explicitly:
    <pre><?php echo $authorize_url_params['response_mode']; ?></pre>
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
    The state value is sent with the authorization request and verified at the callback to help prevent CSRF attacks.
    This can also be a base64-encoded object or array containing application state data.
    The value used here is:
    <pre><?php echo $authorize_url_params['state']; ?></pre>
  </li>
  <li>
    <code>nonce</code>:
    The state value is sent with the authorization request and added to the ID token when returned.
    This value must be stored and verified when the ID token is verified.
    The value used here is:
    <pre><?php echo $authorize_url_params['nonce']; ?></pre>
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
<pre><?php echo authorizeUrl( $authorize_url_params, true ); ?></pre>

<p>And the cookies we've got are:</p>

<pre id="js-auth0-cookies" class="uses-js"></pre>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script>
var cookieJar = document.querySelector('#js-auth0-cookies');

['auth0_state', 'auth0_nonce'].forEach(function( el ) {
  var cookieName = document.createElement('strong');
  cookieName.textContent = el + ':';
  cookieJar.appendChild(cookieName);

  var cookieVal = document.createTextNode(' ' + Cookies.get(el));
  cookieJar.appendChild(cookieVal);

  var breakEl = document.createElement('br');
  cookieJar.appendChild(breakEl);
});
</script>

<p>
  <a href="<?php echo authorizeUrl( $authorize_url_params ); ?>"
    class="go-link go-link--next">Let's log in</a></strong>
</p>

<?php require_once '../_includes/foot.php'; ?>
