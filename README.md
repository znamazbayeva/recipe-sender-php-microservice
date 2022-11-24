# Recipe Sender Php microservice

## Всегда голодны?

![Здесь должна быть гифка](https://github.com/znamazbayeva/recipe-sender-php-microservice/blob/main/hungry.gif)

Наше приложение поможет вам с рецептом блюд на каждай день!

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


# EXTRA

1. Test crontab by opening

```
crontab -e
```

2. Writing the task down
```
1 * * * * cd /path-to-our-github/recipe-sender-php-microservice/ && php -f script.php

```
3. Saving and starting crontab

```
CTRL (CMD)+ X
CTRL (CMD)+ Y
```
