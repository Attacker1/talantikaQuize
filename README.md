# talantikaQuize
Для реализации проекта выбрал стек Laravel 10 + vue 3, для стора использовал pinia.
Выбор свой объясняю тем что хотел поработать с новой версией laravel и vue 3 с которыми раньше работать не приходилось.
Проект разделен на backend и frontend части для удобства. На сервер постараюсь выложить в близжайшее время, только оплатил его.
# Lets Start
Чтобы развернуть проект у себя локально в backend введите

```sh
npm install
composer install
php artisan migrate
php artisan db:seed
```

cd frontend

```sh
npm install
```

Для локального запуска

in backend
```sh
php artisan serve --port=81
```

in frontend
```sh
npm run dev```