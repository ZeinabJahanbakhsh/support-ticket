# Introduction

The support ticket system is a simple application that a user can create the ticket and another user can answer it with their own role permissions. Tickets have two status(close/open) which set by admin
Furthermore each user can add one or several comments for the tickets.
This is **laravel api** , The task is fully described [in this article](https://laraveldaily.com/post/demo-project-laravel-support-ticket-system).

- There are 3 roles in this case: admin, user agent and user default 
- The admin has full permission for everything.
- The admin can assign the ticket to another users which has agent role.
- The admin gets an email after a ticket has been registered
- Agent and default users can see their own ticket's log but the admin can see all of them 
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

    ``` 
    php artisan create:record {count}
    ```
  
- Done! Run
  ```
  php artisan serv
  ```
  

# User's credentials
- Admin's credentials: admin@admin.com - 123456


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
