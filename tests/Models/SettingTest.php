<?php

use Gbit\Roapp\Models\Setting;
use Gbit\Roapp\RoappClient;
use PHPUnit\Framework\TestCase;

class SettingTest extends TestCase
{
    public function testGetCompanySettingUsesDocumentedEndpoint(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $apiMock->expects($this->once())
            ->method('request')
            ->with('settings/company', [], 'GET')
            ->willReturn(['company' => 'Test']);

        $setting = new Setting($apiMock);

        $this->assertSame(['company' => 'Test'], $setting->getCompanySetting());
    }

    public function testGetLocationsUsesDocumentedEndpoint(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $apiMock->expects($this->once())
            ->method('request')
            ->with('branches', [], 'GET')
            ->willReturn(['locations' => []]);

        $setting = new Setting($apiMock);

        $this->assertSame(['locations' => []], $setting->getLocations());
    }

    public function testGetAdCampaignsUsesDocumentedEndpoint(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $apiMock->expects($this->once())
            ->method('request')
            ->with('marketing/campaigns', [], 'GET')
            ->willReturn(['campaigns' => []]);

        $setting = new Setting($apiMock);

        $this->assertSame(['campaigns' => []], $setting->getAdCampaigns());
    }

    public function testGetPricesUsesDocumentedEndpoint(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $apiMock->expects($this->once())
            ->method('request')
            ->with('margins', [], 'GET')
            ->willReturn(['prices' => []]);

        $setting = new Setting($apiMock);

        $this->assertSame(['prices' => []], $setting->getPrices());
    }

    public function testGetEmployeesUsesDocumentedEndpoint(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $apiMock->expects($this->once())
            ->method('request')
            ->with('employees', [], 'GET')
            ->willReturn(['employees' => []]);

        $setting = new Setting($apiMock);

        $this->assertSame(['employees' => []], $setting->getEmployees());
    }

    public function testGetOrderTypesUsesDocumentedEndpoint(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $apiMock->expects($this->once())
            ->method('request')
            ->with('orders/types', [], 'GET')
            ->willReturn(['types' => []]);

        $setting = new Setting($apiMock);

        $this->assertSame(['types' => []], $setting->getOrderTypes());
    }

    public function testGetOrderCustomFieldsUsesDocumentedEndpoint(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $apiMock->expects($this->once())
            ->method('request')
            ->with('orders/custom-fields', [], 'GET')
            ->willReturn(['fields' => []]);

        $setting = new Setting($apiMock);

        $this->assertSame(['fields' => []], $setting->getOrderCustomFields());
    }

    public function testGetBookListUsesDocumentedEndpoint(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $apiMock->expects($this->once())
            ->method('request')
            ->with('book/list', [], 'GET')
            ->willReturn(['books' => []]);

        $setting = new Setting($apiMock);

        $this->assertSame(['books' => []], $setting->getBookList());
    }
}
