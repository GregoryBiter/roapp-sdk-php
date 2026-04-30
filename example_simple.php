<?php

require_once 'vendor/autoload.php';

use Gbit\Roapp\RoappClient;
use Gbit\Roapp\RoappApiException;

// 1. Инициализация клиента
$apiKey = 'your-api-key-here';
$client = new RoappClient($apiKey);

try {
    // 2. Получение данных (например, список заказов)
    // Используем эндпоинт v2/orders
    echo "Запрос списка заказов...\n";
    $response = $client->getData('v2/orders', ['page' => 1]);
    
    echo "Найдено записей: " . $response['count'] . "\n";
    
    if (!empty($response['data'])) {
        foreach ($response['data'] as $order) {
            echo "Заказ #{$order['id']}: {$order['description']}\n";
        }
    } else {
        echo "Заказы не найдены.\n";
    }

    // 3. Создание записи (пример)
    /*
    $newOrder = $client->request('v2/orders', [
        'branch_id' => 1,
        'order_type_id' => 1,
        'description' => 'Тестовый заказ из SDK'
    ], 'POST');
    echo "Создан новый заказ с ID: " . $newOrder['id'] . "\n";
    */

} catch (RoappApiException $e) {
    echo "Ошибка API: " . $e->getMessage() . "\n";
    echo "Код ошибки: " . $e->getHttpCode() . "\n";
    
    if ($e->isValidationError()) {
        echo "Ошибки валидации:\n";
        print_r($e->getValidationErrors());
    }
} catch (Exception $e) {
    echo "Общая ошибка: " . $e->getMessage() . "\n";
}
