## Laravel Project README

Development started on 2024-05-04 by Zajjith Vedha.

## Product Images
1. Ensure that product entries include images to display them on the homepage.

## Logo and Favicon
1. Copy and paste the images from `documents/images` to `storage/app/public` folder to see the logo and favicon.
   - This ensures that the logo and favicon are correctly displayed on the website.


To run the application in development/localhost, follow these steps:
## Prerequisites
- Ensure you have PHP and Node.js installed on your system.

## Development Setup
1. Open two terminals.
2. In the first terminal, run:
    php artisan serve --port=8001
3. In the second terminal, run:
    npm run watch

These commands will allow you to see the changes in real-time without needing to refresh the page.

## Cloning and Running the Project
1. After cloning the repository, navigate to the project directory.
2. Install PHP dependencies by running:
    composer install
3. Update composer dependencies with:
    composer update
4. Create a symbolic link to the storage directory:
    php artisan storage:link
5. Update the `.env` file with your database configurations.
6. Generate an application key:
    php artisan key:generate
7. Run database migrations:
    php artisan migrate:fresh
8. Seed the database (if necessary):
    php artisan db:seed
9. Cache the configuration:
    php artisan config:cache
10. Clear the application cache:
    php artisan cache:clear
11. Optimize the application:
    php artisan optimize
12. Finally, reload the autoloader:
    composer dump-autoload

After completing these steps, you can run the project without any issues.


## Admin Credentials
- **Username:** zajjith@gmail.com
- **Password:** secret

Access to the product CRUD APIs is restricted and requires authentication. You can obtain an access token by logging in using the provided admin credentials.

## Obtaining Access Token
1. Use the login API endpoint with the provided admin credentials to authenticate.
2. Upon successful authentication, the API will respond with an access token.

## Using the Access Token
- Pass the access token as a bearer token in the authorization header when making requests to the product CRUD APIs.
- Example: `Authorization: Bearer <access_token>`

Ensure to include the access token in every request header to access the restricted APIs successfully.

Thank you!