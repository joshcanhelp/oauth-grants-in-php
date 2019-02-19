<p>
  First, we want to check to make sure that the state we've got stored in session
  matches the one we got back from the authorization server.
</p>

<?php if ($_GET['state'] !== $_SESSION[SESSION_STATE_KEY]) : ?>

  <blockquote class="badnews">State values do not match</blockquote>
  <p>
    Your application should NOT continue to log this user in.
    Check to make sure you're storing the state correctly and prompt the user to start over.
  </p>
  <p><a href="/" class="go-link go-link--back">Let's try again</a></strong></p>

  <?php
  require_once '../_includes/foot.php';
endif;
?>

<blockquote class="goodnews">State values match</blockquote>
<p class="subtext">Try changing the <code>state</code> value in the browser URL bar and see what happens.</p>
