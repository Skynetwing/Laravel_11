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

