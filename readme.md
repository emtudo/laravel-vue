# Skeleton Laravel With Vuejs

## Dependencies
  - php 7.2
  - mysql 5.7
  - npm
  - composer

## How to install

[How to install video In Portugues](https://www.youtube.com/watch?v=Vk-uuq3uuPI)


```shell
composer create-project emtudo/laravel-vue
cd laravel-vue
npm install
php artisan jwt:generate
```

Configure the `.env` file after configuring run the command below to create the database:

```shell
php artisan migrator
```

## How to test

At the first terminal
```shell
php artisan serve
```

At the second terminal
```shell
npm run dev
```

## Admin

- username: admin@user.com
- password: abc123
