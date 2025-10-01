# Changelog

All notable changes to `promua-api` will be documented in this file.

## [1.0.0] - 2025-10-01

### 🚀 Додано

- **Повна підтримка PromUA API v1** - повноцінний PHP SDK для роботи з PromUA API
- **Вісім основних сервісів:**
  - `ChatService` - робота з чатом та повідомленнями
  - `ClientsService` - управління клієнтами
  - `DeliveryService` - способи доставки
  - `GroupsService` - управління групами товарів
  - `MessagesService` - система повідомлень
  - `OrdersService` - управління замовленнями
  - `PaymentService` - способи оплати
  - `ProductsService` - управління товарами
- **Типізовані DTO класи** для всіх API відповідей
- **PromuaApiClient** - HTTP клієнт для API взаємодій
- **PromuaApiException** - власний клас для обробки помилок
- **Facade** для легкого використання в Laravel додатках

### 🛠️ Покращення

- **Всебічне тестування** - тести для всіх сервісів та функціоналу
- **PHPStan** - статичний аналіз коду для забезпечення якості
- **Laravel Pint** - автоматичне форматування коду
- **Детальна документація** - повний README з прикладами використання
- **Конфігурація Laravel** - publishing конфігураційних файлів

### 📦 Структура проекту

```
src/
├── Dto/           # Data Transfer Objects
├── Exceptions/    # Власні винятки
├── Http/          # HTTP клієнт
├── Services/      # Сервіси API
└── Facades/       # Facades для Laravel
```

### 🔧 Вимоги

- PHP 8.2+
- Laravel 11.0+
- Composer для встановлення залежностей

### 📖 Документація

Детальна документація доступна в [README.md](README.md) файлі з прикладами використання всіх сервісів та методів API.
