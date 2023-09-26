# talantikaQuize
Для реализации проекта выбрал стек Laravel 10 + vue 3, для стора использовал pinia.
Выбор свой объясняю тем что хотел поработать с новой версией laravel и vue 3 с которыми раньше работать не приходилось.
Проект разделен на backend и frontend части для удобства. 
В базе оставил только результаты прохождения квиза и пользователей, все данные по вопросам положил в config.questionsData, т.к время было ограничено и в тз 
не было описано какая то итерация с ними, поэтому пока они статичны, но модели и миграции я создал, для возможности расширения.
Для начала викторины потребуется авторизация, для обычных пользователей достаточно имени, по нему идет аутентификация и сохранение результатов в бд,
для администратора есть пароль, при вводе в поле "Имя" - admin, появляется поле для ввода пароля, пароль от admin - "password".
В админской панели есть только таблица статистики по викторине у игроков, в тз не был расписан конкретный функционал для нее.
На сервер постараюсь выложить в ближайшее время, только оплатил его, 
пока что записал небольшую демонстрацию, по заморозке на 10 минут для демонстрации убрал, т.к ждать 10 минут довольно долго.
Доступ по ссылке на google drive: https://drive.google.com/file/d/1PWduCXmmzYpWh1nknF0VLxn_Yipi9DvW/view?usp=sharing
UPDATE: после долгого ожидания доступов к арендованному серверу(ждал логина и пароля целые сутки, писал в техподдержку) выложил проект на http://31.31.199.42:3000/
Сервер дешевенький, поэтому иногда тупит и довольно медленный, но для демонстрации достаточно ¯\_(ツ)_/¯
# Lets Start
Чтобы развернуть проект у себя локально в backend введите

```sh
npm install
composer install
php artisan migrate
php artisan db:seed
```

cd frontend
Тут обязательно поменяйте в src/utils/axiosData.js константу hostname (для локального развертывания обычно используется localhost)

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
npm run dev
```