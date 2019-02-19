<p>
  First, let's check what's in our PHP session (<code><?php echo SESSION_AUTH_KEY; ?></code> key)
  to see if we're already logged in:
</p>

<?php if (! empty( $_SESSION['auth0_session'] ) || ! empty( $_COOKIE['auth0_id_token'] ) ) : ?>
  <blockquote>You <strong>are</strong> logged in.</blockquote>
  <p>
    You can validate and decode the ID token below to determine the user
    (try pasting this into <a href="https://jwt.io" target="_blank">jwt.io</a>):
  </p>
  <pre><?php
  if (! empty( $_SESSION['auth0_session'] ) ) {
    echo $_SESSION['auth0_session']['id_token'];
  } else {
    echo $_COOKIE['auth0_id_token'];
  }
  ?></pre>
  <p><a href="<?php echo logoutUrl(); ?>" class="go-link go-link--next">Log out</a></p>
  <?php
  require_once '../_includes/foot.php';
endif;
?>

<blockquote>You <strong>are not</strong> logged in.</blockquote>
