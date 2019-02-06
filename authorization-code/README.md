# Authorization Code Grant

## Intro/Resources

TBD

## How to Run this Demo

1. Clone the repo
2. Create a Regular Web Application in the [Auth0 dashboard](https://manage.auth0.com/#/applications)
	1. Add "http://localhost:9000/callback.php" to the **Allowed Callback URLs** field
	2. Add "http://localhost:9000/logout.php" to the **Allowed Logout URLs** field
	3. Save the Application and leave the tab open
3. Create an API in the [Auth0 dashboard](https://manage.auth0.com/#/apis) (optional)
	1. Keep all defaults
	2. Click the **Scopes** tab and add `read:messages`
4. Create a `credentials.php` file in the repo root. Edit this file and:
	1. Define `AUTH0_DOMAIN` as the **Domain** field from your Application
	2. Define `AUTH0_AC_CLIENT_ID` as the **Client ID** field from your Application
	3. Define `AUTH0_AC_API_AUDIENCE` as the **Identifier** field from your API (optional)
5. Navigate to the `authorization-code` folder
6. Start a PHP server: `php -S localhost:9000`
7. Open [localhost:9000](http://localhost:9000) in a browser and follow the steps!
