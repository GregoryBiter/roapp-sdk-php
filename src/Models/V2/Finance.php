<?php

namespace Gbit\Roapp\Models\V2;

use Gbit\Roapp\Models\Models;
use Gbit\Roapp\RoappClient;
use Gbit\Roapp\Helpers\ApiRoutes;


class Finance extends Models
{
    
    // Использует константы из ApiRoutes
    /**
     * Конструктор класса Finance
     *
     * @param RoappClient $api Экземпляр клиента Roapp
     */
    public function __construct(RoappClient $api)
    {
        parent::__construct($api);
    }

    public function getCategoriesCashFlow(array $arr = []): array
    {
        return $this->api->request(ApiRoutes::V2_FINANCE . "/cashflow-categories", $arr, 'GET');
    }

    public function getCategoriesCashFlowById(int $id): array {
        return $this->api->request(ApiRoutes::V2_FINANCE . "/cashflow-categories/{$id}", [], 'GET');
    }
    public function getAccounts($data = []): array
    {
        return $this->api->request(ApiRoutes::V2_FINANCE_ACCOUNTS, $data, 'GET');
    }

    public function getAccountById(int $id): array
    {
        return $this->api->request(ApiRoutes::V2_FINANCE_ACCOUNTS . "/{$id}", [], 'GET');
    }

    public function getTransactions(int $account_id, array $data = []): array
    {
        return $this->api->request(ApiRoutes::V2_FINANCE_ACCOUNTS . "/{$account_id}/transactions", $data, 'GET');
    }

    public function deleteTransaction(int $account_id, int $transaction_id): array
    {
        return $this->api->request(ApiRoutes::V2_FINANCE_ACCOUNTS . "/{$account_id}/transactions/{$transaction_id}", [], 'DELETE');
    }

    public function createTransaction(int $account_id, array $data): array
    {
        return $this->api->request(ApiRoutes::V2_FINANCE_ACCOUNTS . "/{$account_id}/transactions", $data, 'POST');
    }

    public function transferTransaction(int $from_account_id, int $to_account_id, string $amount, string $description): array
    {
        return $this->api->request(ApiRoutes::V2_FINANCE_ACCOUNTS . ":transfer", [
            'from_account_id' => $from_account_id,
            'to_account_id' => $to_account_id,
            'amount' => $amount,
            'description' => $description
        ], 'POST');
    }

}
