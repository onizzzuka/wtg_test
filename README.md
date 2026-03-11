# The test task for WTG Spain

Is done by [Igor Klimov](https://djinni.co/q/de5ff2782a/).

## Used stack
1. Laravel 11 (as it's asked in the task description).
2. Vue 3.
3. Laravel Reverb + Redis for messages sync.
4. MySQL 8.0 as a storage.
5. DDEV (docker based dev environment).

## Usage
1. `composer install`, `npm install` and so on usual Laravel way.
2. In your .env, follow the next template:
    ```dotenv
    REVERB_HOST=your.app.domain
    REVERB_PORT=8080
    REVERB_SCHEME=http
    
    REVERB_SERVER_HOST=0.0.0.0
    REVERB_SERVER_PORT=8080
    REVERB_SERVER_SCHEME=http
    ```
3. If you use DDEV as a local environment, add the add-on `ddev/ddev-redis` add the following instructions to your config.yaml:
   ```yaml
   web_extra_exposed_ports:
    - name: reverb
      container_port: 8080
      http_port: 8081
      https_port: 8080
   web_extra_daemons:
    - name: reverb
      command: bash -c 'php artisan reverb:start --host="0.0.0.0" --port=8080 --hostname="your.app.domain"'
      directory: /var/www/html
     ```
   (or start it manually later)
4. Don't forget to run VITE :)
5. Run `php artisan migrate --seed` to create the database and seed it (or register new users manually).
6. Users are created automatically. It's 5 users with the same password `123456` and emails like user1@example.com and so on.
7. Login with any of the users and you can chat now.

## What can be done better?
### Backend
1. Code should be separated into services. For now, it's overengineering but should be improved.
2. The functionality should be covered with tests. For now, there are no tests at all.
3. The messages are not encrypted, so it's not secure.
4. Overall, UI issues described below should be implemented too.

### UI 
1. The UI is very basic, it can be improved a lot.
2. The messages are not paginated, so if there are a lot of messages, it can be a problem.
3. The messages are not marked as read, so if you have a lot of messages, it can be a problem.
4. The users are not marked as online/offfline, so it's not clear who is online and who is not.
