## Getting started

### Application requirements

To be able to install and use the application, your machine has to have **Docker** installed.

### Installing the application

These are the instructions to install the application, make it ready for use. Open a terminal on the folder where do you want to save the application and follow these steps.

1. Clone the files from the repository to your machine.

```
git clone https://github.com/dehsilvadeveloper/laravel10-falemais.git laravel10-falemais
```

2. Enter the application folder.

```
cd laravel10-falemais
```

3. Duplicate the `.env.example` file, renaming the copy to `.env`. This file contains the environments variables that will be used by the application. You can do this manually or with the following command if you are using *Linux*:

```
cp .env.example .env
```

4. The next step is build the Docker containers. For this you have to use the following command:

```
docker-compose build --no-cache
```

5. After the containers are built, you need to enable them for use. For this you have to use the following command:

```
docker-compose up -d
```

The `-d` means that the terminal will be *detached*, in other words, it won't be necessary to keep the terminal open for the application to keep running.

6. Now you need to install the application dependencies using the dependency manager called **Composer**. For this you have to use the following command:

```
docker-compose exec main composer install --no-interaction
```

7. After this you need to generate a optimized autoload of application classes (classmap) for better performance. For this you have to use the following command:

```
docker-compose exec main composer dump-autoload -o
```

8. The next step is to generate the *application key*. This key is used for any encryption realized by the application (passwords, for example). For this you have to use the following command:

```
docker-compose exec main php artisan key:generate
```

9. Now you need to run the *migrations*, creating the database structure for the application. For this you have to use the following command:

```
docker-compose exec main php artisan migrate
```

10. The next step is to run the *seeders*, filling the database tables with necessary data. For this you have to use the following command:

```
docker-compose exec main php artisan db:seed
```

With this all the required data will be in the database.

If you, for some reason, has the need to run a specific seeder class, you can use the **--class** informing the name of the class.

```
docker-compose exec main php artisan db:seed --class=GenericSeeder
```

**Installation finished**

After following the installation steps, the application is ready to use on the following url:

```
http://localhost:9999
```

The application port can be customized using the environment variable *APP_PORT*.

You only need to make the installation procedure once.

### Starting the application

If you want to **start** the application, use the following command on a terminal opened from the application folder:

```
docker-compose up -d
```

The `-d` means that the terminal will be *detached*, in other words, it won't be necessary to keep the terminal open for the application to keep running.

### Shutting down the application

If you want to **stop** the application, use the following command on a terminal opened from the application folder:

```
docker-compose down
```

This script will get down all Docker containers and the application will not be available for use anymore.

### Using the API

With the application ready for use, you can refer to the following documentation to get more information about how to test the API:

[Using the API](./docs/using_api.md)