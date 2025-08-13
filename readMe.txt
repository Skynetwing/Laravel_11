1. laravel new project_name
2. .env >> "DB_CONNECTION=sqlite" to "DB_CONNECTION=mysql"
3. php artisan migrate
*** Install Laravel UI ***
4. composer require laravel/ui
5. php artisan ui bootstrap --auth
6. npm install
7. npm run dev
*** Install API ***
php artisan install:api

https://www.itsolutionstuff.com/post/laravel-11-user-roles-and-permissions-tutorialexample.html#:~:text=After%20registering%20a%20user%2C%20you,%2Dedit%2C%20product%2Ddelete.

Create "User" "Role" and "Permission"
php artisan optimize
php artisan migrate
php artisan db:seed --class=PermissionTableSeeder
php artisan db:seed --class=CreateAdminUserSeeder


// Razorpay
composer require razorpay/razorpay
php artisan make:controller RazorpayController
php artisan make:model Payment
php artisan make:migration create_payments_table
php artisan make:class Services/PaymentService


// Send Mail
** Set Mail in env**
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=testmail@gmail.com
MAIL_PASSWORD=dsfrvwrtdfcrtgdfd
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=testmail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

php artisan make:controller MailController
php artisan make:mail TestMail
php artisan make:view send_mail


// Queue and Job
