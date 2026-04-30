# Roapp-PHP-SDK 🚀

PHP SDK для работы с **Roapp CRM API** — современной системой управления сервисными центрами и ремонтами.

[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892bf.svg)](https://php.net)

## 📦 Установка

```bash
composer require gregorybiter/roapp-sdk
```

**Требования:**
- PHP >= 7.4
- Расширение cURL
- Расширение JSON

---

## ⚠️ ВАЖНО: Модули (Models)

> [!WARNING]
> На данный момент **не рекомендуется** использовать высокоуровневые модули из пространства имен `Gbit\Roapp\Models` (такие как `Order`, `People`, `Product` и т.д.). Они находятся в стадии активной переработки под новую структуру API (V2).
> 
> **Рекомендуемый способ взаимодействия** — использование универсальных методов класса `RoappClient`.

---

## 🔑 Аутентификация

SDK использует **Bearer Token**. Получите ваш API ключ в личном кабинете Roapp: **Настройки > API**.

```php
use Gbit\Roapp\RoappClient;

$client = new RoappClient("ваш_api_ключ");
```

---

## ⚡ Быстрый старт (Рекомендуемый подход)

Используйте методы `getData`, `request` и `requestWithRetry` для прямого взаимодействия с эндпоинтами.

### 📥 Получение данных (с авто-пагинацией)

Метод `getData` позволяет автоматически собрать данные со всех страниц, если это необходимо.

```php
// Получить все заказы (автоматически перебирает все страницы)
$allOrders = $client->getData('v2/orders', [], true);

// Получить только первую страницу (50 записей)
$ordersPage1 = $client->getData('v2/orders', ['page' => 1], false);

echo "Всего заказов в базе: " . $allOrders['count'];
```

### 📤 Создание и обновление данных

```php
// Создание заказа
$newOrder = $client->request('v2/orders', [
    'branch_id' => 1,
    'order_type_id' => 1,
    'client_id' => 12345,
    'description' => 'Ремонт iPhone 13'
], 'POST');

// Частичное обновление (PATCH)
$client->request('v2/orders/123', ['status_id' => 5], 'PATCH');
```

---

## 🔄 Продвинутые запросы

### 🔁 Автоматические повторы (Retry)
Если API возвращает ошибку `429 (Too Many Requests)`, метод `requestWithRetry` автоматически подождет и повторит запрос.

```php
$response = $client->requestWithRetry(
    'v2/orders',    // эндпоинт
    ['page' => 1],  // параметры
    'GET',          // метод
    3,              // макс. количество попыток
    1               // базовая задержка (сек)
);
```

---

## 🛠️ Низкоуровневый доступ (Класс Api)

Если вам нужен полный контроль над cURL или вы хотите использовать SDK без обертки `RoappClient`:

```php
use Gbit\Roapp\Api;

$api = new Api('ваш_api_ключ');
$response = $api->api('v2/orders', ['status' => 'new'], 'GET');
```

---

## 🔥 Обработка ошибок

SDK предоставляет информативное исключение `RoappApiException`, которое содержит детали ответа сервера.

```php
use Gbit\Roapp\RoappApiException;

try {
    $result = $client->request('v2/orders/invalid-id', [], 'GET');
} catch (RoappApiException $e) {
    // Получить HTTP код (400, 401, 404, 429 и т.д.)
    $code = $e->getHttpCode();
    
    // Сообщение на русском языке (если доступно)
    echo $e->getUserFriendlyMessage();
    
    // Проверка специфических ошибок
    if ($e->isValidationError()) {
        print_r($e->getValidationErrors());
    }
    
    if ($e->isRateLimitError()) {
        echo "Превышен лимит запросов (3 зап/сек)";
    }
}
```

---

## 📝 Логирование

По умолчанию ошибки логируются в файл `logs/error.log`. Вы можете добавлять свои записи:

```php
use Gbit\Roapp\RoappClient;

RoappClient::pushLogs("Информационное сообщение");
RoappClient::pushLogs("Критическая ошибка", true); // true = ERROR, false = WARNING
```

---

## 📖 Справочник эндпоинтов (V2)

Основные маршруты API V2 (рекомендуются к использованию):

| Сущность | Эндпоинт |
| :--- | :--- |
| **Заказы** | `v2/orders` |
| **Финансы** | `v2/finance` |
| **Счета** | `v2/finance/accounts` |
| **Клиенты** | `v2/people` |
| **Товары** | `v2/products` |

Полный список доступен в [Официальной документации Roapp API](https://api.remonline.app/docs).

---

## 🤝 Поддержка и разработка

- **Issues**: [GitHub Issues](https://github.com/GregoryBiter/Roapp-PHP-SDK/issues)
- **Maintainer**: GregoryBiter (gregorybiter@gmail.com)

---

## 📄 Лицензия

Проект распространяется под лицензией [MIT](LICENSE).
