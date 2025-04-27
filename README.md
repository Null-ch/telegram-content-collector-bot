# Telegram Content Collector Bot

Бот для сбора контента из Telegram с использованием Laravel и MadelineProto.

## Описание

Этот проект представляет собой бота для сбора контента из Telegram. Он построен на базе фреймворка Laravel и использует библиотеку MadelineProto для работы с Telegram API.

## Требования

- PHP 8.2 или выше
- Composer
- Node.js и NPM
- SQLite (или другая поддерживаемая база данных)

## Установка

1. Клонируйте репозиторий:
```bash
git clone https://github.com/Null-ch/telegram-content-collector-bot.git
cd telegram-content-collector-bot
```

2. Установите зависимости PHP:
```bash
composer install
```

3. Установите зависимости Node.js:
```bash
npm install
```

4. Скопируйте файл конфигурации:
```bash
cp .env.example .env
```

5. Сгенерируйте ключ приложения:
```bash
php artisan key:generate
```

6. Настройте переменные окружения в файле `.env`:
```
TG_API_ID=ваш_api_id
TG_API_HASH=ваш_api_hash
TG_TARGET_USERNAME=имя_пользователя_для_сбора
```

7. Запустите миграции:
```bash
php artisan migrate
```

## Запуск

Для разработки:
```bash
composer dev
```

Для продакшена:
```bash
php artisan serve
```

## Структура проекта

- `app/` - Основной код приложения
- `config/` - Конфигурационные файлы
- `database/` - Миграции и сиды
- `routes/` - Маршруты приложения
- `resources/` - Ресурсы (views, assets)
- `storage/` - Файлы хранилища
- `tests/` - Тесты

## Технологии

- Laravel 12
- MadelineProto 8.4
- PHP 8.2
- SQLite
- Node.js

## Лицензия

MIT

## Поддержка

Если у вас возникли вопросы или проблемы, создайте issue в репозитории проекта.
