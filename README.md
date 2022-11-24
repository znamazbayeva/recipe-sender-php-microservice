# Recipe Sender Php microservice

Installation:

1. Install dependencies
```
composer install
```
2. Create new database

```
CREATE DATABASE recipe_db;

USE recipe_db;

CREATE TABLE users(
                      id INTEGER PRIMARY KEY AUTO_INCREMENT,
                      name VARCHAR(255),
                      telegram_id INT,
                      first_name VARCHAR(255),
                      last_name VARCHAR(255),
                      chat_id INT,
                      created_at DATETIME default CURRENT_TIMESTAMP,
                      updated_at DATETIME,
                      deleted_at DATETIME
);

CREATE TABLE Mail(
                      id INTEGER PRIMARY KEY AUTO_INCREMENT,
                      letter VARCHAR(255),
                      created_at DATETIME default CURRENT_TIMESTAMP
);
```

3. Put the database information in env file

```
DB_NAME="recipe_db"
DB_HOST="localhost"
DB_USER="root"
DB_PASSWORD="zhanarys"
```
4. Run the project

```
php -S localhost:8080 
```
