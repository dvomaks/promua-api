# Журнал змін

## [1.1.3] - 2025-10-02
### Зміни
- Видалено папки views та migrations

## [1.1.2] - 2025-10-02
### Зміни
- Оновлено composer.json та CHANGELOG.md
- Перейменовано метод getOrderList на getList у OrdersService

## [1.1.1] - 2025-10-02
### Додано
- Функціонал логування до API клієнта
- Інтеграційні тести та налаштування для PromUA API
- Покращена документація та підтримка curl extension
- Переміщено unit tests до папки Unit

## [1.1.0] - 2025-10-02
### Додано
- Конфігурація логування для API запитів та відповідей

## [1.0.0] - 2025-10-01
### Додано
- Базова структура API з DTO класами
- Сервіси: ProductsService, ClientsService, MessagesService, GroupsService, DeliveryService, PaymentService
- Відповідні тести для всіх сервісів
- PromuaApiClient для взаємодії з API