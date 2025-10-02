# PromUA API Package

[![PHP Version](https://img.shields.io/badge/php-8.2+-blue.svg)](https://php.net/)
[![Laravel Version](https://img.shields.io/badge/laravel-11.0+-red.svg)](https://laravel.com/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![CircleCI](https://dl.circleci.com/status-badge/img/gh/dvomaks/promua-api/tree/main.svg?style=svg)](https://dl.circleci.com/status-badge/redirect/gh/dvomaks/promua-api/tree/main)
[![Packagist Version](https://img.shields.io/packagist/v/dvomaks/promua-api.svg?style=flat&color=orange)](https://packagist.org/packages/dvomaks/promua-api)
[![Total Downloads](https://img.shields.io/packagist/dt/dvomaks/promua-api.svg?style=flat&color=brightgreen)](https://packagist.org/packages/dvomaks/promua-api)
[![Coverage Status](https://img.shields.io/codecov/c/github/dvomaks/promua-api/main.svg)](https://codecov.io/gh/dvomaks/promua-api)
[![Static Analysis](https://img.shields.io/badge/PHPStan-level%205-blueviolet)](https://phpstan.org/)
[![Docs](https://img.shields.io/badge/docs-uk-blue?style=flat&logo=read-the-docs)](https://my.prom.ua/api/v1/docs)
[![PHP Types](https://img.shields.io/badge/types-strict-green?style=flat&logo=php)](https://www.php.net/manual/en/language.types.declarations.php)
[![Last Commit](https://img.shields.io/github/last-commit/dvomaks/promua-api/main.svg?style=flat&color=yellow)](https://github.com/dvomaks/promua-api/commits/main)
[![Tests](https://img.shields.io/badge/tests-passing-brightgreen?style=flat&logo=php)](https://github.com/dvomaks/promua-api/actions?query=workflow%3ATests)
[![Code Style](https://img.shields.io/badge/code%20style-Pint-ff69b4?style=flat&logo=laravel)](https://laravel.com/docs/pint)

Тоді блок бейджів на початку буде виглядати так:

> Потужний Laravel пакет для інтеграції з PromUA API - провідною українською e-commerce платформою

## 📋 Зміст

- [Про проект](#-про-проект)
- [Можливості](#-можливості)
- [Встановлення](#-встановлення)
- [Налаштування](#-налаштування)
- [Використання](#-використання)
- [Приклади коду](#-приклади-коду)
- [Документація API](#-документація-api)
- [Тестування](#-тестування)
- [Внесок у розробку](#-внесок-у-розробку)
- [Ліцензія](#-ліцензія)

## 🚀 Про проект

Цей пакет надає повноцінний PHP SDK для роботи з [PromUA API](https://prom.ua/) - однієї з найбільших e-commerce платформ України. Пакет дозволяє легко інтегрувати ваш Laravel додаток з PromUA для синхронізації замовлень, товарів, клієнтів та інших даних.

### Основні особливості

- ✅ **Повна підтримка PromUA API v1**
- ✅ **Типізовані DTO для всіх відповідей**
- ✅ **Обробка помилок та винятків**
- ✅ **Гнучкі налаштування HTTP клієнта**
- ✅ **Всебічне тестування**
- ✅ **Документація українською мовою**
- ✅ **Сумісність з Laravel 11+**

## 🎯 Можливості

### 📦 Управління замовленнями
- Отримання списку замовлень з фільтрацією
- Отримання детальної інформації про замовлення
- Оновлення статусів замовлень
- Прикріплення квитанцій
- Обробка повернень

### 🛍️ Управління товарами
- Отримання списку товарів
- Отримання товарів за зовнішнім ID
- Створення та редагування товарів
- Імпорт товарів через URL або файл
- Управління перекладами товарів

### 👥 Робота з клієнтами
- Отримання списку клієнтів
- Детальна інформація про клієнтів

### 💬 Система повідомлень
- Отримання списку повідомлень
- Відповіді на повідомлення
- Управління статусами повідомлень

### 🗨️ Чат функціонал
- Отримання кімнат чату
- Історія повідомлень
- Надсилання повідомлень та файлів
- Позначення повідомлень як прочитаних

### 📁 Групи товарів
- Отримання списку груп
- Управління перекладами груп

### 💳 Способи оплати
- Отримання доступних способів оплати

### 🚚 Способи доставки
- Отримання способів доставки
- Збереження декларацій доставки

## 📦 Встановлення

### 1. Вимоги

- PHP 8.2 або вище
- Laravel 11.0 або вище
- Composer

### 2. Встановлення через Composer

```bash
composer require dvomaks/promua-api
```

### 3. Публікація конфігурації

```bash
php artisan vendor:publish --provider="Dvomaks\PromuaApi\PromuaApiServiceProvider"
```

### 4. Публікація міграцій (за потреби)

```bash
php artisan vendor:publish --provider="Dvomaks\PromuaApi\PromuaApiServiceProvider" --tag="migrations"
```

## ⚙️ Налаштування

### 1. Змінні оточення

Додайте наступні змінні до вашого `.env` файлу:

```env
# PromUA API Configuration
PROMUA_API_TOKEN=your_api_token_here
PROMUA_BASE_URL=https://my.prom.ua/api/v1
PROMUA_TIMEOUT=30
PROMUA_LANGUAGE=uk
```

### 2. Конфігурація (config/promua-api.php)

```php
<?php

return [
    'api_token' => env('PROMUA_API_TOKEN', ''),
    'base_url' => env('PROMUA_BASE_URL', 'https://my.prom.ua/api/v1'),
    'timeout' => env('PROMUA_TIMEOUT', 30),
    'language' => env('PROMUA_LANGUAGE', 'uk'),
];
```

### 3. Отримання API токена

1. Увійдіть в **кабінет продавця** Prom.ua.  
2. Перейдіть у меню **Налаштування → Управління API-токенами**.  
3. Натисніть **Створити токен**:
   - Назва (можна залишити пустим).  
   - Термін дії (від 1 дня до 1 року).  
   - Права доступу (Orders, Products тощо).  
4. Після створення натисніть **Переглянути / Скопіювати** та збережіть токен.  

## 💻 Використання

### Базове використання

```php
use Dvomaks\PromuaApi\Facades\PromuaApi;

// Через Facade
$orders = PromuaApi::orders()->getList();

// Або безпосередньо
$promuaApi = new \Dvomaks\PromuaApi($httpClient);
$orders = $promuaApi->orders()->getList();
```

## 📚 Приклади коду

### Робота з замовленнями

```php
use Dvomaks\PromuaApi\Facades\PromuaApi;

// Отримання списку замовлень
$orders = PromuaApi::orders()->getList(
    status: 'pending',
    dateFrom: '2024-01-01',
    limit: 50
);

// Отримання конкретного замовлення
$order = PromuaApi::orders()->getById(12345);

// Оновлення статусу замовлення
$result = PromuaApi::orders()->updateStatus(12345, 'sent');

// Прикріплення квитанції
$result = PromuaApi::orders()->attachReceipt(12345, 'receipt_001');

// Обробка повернення
$result = PromuaApi::orders()->refund(12345, 299.99, 'Товар повернуто покупцем');
```

### Робота з товарами

```php
use Dvomaks\PromuaApi\Facades\PromuaApi;

// Отримання списку товарів
$products = PromuaApi::products()->getList(limit: 100);

// Отримання товару за ID
$product = PromuaApi::products()->getById(67890);

// Створення нового товару
$newProduct = [
    'name' => 'Назва товару',
    'price' => 999.99,
    'description' => 'Опис товару',
    'category_id' => 123,
    'group_id' => 456
];
$result = PromuaApi::products()->create($newProduct);

// Імпорт товарів через URL
$result = PromuaApi::products()->importFromUrl('https://example.com/products.xml');

// Імпорт товарів через файл
$result = PromuaApi::products()->importFromFile('/path/to/products.xml');
```

### Робота з клієнтами

```php
use Dvomaks\PromuaApi\Facades\PromuaApi;

// Отримання списку клієнтів
$clients = PromuaApi::clients()->getList(limit: 200);

// Отримання клієнта за ID
$client = PromuaApi::clients()->getById(11223);
```

### Робота з повідомленнями

```php
use Dvomaks\PromuaApi\Facades\PromuaApi;

// Отримання списку повідомлень
$messages = PromuaApi::messages()->getList();

// Відповідь на повідомлення
$result = PromuaApi::messages()->reply(12345, 'Дякуємо за ваше запитання!');

// Оновлення статусу повідомлення
$result = PromuaApi::messages()->updateStatus(12345, 'answered');
```

### Робота з чатом

```php
use Dvomaks\PromuaApi\Facades\PromuaApi;

// Отримання кімнат чату
$rooms = PromuaApi::chat()->getRooms();

// Отримання історії повідомлень
$messages = PromuaApi::chat()->getMessagesHistory(roomId: 123);

// Надсилання повідомлення
$result = PromuaApi::chat()->sendMessage(123, 'Текст повідомлення');

// Надсилання файлу
$result = PromuaApi::chat()->sendFile(123, '/path/to/file.pdf');

// Позначення повідомлення як прочитаного
$result = PromuaApi::chat()->markAsRead(12345);
```

### Робота з групами

```php
use Dvomaks\PromuaApi\Facades\PromuaApi;

// Отримання списку груп
$groups = PromuaApi::groups()->getList();

// Отримання перекладу групи
$translation = PromuaApi::groups()->getTranslation(123, 'en');

// Оновлення перекладу
$result = PromuaApi::groups()->updateTranslation(123, 'en', [
    'name' => 'Group Name',
    'description' => 'Group Description'
]);
```

## 📖 Документація API

Повна документація PromUA API доступна за адресою: [https://my.prom.ua/api/v1/docs](https://my.prom.ua/api/v1/docs)

### Підтримувані методи

| Сервіс | Методи | Опис |
|--------|--------|------|
| **Orders** | `getList()` | Отримує список замовлень з фільтрацією за статусом, датою та лімітом |
| | `getById(id)` | Отримує детальну інформацію про конкретне замовлення |
| | `updateStatus(id, status)` | Оновлює статус замовлення (new, pending, sent, delivered тощо) |
| | `attachReceipt(id, receiptId)` | Прикріплює квитанцію до замовлення |
| | `refund(id, amount, reason)` | Обробляє повернення товару з вказанням суми та причини |
| **Products** | `getList()` | Отримує список товарів з фільтрацією та пагінацією |
| | `getById(id)` | Отримує детальну інформацію про товар за внутрішнім ID |
| | `getByExternalId(externalId)` | Отримує товар за зовнішнім ідентифікатором |
| | `edit(data)` | Редагує товар за внутрішнім ID |
| | `editByExternalId(data)` | Редагує товар за зовнішнім ідентифікатором |
| | `importFromUrl(url, options)` | Імпортує товари з XML файлу за URL |
| | `getImportStatus(importId)` | Перевіряє статус процесу імпорту товарів |
| | `getTranslation(productId, lang)` | Отримує переклад товару вказаной мовою |
| | `updateTranslation(data)` | Оновлює переклад товару |
| **Chat** | `getRooms(params)` | Отримує список кімнат чату |
| | `getMessages(params)` | Отримує історію повідомлень чату |
| | `sendMessage(data)` | Надсилає текстове повідомлення |
| | `sendFile(filePath, data)` | Надсилає файл у чат |
| | `markMessageRead(data)` | Позначає повідомлення як прочитане |
| **Messages** | `getList(params)` | Отримує список повідомлень з фільтрацією |
| | `getById(id)` | Отримує конкретне повідомлення |
| | `reply(id, message)` | Надсилає відповідь на повідомлення |
| | `setStatus(status, ids)` | Змінює статус повідомлень (read, unread, deleted) |
| **Clients** | `getList(params)` | Отримує список клієнтів з пошуком та фільтрацією |
| | `getById(id)` | Отримує детальну інформацію про клієнта |
| **Groups** | `getList(params)` | Отримує список груп товарів |
| | `getTranslation(id, lang)` | Отримує переклад групи вказаной мовою |
| | `updateTranslation(id, lang, name, desc)` | Оновлює переклад назви та опису групи |
| **Payment** | `getList(params)` | Отримує список доступних способів оплати |
| **Delivery** | `getList(params)` | Отримує список доступних способів доставки |

## 🧪 Тестування

### Запуск тестів

```bash
# Всі тести
composer test

# З покриттям коду
composer test-coverage

# Тести конкретного сервісу
composer test -- --filter=OrdersServiceTest
```

### Написання тестів

```php
use Dvomaks\PromuaApi\Tests\TestCase;

class MyServiceTest extends TestCase
{
    /** @test */
    public function it_can_get_orders()
    {
        $orders = PromuaApi::orders()->getList();

        $this->assertIsArray($orders);
    }
}
```

## 🔧 Розробка

### Структура проекту

```
src/
├── Dto/           # Data Transfer Objects
├── Exceptions/    # Власні винятки
├── Http/          # HTTP клієнт
├── Services/      # Сервіси API
└── Facades/       # Facades для Laravel

tests/             # Тести
config/            # Конфігурація
```

### Код-стиль

Проект використовує [Laravel Pint](https://laravel.com/docs/pint) для форматування коду:

```bash
composer format
```

### Статичний аналіз

PHPStan налаштовано та готовий до використання! 🚀

```bash
# Запуск статичного аналізу
composer analyse

# Альтернативні команди
./vendor/bin/phpstan analyse
./vendor/bin/phpstan analyse --verbose
```

#### Конфігурація PHPStan

Проект використовує оптимальну конфігурацію для Laravel пакету:

- **Рівень аналізу:** 5 (жорсткий, але практичний)
- **Аналіз директорій:** `src/`
- **Виключення:** `vendor/`, `storage/`, `bootstrap/cache/`, `tests/`
- **Bootstrap файл:** `vendor/autoload.php`

#### Якщо потрібно змінити налаштування

Файл конфігурації: `phpstan.neon`

```neon
parameters:
    level: 5                    # Рівень жорсткості (0-9)
    paths:
        - src/                  # Директорії для аналізу
    excludePaths:
        - vendor/
        - storage/
        - bootstrap/cache/
        - tests/
    bootstrapFiles:
        - vendor/autoload.php
```

#### Варіант 2: Без PHPStan

Якщо PHPStan не встановлено, ви можете використовувати інші інструменти статичного аналізу:

```bash
# Встановлення та використання альтернативних інструментів
composer require --dev squizlabs/php_codesniffer
php vendor/bin/phpcs src/ --standard=PSR12

# Або перевірити синтаксис PHP
php -l src/
php -l tests/
```

## 🤝 Внесок у розробку

Ми вітаємо внески у розробку! Будь ласка, ознайомтеся з нашими правилами:

1. Fork проект
2. Створіть feature branch (`git checkout -b feature/amazing-feature`)
3. Commit зміни (`git commit -m 'Add amazing feature'`)
4. Push branch (`git push origin feature/amazing-feature`)
5. Створіть Pull Request

### Правила внеску

- Пишіть тести для нового функціоналу
- Дотримуйтесь PSR-12 код-стилю
- Оновлюйте документацію при потребі
- Забезпечте зворотну сумісність

## 📄 Ліцензія

Цей проект ліцензовано під [MIT License](https://opensource.org/licenses/MIT).

## 🆘 Підтримка

Якщо у вас виникли питання або проблеми:

- 📧 Email: dvomaks@gmail.com
- 🐛 [Повідомити про проблему](https://github.com/dvomaks/promua-api/issues)
- 📖 [Документація](https://my.prom.ua/api/v1/docs)

## 🙏 Подяки

- Команді PromUA за чудовий API
- Laravel community за натхнення
- Всіх контриб'юторів проекту

---

**Зроблено з ❤️ в Україні**
