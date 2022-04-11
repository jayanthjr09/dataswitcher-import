# Dataswitcher Tech Challenge

## Goal

The objective for this challenge is to convert a small set of data from CSV format into a database, mapping the data according to the given specifications.

Read everything properly. Proper analysis of requirements and data is half the work.

## Relevant Contents

`data` - folder containing the CSV files to read and convert

`specs` - specifications for the data format to store in database

`src`- all your code should be placed in this folder

`tests`- folder for the tests

`convert.php` - command to start the conversion

## Instructions

1. Clone this repository and develop the solution in your own repository

2. Install Docker in your machine

3. Build and run the Docker instances with:

    `docker-compose up -d --build`

4. Wait for it...

5. After the instances are setup you can run commands using:

    `docker-compose run --rm console <command>`

6. Lets run composer update for example:

    `docker-compose run --rm console composer update`

7. Your code should be placed in the /src folder

8. Open `converter.php` and call your code there

9. You can run the converter with

    `docker-compose run --rm console php convert.php`

10. Monolog is available and logs are stored in `app.log`. Use it at will.

11. Good luck!

## Requirements

1. Don't reinvent the wheel. Feel free to install whatever packages you might require.

2. Use an ORM or ODM to access Mongodb.

    We recommend Xenus but choose your prefered one from:

    <https://docs.mongodb.com/drivers/php-libraries/>

3. Be pragmatic in your approach.

4. Without over engineering use SOLID principles and OOP best practices to organize your code (interfaces, abstracts, models, etc).

5. Only map data that is directly available on target, skipping all that is unneeded.

6. Challenge is complete if we see all data correctly stored in Mongodb collections according to the `specs`

## Bonus

The following is OPTIONAL but will be highly valued in your application

1. Add the current balance to the accounts. Feel free to explore the data to find that info.

2. Change the type of transactions that are invoices. Feel free to explore the data to find that info.

3. Use a TDD approach to your solution

## OTHER INFO

### Mongodb connection for your app

`mongodb://dsw_challenge_mongodb:27018/dataswitcher`

You can use Robo 3T <https://robomongo.org/> to check your work

Use localhost:27018 for connection.
