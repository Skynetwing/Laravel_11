1. laravel new project_name
2. .env >> "DB_CONNECTION=sqlite" to "DB_CONNECTION=sqlite"
3. php artisan migrate
4. composer require laravel/ui
5. npm install
6. npm run dev

https://www.itsolutionstuff.com/post/laravel-11-user-roles-and-permissions-tutorialexample.html#:~:text=After%20registering%20a%20user%2C%20you,%2Dedit%2C%20product%2Ddelete.

Create "User" "Role" and "Permission"
php artisan optimize
php artisan migrate
php artisan db:seed --class=PermissionTableSeeder
php artisan db:seed --class=CreateAdminUserSeeder

