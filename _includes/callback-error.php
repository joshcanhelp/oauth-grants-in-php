<?php
$error_code = isset( $_GET['error'] ) ? $_GET['error'] : null;
$error_desc = isset( $_GET['error_description'] ) ? $_GET['error_description'] : null;
?>

<p>Welcome back from the authentication server!</p>

<?php if ($error_code) : ?>
  <p>
    Uh oh, looks like something went wrong.
    We've got an <code><?php echo $error_code; ?></code> error that says:
  </p>

  <?php if ($error_desc) : ?>
  <blockquote><?php echo $error_desc; ?></blockquote>
  <?php endif; ?>

  <p><a href="/" class="go-link go-link--back">Let's try again</a></strong></p>

  <?php
  require_once '../_includes/foot.php';
endif;
?>
