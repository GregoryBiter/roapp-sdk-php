<?php

namespace Gbit\Roapp\Models\Old;

use Gbit\Roapp\Models\Models;
use Gbit\Roapp\RoappClient;

class Booking extends Models
{
    private $endpoint = 'bookings';

    public function __construct(RoappClient $api)
    {
        parent::__construct($api);
    }

    public function get(array $arr = []): array
    {
        return $this->api->request($this->endpoint, $arr, 'GET');
    }

    public function getByID(int $booking_id): array
    {
        return $this->api->request($this->endpoint . '/' . $booking_id, [], 'GET');
    }

    public function create(array $data = []): array
    {
        return $this->api->request($this->endpoint, $data, 'POST');
    }

    public function update(int $booking_id, array $data): array
    {
        return $this->api->request($this->endpoint . '/' . $booking_id, $data, 'PATCH');
    }

    public function delete(int $booking_id): array
    {
        return $this->api->request($this->endpoint . '/' . $booking_id, [], 'DELETE');
    }

    public function getService(int $booking_id): array
    {
        return $this->api->request($this->endpoint . '/' . $booking_id . '/items', [], 'GET');
    }

    public function addService(int $booking_id, array $data): array
    {
        return $this->api->request($this->endpoint . '/' . $booking_id . '/items', $data, 'POST');
    }

    public function updateService(int $booking_id, int $service_id, array $data): array
    {
        return $this->api->request($this->endpoint . '/' . $booking_id . '/items/' . $service_id, $data, 'PATCH');
    }

    public function deleteService(int $booking_id, int $service_id): array
    {
        return $this->api->request($this->endpoint . '/' . $booking_id . '/items/' . $service_id, [], 'DELETE');
    }
}
