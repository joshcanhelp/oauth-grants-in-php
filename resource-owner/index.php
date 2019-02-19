<?php
define('META_TITLE', 'Start - Resource Owner');

require_once '../_includes/bootstrap.php';
require_once '../_includes/head.php';
?>

<h1>Step 1</h1>
<p>
  Let's see how authentication works using a Resource Owner grant.
  For more information about this grant and how it should be used, please see the <a
  href="https://github.com/joshcanhelp/oauth-grants-in-php/blob/master/resource-owner/README.md"
  target="_blank">README here</a>
</p>

<?php require_once '../_includes/logged-in.php'; ?>

<p>To log you in, we will POST the following along with your user credentials below:</p>

<?php
// These will be sent to the token endpoint.
$ro_post_body = [
    'grant_type'            => 'password',
    'scope'                 => 'openid email',
    'client_id'             => AUTH0_ROPG_CLIENT_ID,
    'client_secret'         => AUTH0_ROPG_CLIENT_SECRET,
];
?>

<ul>
  <li>
    <code>grant_type</code>:
    This tells the token endpoint what to expect and how to perform the authentication.
    In this case, it will be:
    <pre><?php echo $ro_post_body['grant_type']; ?></pre>
  </li>
  <li>
    <code>scope</code>:
    The scopes that you want to request authorization for. In this case, we want to identify our user
    so we'll ask for an OIDC scope and an email. If you use an <code>audience</code> parameter to request access
    to an API, you can add valid API scopes here as well. The complete scope being used for this example is:
    <pre><?php echo $ro_post_body['scope']; ?></pre>
  </li>
  <li>
    <code>client_id</code>:
    The Application identifier from Auth0; this has been set to:
    <pre><?php echo $ro_post_body['client_id']; ?></pre>
  </li>
  <li>
    <code>client_secret</code>:
    The Application secret from Auth0; this should be kept secure so, I'm sorry, we can't show it:
    <pre><?php echo censor( $ro_post_body['client_secret']  ); ?></pre>
  </li>
</ul>

<p>
  Before we can authenticate, we need two more things: a username and a password.
  This is what makes the Resource Owner grant only appropriate for highly-trusted applications.
</p>

<form action="<?php echo url( 'exchange' ); ?>" method="post">
  <input type="hidden" name="scope" value="<?php echo $ro_post_body['scope']; ?>">
  <input type="hidden" name="grant_type" value="<?php echo $ro_post_body['grant_type']; ?>">

  <p>
    <label for="username">Username or Email</label>
    <input type="text" name="username" id="username" value="" required>
  </p>

  <p>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" value="" required>
  </p>

  <button type="submit" class="go-link go-link--next">Let's log in</button>
</form>

<p class="subtext">* This form should absolutely, positively be served over HTTPS.</p>

<?php require_once '../_includes/foot.php'; ?>
