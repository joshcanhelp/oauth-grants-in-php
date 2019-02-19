<?php
define('META_TITLE', 'Callback - Implicit Grant');

require_once '../_includes/bootstrap.php';
require_once '../_includes/head.php';
?>

<h1>Step 2</h1>

<p>
  This grant is used for browser-based applications, not postback ones, so we need some help from JavaScript.
  We have a few important values in a URL fragment:
</p>

<pre id="js-auth0-fragment" class="uses-js"></pre>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
<script>
var fragment = window.location.hash.replace('#', '').split('&');
var callbackData = {};
var fragmentJar = document.querySelector( '#js-auth0-fragment' );
fragment.forEach(function(el) {
  var elParts = el.split('=');
  callbackData[elParts[0]] = elParts[1];

  var partName = document.createElement('strong');
  partName.textContent = elParts[0] + ':';
  fragmentJar.appendChild(partName);

  var partVal = document.createTextNode(' ' + elParts[1]);
  fragmentJar.appendChild(partVal);

  var breakEl = document.createElement('br');
  fragmentJar.appendChild(breakEl);
});
</script>

<p>
  Now, we want to check to make sure that the state we've got stored in our cookie
  matches the one we got back from the authorization server:
</p>

<div id="js-state-match" style="display: none">
  <blockquote class="goodnews">State values match</blockquote>
  <p class="subtext">Try changing the <code>state</code> value in the browser URL bar and see what happens.</p>
  <p>The authentication is now complete!</p>
  <p><a href="/" class="go-link go-link--back">Back Home</a></p>
</div>

<div id="js-state-no-match" style="display: none">
  <blockquote class="badnews">State values do not match</blockquote>
  <p>
    Your application should NOT continue to log this user in.
    Check to make sure you're storing the state correctly and prompt the user to start over.
  </p>
  <p><a href="/" class="go-link go-link--back">Let's try again</a></strong></p>
</div>

<script>
if ( callbackData.state === Cookies.get('auth0_state') ) {
  document.querySelector('#js-state-match').style.display = "block";
  Cookies.set('auth0_id_token', callbackData.id_token );
} else {
  document.querySelector('#js-state-no-match').style.display = "block";
}
</script>

<?php require_once '../_includes/foot.php'; ?>
