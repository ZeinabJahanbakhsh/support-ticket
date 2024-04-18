# Introduction

The support ticket system is a simple application that a user can create the ticket and another user can answer it with their own role permissions. Tickets have two status(close/open) which set by admin
Furthermore each user can add one or several comments for the tickets.
This is **laravel api** , The task is fully described [in this article](https://laraveldaily.com/post/demo-project-laravel-support-ticket-system).

- There are 3 roles in this case: admin, user agent and user default 
- The admin has full permission for everything.
- The admin can assign the ticket to another users which has agent role.
- Agent and default users can create ticket and register comments.
- Agent users can edit their own tickets but default users can not!
- You can see json data with [postman account](https://www.postman.com/blue-crater-7468/workspace/support-ticket)

# Features
- Backend: [Laravel 10](https://laravel.com/docs/10.x/installation)
- Database: Mysql
- Authentication: [Sanctum](https://laravel.com/docs/10.x/sanctum)
- Authorization: Gate and Policy
- Email verification: [Mail trap](https://mailtrap.io) 
- Laravel-Activity log: [Spatie Laravel Activity Log](https://github.com/spatie/laravel-activitylog)
- Console command : insert-demo-data

# How to use:
- Clone the repository with git clone
- Copy .env.example file to .env and edit database credentials there and make your database.
- Run
  ```
  composer install
  ```

  ```
  php artisan key:generate
  ```


- Instead of run migrations and seeders you can run my console command:
    - Run below code (it can create migrations and insert demo data with 3 users: an admin, some agents and some default users at the end run php artisan optimize:clear)
      ``` 
      php artisan insert-demo-data
      ```
    - If you don't want to insert any data, it is just enough to run:
      ``` 
      php artisan migrate 
      ```
- Done! Run
  ```
  php artisan serv
  ```
 

# User's credentials
- Admin's credentials: admin@admin.com - 123456


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
