# Implicit Grant

## Intro/Resources

The Implicit grant is for many different types of applications.

#### [Single Page Login Flow](https://auth0.com/docs/flows/concepts/single-page-login-flow)

#### [Auth0 Docs: Add Login to SPAs](https://auth0.com/docs/flows/guides/single-page-login-flow/add-login-using-single-page-login-flow)

#### [IETF: The OAuth 2.0 Authorization Framework](https://tools.ietf.org/html/rfc6749#section-4.2)

## How to Run this Demo

1. Clone the repo
1. Create a Native Application in the [Auth0 dashboard](https://manage.auth0.com/#/applications)
	1. Add "http://localhost:9000/callback.php" to the **Allowed Callback URLs** field
	1. Add "http://localhost:9000/logout.php" to the **Allowed Logout URLs** field
	1. Save the Application and leave the tab open
1. Create an API in the [Auth0 dashboard](https://manage.auth0.com/#/apis)
	1. Keep all defaults
	1. Click the **Scopes** tab and add `read:messages`
1. Create a `credentials.php` file in the repo root. Edit this file and:
	1. Define `AUTH0_DOMAIN` as the **Domain** field from your Application
	1. Define `AUTH0_IMP_CLIENT_ID` as the **Client ID** field from your Application
	1. Define `AUTH0_IMP_API_AUDIENCE` as the **Identifier** field from your API
1. Navigate to the `implicit-grant` folder
1. Start a PHP server: `php -S localhost:9000`
1. Open [localhost:9000](http://localhost:9000) in a browser and follow the steps!
