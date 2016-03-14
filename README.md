Resizer API
===========

Resizer is a simple app written on Yii2 framework. It's used for image resizing with given params.
Project has been created as test task for [Yalantis](https://yalantis.com)

### Documentation
Full API documentation is listed [here](http://docs.resizer.apiary.io/#)

### Installation
1. Run ```composer install``` in project root directory.
2. Edit config file ```/config/db.php``` and specify your dsn connection string.
3. Run DB migrations with ```php yii migrate```

### Code
Yii2 has a little bit complex structure, so here is source code where main aplication logic is stored. This is what you are probably looking for.

Controllers : [v1/controllers/](https://github.com/MEGApixel23/resizer/tree/master/v1/controllers)
Models: [v1/models/](https://github.com/MEGApixel23/resizer/tree/master/v1/models)
Configuration: [config/web.php](https://github.com/MEGApixel23/resizer/blob/master/config/web.php)
Tests: [tests/codeception/api/](https://github.com/MEGApixel23/resizer/tree/master/tests/codeception/api)

### Tests
Tests for this API are developed with [Codeception PHP Testing Framework](http://codeception.com/). To run API tests you need to do a lot of stuff.

1. Install Codeception if it's not yet installed:

   ```
   composer global require "codeception/codeception"
   composer global require "codeception/specify"
   composer global require "codeception/verify"
   ```

   If you've never used Composer for global packages run `composer global status`. It should output:

   ```
   Changed current directory to <directory>
   ```

  Then add `<directory>/vendor/bin` to you `PATH` environment variable. Now we're able to use `codecept` from command
  line globally.

2. Create database for tests and specify its connection string in ```tests/codeception/config/config.php```

3. Update your database with migration command
    ```
    test/codeception/bin/yii migrate
  ```


4. In order to be able to run acceptance tests you need to start a webserver. The simplest way is to use PHP built in
webserver. In the `web` directory execute the following:

   ```
   php -S localhost:8080
   ```
   
5. Now you can run the tests with the following commands (if you are in ```tests``` directory):
    ```
   codecept run
   ```