# PKCE on Desktop + Mobile

## Intro/Resources

This example covers an Authorization Code grant with PKCE. This grant is meant to protect public clients, such as native mobile and desktop apps, when switching context to a system browser to fulfill authentication.

#### [Auth0 Docs: Mobile Login Flow Concept](https://auth0.com/docs/flows/concepts/mobile-login-flow)

> The PKCE-enhanced Authorization Code Flow introduces a secret created by the calling application that can be verified by the authorization server; this secret is called the Code Verifier.

> The calling app creates a transform value of the Code Verifier called the Code Challenge and sends this value over HTTPS to retrieve an Authorization Code. This way, a malicious attacker can only intercept the Authorization Code, and they cannot exchange it for a token without the Code Verifier.

#### [Auth0 Docs: Auth Code with PKCE Tutorial](https://auth0.com/docs/api-auth/tutorials/authorization-code-grant-pkce)

#### [Auth0 Docs: Authentication API](https://auth0.com/docs/api/authentication#native-mobile-login-flow44)

#### [Auth0 Blog: OAuth 2.0 Best Current Practice for Native Apps](https://auth0.com/blog/oauth-2-best-practices-for-native-apps/)

> Embedded user agents are unsafe for third parties. If used, the app has access to the OAuth authorization grant as well as the user's credentials, leaving this data vulnerable to recording or malicious use.
> Embedded user agents also don't share authentication state, meaning no single sign-on benefits can be conferred.
> Browser security is also a major focus of vendors, and they tend to manage security and sessions policies quite well.
> Cross-Site Request Forgery (CSRF) attacks should also be mitigated by using the state parameter to link client requests and responses.
> Authorization servers can protect against these fake user agents by requiring an authentication factor only available to genuine external user agents.

#### [IETF: OAuth 2.0 for Native Apps](https://tools.ietf.org/html/rfc8252)

>  This best current practice requires that only external user-agents like the browser are used for OAuth by native apps.  It documents how native apps can implement authorization flows using the browser as the preferred external user-agent ... This practice is also known as the "AppAuth pattern", in reference to open-source libraries [AppAuth] that implement it.

## How to Run this Demo

1. Clone the repo
2. Create a Native Application in the [Auth0 dashboard](https://manage.auth0.com/#/applications)
	1. Add "http://localhost:9000/callback.php" to the **Allowed Callback URLs** field
	2. Add "http://localhost:9000/logout.php" to the **Allowed Logout URLs** field
	3. Save the Application and leave the tab open
3. Create an API in the [Auth0 dashboard](https://manage.auth0.com/#/apis)
	1. Keep all defaults
	2. Click the **Scopes** tab and add `read:messages`
4. Create a `credentials.php` file in the repo root. Edit this file and:
	1. Define `AUTH0_DOMAIN` as the **Domain** field from your Application
	2. Define `AUTH0_ACPKCE_CLIENT_ID` as the **Client ID** field from your Application
	3. Define `AUTH0_ACPKCE_API_AUDIENCE` as the **Identifier** field from your API
5. Navigate to the `authorization-code-with-pkce` folder
6. Start a PHP server: `php -S localhost:9000`
7. Open [localhost:9000](http://localhost:9000) in a browser and follow the steps!

## Additional Notes on this Grant

- Redirect URI (https://tools.ietf.org/html/rfc8252#section-7):
	- **Private-Use URI Scheme Redirection** - Many platforms support inter-app communication via URIs by allowing apps to register private-use URI schemes ("custom URL schemes") like "com.example.app".  When the browser or another app attempts to load a URI with a private-use URI scheme, the app that registered it is launched to handle the request.
	- **Claimed "https" Scheme URI Redirection** - Some operating systems allow apps to claim "https" scheme URIs in the domains they control (like https://app.example.com/oauth2redirect/example-provider). When the browser encounters a claimed URI, instead of the page being loaded in the browser, the native app is launched with the URI supplied as a launch parameter.
	- **Loopback Interface Redirection** - Native apps that are able to open a port on the loopback network interface without needing special permissions (typically, those on desktop operating systems) can use the loopback interface to receive the OAuth redirect. Loopback redirect URIs use the "http" scheme and are constructed with the loopback IP literal and whatever port the client is listening on. That is, "http://127.0.0.1:{port}/{path}" for IPv4, and "http://[::1]:{port}/{path}" for IPv6.

## How to Perform this Grant

- Browser flow: first try the resource, then redirected to the AS
- Native flow: logic is all in the device, no browser, so ask for token first
- First request is GET from the native app to AS authorization endpoint:
	- response_type=code
	- code_challenge= ties the code to this specific request; generated from a cryptographically-random code_verifier created in the app
	- code_challenge_method=sha256
	- scope= is "openid" plus API scopes required
	- redirect_uri= is a system URI, not a URL
- Response from AS is:
	- stores the code_challenge value
	- 302 back to redirect_uri with code= parameter
	- cookie from AS server, SSO is possible now in browser
- Second request is POST from the native app to the token endpoint:
	- grant_type=authorization_code
	- code= same as response from AS
	- code_verifier= takes the place of client_secret
	- Same as confidential client otherwise
- Response is:
	- Verify the code_challenge with the sent code_verifier
	- Rest is the same as regular AC grant
- Refresh token is a very sensitive session artifact
	- does not need a client_secret to exchange
	- must be revoked if compromised
	- strategies to prevent abuse: token binding, proprietary device management
