<p>Welcome back from the authentication server!</p>

<?php if (isset( $_GET['error'] )) : ?>
  <p>
    Uh oh, looks like something went wrong.
    We've got an <code><?php echo $_GET['error']; ?></code> error that says:
  </p>
  <blockquote><?php echo $_GET['error_description']; ?></blockquote>
  <p><a href="/" class="go-link go-link--back">Let's try again</a></strong></p>

  <?php
  require_once '../_includes/foot.php';
endif;
?>
