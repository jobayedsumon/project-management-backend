
## Steps to run the backend

- Clone the repository
- Run `composer install` to install all the dependencies
- Copy the `.env.example` file to `.env`
- Create a database and update the credentials in the `.env` file
- Run `php artisan key:generate` to generate the application key
- Run `php artisan migrate` to run the migrations
- Run `php artisan db:seed` to seed the database
- Run `php artisan storage:link` to create a symbolic link from `public/storage` to `storage/app/public`
- Run `php artisan serve` to start the server (or use Laravel Valet or Laravel Homestead)

## Admin Credentials
Email: admin@projectmanagement.test
Password: projectmanagement
