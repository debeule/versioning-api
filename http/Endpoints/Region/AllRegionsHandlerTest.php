<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use App\Testing\TestCase;
use Database\Main\Factories\RegionFactory;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;

final class AllRegionsHandlerTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/all';

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $regions = RegionFactory::new()->count(3)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ])->get($this->endpoint);

        $regions->first()->delete();
        
        $versionedResponse = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ])->get($this->endpoint);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $regions = RegionFactory::new()->count(3)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ])->get($this->endpoint);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $versionedResponse = $this->get($this->endpoint . '?version=' . $version);

        $resultCount = count(json_decode($response->content(), true));

        $versionedResult = json_decode($versionedResponse->content(), true);
        
        if(is_string($versionedResult)) $versionedResult = [];
        $versionedResultCount = count($versionedResult);

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }
}