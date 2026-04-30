<?php

use Gbit\Roapp\Api;
use Gbit\Roapp\Models\Estimate;
use Gbit\Roapp\Models\Order;
use Gbit\Roapp\Models\People;
use Gbit\Roapp\Models\Product;
use Gbit\Roapp\RoappClient;
use PHPUnit\Framework\TestCase;

class StructureTest extends TestCase
{
    public function testApiBuildsQueryStringWithoutNullsAndEmptyArrays(): void
    {
        $api = new class('test-key') extends Api {
            public function exposeBuildQueryString(array $params): string
            {
                return $this->buildQueryString($params);
            }
        };

        $query = $api->exposeBuildQueryString([
            'page' => 2,
            'branch_id' => null,
            'ids' => [5, null, 8],
            'categories' => [],
            'include_archived' => false,
            'search' => '',
        ]);

        $this->assertSame('page=2&ids=5&ids=8&include_archived=0', $query);
    }

    public function testApiTreatsEmptySuccessfulResponsesAsValid(): void
    {
        $api = new class('test-key') extends Api {
            public function exposeIsEmptySuccessfulResponse(string $response, int $httpCode): bool
            {
                return $this->isEmptySuccessfulResponse($response, $httpCode);
            }
        };

        $this->assertTrue($api->exposeIsEmptySuccessfulResponse('', 204));
        $this->assertTrue($api->exposeIsEmptySuccessfulResponse('', 200));
        $this->assertTrue($api->exposeIsEmptySuccessfulResponse('   ', 200));
        $this->assertFalse($api->exposeIsEmptySuccessfulResponse('{}', 200));
        $this->assertFalse($api->exposeIsEmptySuccessfulResponse('', 404));
    }

    public function testOrderRoutesUseV2EndpointsAndPatchedMethods(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $order = new Order($apiMock);

        $apiMock->expects($this->exactly(3))
            ->method('request')
            ->withConsecutive(
                ['v2/orders/statuses', [], 'GET'],
                ['v2/orders/10/items/3', ['qty' => 2], 'PATCH'],
                ['v2/orders', ['page' => 1], 'GET']
            )
            ->willReturnOnConsecutiveCalls(['statuses' => []], ['updated' => true], ['data' => []]);

        $this->assertSame(['statuses' => []], $order->getStatuses());
        $this->assertSame(['updated' => true], $order->updateItem(10, 3, ['qty' => 2]));
        $this->assertSame(['data' => []], $order->get(['page' => 1]));
    }

    public function testEstimateRoutesUseV2EndpointsAndPatchedMethods(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $estimate = new Estimate($apiMock);

        $apiMock->expects($this->exactly(2))
            ->method('request')
            ->withConsecutive(
                ['v2/estimates/statuses', [], 'GET'],
                ['v2/estimates/20/items/7', ['price' => 100], 'PATCH']
            )
            ->willReturnOnConsecutiveCalls(['statuses' => []], ['updated' => true]);

        $this->assertSame(['statuses' => []], $estimate->getStatuses());
        $this->assertSame(['updated' => true], $estimate->updateItem(20, 7, ['price' => 100]));
    }

    public function testPeopleRoutesUsePatchedOrganizationAndCommentPayload(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $people = new People($apiMock);

        $apiMock->expects($this->exactly(2))
            ->method('request')
            ->withConsecutive(
                ['v2/contacts/people/15/organizations', [], 'GET'],
                ['v2/contacts/people/15/comments', ['comment' => 'VIP', 'is_private' => true], 'POST']
            )
            ->willReturnOnConsecutiveCalls(['organizations' => []], ['commented' => true]);

        $this->assertSame(['organizations' => []], $people->getOrganization(15));
        $this->assertSame(['commented' => true], $people->addComment(15, 'VIP', true));
    }

    public function testProductRoutesStayOnDocumentedNonV2Endpoints(): void
    {
        $apiMock = $this->createMock(RoappClient::class);
        $product = new Product($apiMock);

        $apiMock->expects($this->exactly(2))
            ->method('request')
            ->withConsecutive(
                ['products', ['page' => 1], 'GET'],
                ['warehouse/categories', [], 'GET']
            )
            ->willReturnOnConsecutiveCalls(['data' => []], ['categories' => []]);

        $this->assertSame(['data' => []], $product->get(['page' => 1]));
        $this->assertSame(['categories' => []], $product->getCategories());
    }
}
