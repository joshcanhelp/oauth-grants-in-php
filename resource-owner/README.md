# Resource Owner Grant

## Intro/Resources

The Resource Owner grant is for applications that are absolutely trusted with the user's credentials. In this flow, the end-user is asked for a username and password, which is sent to the app's backend and from there to Auth0. This grant should be used only when a redirect-based flow, the Authorization Code, is not possible. It should not be used with SPAs or native apps.

#### [Auth0 Docs: Resource Owner Password Grant Overview](https://auth0.com/docs/api-auth/grant/password)

#### [Auth0 Docs: Implement the Resource Owner Password Grant](https://auth0.com/docs/api-auth/tutorials/password-grant)

#### [IETF: The OAuth 2.0 Authorization Framework](https://tools.ietf.org/html/rfc6749#section-4.3)

>  The resource owner password credentials grant type is suitable in cases where the resource owner has a trust relationship with the client, such as the device operating system or a highly privileged application.  The authorization server should take special care when enabling this grant type and only allow it when other flows are not viable.

## How to Run this Demo

1. Clone the repo
2. Create a Regular Web App in the [Auth0 dashboard](https://manage.auth0.com/#/applications)
	1. Add "http://localhost:9000/logout.php" to the **Allowed Logout URLs** field
	2. Scroll down to **Show Advanced Settings** then **Grant Types** and turn on "Password"
	3. Click on the **Connections** tab and make sure only the "Username-Password-Authentication" is turned on.
	4. Save the Application and leave the tab open
3. Add a new user to the "Username-Password-Authentication" connection in the [Auth0 dashboard](https://manage.auth0.com/#/applications)
4. Create a `credentials.php` file in the repo root. Edit this file and:
	1. Define `AUTH0_DOMAIN` as the **Domain** field from your Application
	2. Define `AUTH0_ROPG_CLIENT_ID` as the **Client ID** field from your Application
	3. Define `AUTH0_ROPG_CLIENT_SECRET` as the **Client Secret** field from your Application
5. Navigate to the `resource-owner` folder
6. Start a PHP server: `php -S localhost:9000`
7. Open [localhost:9000](http://localhost:9000) in a browser and follow the steps!

## Additional Notes on this Grant

- Was not designed for native clients
- Customers love it (full control of UX) but robs us of the opportunity to make things better
- At the mercy of how the application was written
	- Open to debugger
	- Saving it incorrectly
- Harder to do anomaly detection like IP address checking
- Limited: no consent, no MFA, no federation, no SSO
- DB only, no social or passwordless
- Good for testing
- What is the real problem?
- Token Endpoint Authentication Method
- Customer concerns (marketing)
	- Fear of the unknown
	- Lack of control over the experience
	- Performance
- Vitamins vs painkillers
- Supported but not recommended
- Cannot do zero trust/continuous authentication
