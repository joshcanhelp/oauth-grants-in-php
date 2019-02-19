<?php
$id_token = null;

if (! empty( $_SESSION['auth0_session'] )) {
  $id_token = $_SESSION['auth0_session']['id_token'];
} else if (! empty( $_COOKIE['auth0_id_token'] )) {
  $id_token = $_COOKIE['auth0_id_token'];
}
?><p>
  First, let's check what's in our PHP session or cookies to see if we're already logged in:
</p>

<?php if ($id_token) : ?>
  <blockquote>You <strong>are</strong> logged in.</blockquote>
  <p>
    You can validate and decode the ID token below to determine the user
    (try pasting this into <a href="https://jwt.io" target="_blank">jwt.io</a>):
  </p>
  <pre><?php echo $id_token; ?></pre>
  <p><a href="<?php echo logoutUrl(); ?>" class="go-link go-link--next">Log out</a></p>
  <?php
  require_once '../_includes/foot.php';
endif;
?>

<blockquote>You <strong>are not</strong> logged in.</blockquote>
