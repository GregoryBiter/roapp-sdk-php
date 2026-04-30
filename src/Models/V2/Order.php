<?php

namespace Gbit\Roapp\Models\V2;

use Gbit\Roapp\Models\Models;
use Gbit\Roapp\RoappClient;
use Gbit\Roapp\Helpers\ApiRoutes;


class Order extends Models

{
    // Использует константы из ApiRoutes
    public function __construct(RoappClient $api)
    {
        parent::__construct($api);
    }

    /**
     * Получить список всех заказов.
     *
     * @param array $arr Дополнительные параметры фильтрации (см. документацию API)
     * @return array Массив заказов
     */
    public function get(array $arr = []): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS, $arr, 'GET');
    }

    /**
     * Получить заказ по ID
     *
     * @param int $order_id Идентификатор заказа
     * @return array Массив с данными заказа
     */
    public function getById(int $order_id): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . "/" . $order_id, [], 'GET');
    }

    /**
     * Создать новый заказ.
     *
     * @param array $data Данные для создания заказа.
     * @return array Массив с данными созданного заказа
     */
    public function create(array $data = []): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS, $data, 'POST');
    }

    /**
     * Обновить заказ по ID
     *
     * @param int $order_id Идентификатор заказа
     * @param array $data Данные для обновления заказа.
     * @return array Массив с обновлёнными данными заказа
     */
    public function update(int $order_id, array $data): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . "/" . $order_id, $data, 'PATCH');
    }

    /**
     * Получить список позиций в заказе
     *
     * @param int $order_id Идентификатор заказа
     * @return array Массив позиций заказа
     */
    public function getItems(int $order_id): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . "/" . $order_id . "/items", [], 'GET');
    }

    /**
     * Добавить позицию в заказ
     *
     * @param int $order_id Идентификатор заказа
     * @param array $data Данные позиции.
     * @return array Массив с результатом добавления
     */
    public function addItem(int $order_id, array $data): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . "/" . $order_id . "/items", $data, 'POST');
    }

    /**
     * Обновить позицию заказа
     *
     * @param int $order_id Идентификатор заказа
     * @param int $item_id Идентификатор позиции
     * @param array $data Данные для обновления позиции.
     * @return array Массив с результатом обновления
     */
    public function updateItem(int $order_id, int $item_id, array $data): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . "/" . $order_id . "/items/" . $item_id, $data, 'PATCH');
    }

    /**
     * Установить статус заказа
     *
     * @param int $order_id Идентификатор заказа
     * @param int $status_id Идентификатор статуса
     * @param string $comment Комментарий к смене статуса
     * @return array Массив с результатом смены статуса
     */
    public function setStatus(int $order_id, int $status_id, string $comment): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . "/" . $order_id . "/status", ['status_id' => $status_id, 'comment' => $comment], 'POST');
    }

    /**
     * Добавить комментарий к заказу
     *
     * @param int $order_id Идентификатор заказа
     * @param string $comment Текст комментария
     * @param bool $is_private Приватность комментария
     * @return array Массив с результатом добавления комментария
     */
    public function addComment(int $order_id, string $comment, bool $is_private): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . "/" . $order_id . "/comments", ['comment' => $comment, 'is_private' => $is_private], 'POST');
    }

    /**
     * Получить публичную ссылку на заказ
     *
     * @param int $order_id Идентификатор заказа
     * @return array Массив с публичной ссылкой
     */
    public function getPublicUrl(int $order_id): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . "/" . $order_id . "/public-url", [], 'GET');
    }

    /**
     * Получить список всех возможных статусов, которые можно присвоить заказу.
     *
     * @return array Массив статусов заказа
     */
    public function getStatuses(): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . '/statuses', [], 'GET');
    }

    public function getTypes(): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . '/types', [], 'GET');
    }

    public function getCustomFields(): array
    {
        return $this->api->request(ApiRoutes::V2_ORDERS . '/custom-fields', [], 'GET');
    }

}
