<?php
define('META_TITLE', 'Callback - Authorization Code with PKCE');

require_once '../_includes/bootstrap.php';
require_once '../_includes/head.php';
?>

<h1>Step 2</h1>

<p>Welcome back from the authentication server!</p>

<?php require_once '../_includes/callback-error.php'; ?>

<p>If you've gotten this far then you're halfway to logging in.</p>

<p>Here's what we got back from the server in our URL:</p>
<?php var_dump( $_GET ); ?>

<p>
  First, we want to check to make sure that the state we've got stored in session
  matches the one we got back from the authorization server.
</p>

<?php require_once '../_includes/callback-state-check.php'; ?>

<p>As a reminder, here's what we've got stored in session:</p>
<?php var_dump( $_SESSION ); ?>
<p>Now, we're take to POST the <code>code</code> value from our URL to our token endpoint:</p>
<pre><?php echo tokenEndpointUrl(); ?></pre>
<p>
    Here's what we'll be sending.
    You can use these values in an API tool like Postman as well to see the response:
</p>
<ul>
  <li>
    <code>grant_type</code>:
    For this example, the grant type is:
    <pre>authorization_code</pre>
  </li>
  <li>
    <code>client_id</code>:
    The same Application identifier as before:
    <pre><?php echo AUTH0_AC_CLIENT_ID; ?></pre>
  </li>
  <li>
    <code>client_secret</code>:
    The Client Secret for the Application:
    <pre><?php echo AUTH0_AC_CLIENT_SECRET; ?></pre>
  </li>
  <li>
    <code>code</code>:
    The code returned by the authorization server:
    <pre><?php echo $_GET['code']; ?></pre>
  </li>
  <li>
    <code>redirect_uri</code>:
    The same redirect_uri sent in the first step:
    <pre><?php echo url( 'callback' ); ?></pre>
  </li>
  <?php if (defined( 'AUTH0_AC_API_AUDIENCE' )) : ?>
    <li>
        <code>audience</code>:
        The same audience sent in the first step:
        <pre><?php echo AUTH0_AC_API_AUDIENCE; ?></pre>
    </li>
  <?php endif; ?>
</ul>
<p>
  <a href="exchange.php?<?php echo http_build_query( $_GET ); ?>"
    class="go-link go-link--next">Send the request</a>
</p>


<?php require_once '../_includes/foot.php'; ?>
