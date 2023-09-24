# talantikaQuize
Для реализации проекта выбрал стек Laravel 10 + vue 3, для стора использовал pinia.
Выбор свой объясняю тем что хотел поработать с новой версией laravel и vue 3 с которыми раньше работать не приходилось.
Проект разделен на backend и frontend части для удобства. 
В базе оставил только результаты прохождения квиза и пользователей, все данные по вопросам положил в config.questionsData, т.к время было ограничено и в тз 
не было описано какая то итерация с ними, поэтому пока они статичны, но модели и миграции я создал, для возможности расширения.
На сервер постараюсь выложить в близжайшее время, только оплатил его, 
пока что записал небольшую демонстрацию, по заморозке на 10 минут для демонстрации убрал, т.к ждать 10 минут довольно долго.
Доступ по ссылке на google drive: https://drive.google.com/file/d/1PWduCXmmzYpWh1nknF0VLxn_Yipi9DvW/view?usp=sharing
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