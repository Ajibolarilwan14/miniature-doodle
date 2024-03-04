## Cloning Repository

Clone this repository into your local machine && cd into the project root via a terminal

## Install Dependecies && Setting up DB

After you cd into the project root in your terminal, run:
- composer update
- cp .env.example .env
- create a fresh db in your local MYSQL server
- update the DB credentials in the .env file
- php artisan migrate --seed

## Installing Redit

This project make use of the redis DB and predis database client, make sure you have redis installed on your PC for this project to work. If you do not have redis installed on your PC, head over to **[Redis DB](https://redis.io)** and install one + plus a redis insight tool if you'd like to see all caching data in real-time.

## Serving the application

Navigate to the project root and run
- php artisan migrate

The app should be up and running on port:8000, you can then head over to postman to test the endpoints

## Using the postman collection

I've extracted the postman collection with this project to make things easy, extract it into your postman collection and:
- Create a new environment variable that'd house the base_url and auth_token.
- The collection contains three subfolder, only the auth folder is not a protected endpoint.
- I already setup a test script on the postman collection that runs each time there's a successfully login by the user so you don't have to worry about manually copying the token.
- Each endpoint has an example response so you can have an overview of what the return data will look like.
- Start testing all the endpoints

## Running tests

Head over to the terminal and cd into the project root and run:
./vendor/bin/pest
to run tests and see all assertions and results.
