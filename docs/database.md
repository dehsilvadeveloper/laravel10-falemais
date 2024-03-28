## Database

### Entering MYSQL container

To enter the container of *MySQL*, you can use the following command:

```
docker-compose exec mysql mysql -u root -p
```

The terminal will ask for the password and you should inform the answer *root*. After this you will be able to run any necessary SQL queries.

You can, for example, see the databases created.

```
SHOW DATABASES;
```

This query is useful to see if the application created the related database with success. The name of the database is available on environment variable *DB_DATABASE*. The default database name for this project is *falemais*.

You can also see the tables inside a database with the following query:

```
USE falemais; SHOW TABLES;
```

### Connecting programs to the dockerized MYSQL database

To connect to the dockerized MYSQL database using programs like **Mysql Workbench**, you can use the following information.

```
hostname: mysql
port: 3398
username: root
password: root
```