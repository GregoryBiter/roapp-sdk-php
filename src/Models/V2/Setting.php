<?php

namespace Gbit\Roapp\Models;

use Gbit\Roapp\Models\Models;
use Gbit\Roapp\RoappClient;

class Setting extends Models
{
    public function __construct(RoappClient $api)
    {
        parent::__construct($api);
    }

    public function getCompanySetting(): array
    {
        return $this->api->request('company', [], 'GET');
    }

    public function getLicense(): array
    {
        return $this->api->request('company/license', [], 'GET');
    }

    public function getLocations(): array
    {
        return $this->api->request('company/locations', [], 'GET');
    }

    public function getLocation(int $location_id): array
    {
        return $this->api->request('company/locations/' . $location_id, [], 'GET');
    }

    public function getResources(int $location_id, array $data = []): array
    {
        return $this->api->request('company/locations/' . $location_id . '/resources', $data, 'GET');
    }

    public function getEmployees(array $data = []): array
    {
        return $this->api->request('company/employees', $data, 'GET');
    }

    public function getEmployee(int $employee_id): array
    {
        return $this->api->request('company/employees/' . $employee_id, [], 'GET');
    }

    public function getLegalEntities(): array
    {
        return $this->api->request('company/legal-entities', [], 'GET');
    }

    public function getLegalEntity(int $legal_entity_id): array
    {
        return $this->api->request('company/legal-entities/' . $legal_entity_id, [], 'GET');
    }

    public function getTaxes(): array
    {
        return $this->api->request('company/taxes', [], 'GET');
    }

    public function getDirectories(): array
    {
        return $this->api->request('company/directories', [], 'GET');
    }

    public function getDirectory(int $directory_id, array $data = []): array
    {
        return $this->api->request('company/directories/' . $directory_id . '/', $data, 'GET');
    }

    // OLD ENDPOINTS

    public function getAdCampaigns(): array
    {
        return $this->api->request('marketing/campaigns', [], 'GET');
    }

    public function getPrices(): array
    {
        return $this->api->request('margins', [], 'GET');
    }

    public function getOrderTypes(): array
    {
        return $this->api->request('orders/types', [], 'GET');
    }

    public function getOrderCustomFields(): array
    {
        return $this->api->request('orders/custom-fields', [], 'GET');
    }

    public function getBookList(): array
    {
        return $this->api->request('book/list', [], 'GET');
    }
}
