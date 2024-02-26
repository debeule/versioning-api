<?php

declare(strict_types=1);

namespace Http\Controllers\RegionControllers;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Controllers\RegionControllers\AllRegions as AllRegionsController;
use Illuminate\Http\JsonResponse;
use App\Region\Region;
use Database\Main\Factories\RegionFactory;

final class AllRegionsTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/all/';

    #[Test]
    public function itReturnsValidRegionRecord(): void
    {
        $regions = RegionFactory::new()->create();

        $response = $this->get($this->endpoint);

        $result = json_decode($response->content(), true)[0];

        foreach ($regions->first()->getFillable() as $fillable) 
        {
            $this->assertArrayHasKey($fillable, $result);
        }
    }

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $regions = RegionFactory::new()->count(3)->create();

        $response = $this->get($this->endpoint);

        $regions->first()->delete();
        
        $versionedResponse = $this->get($this->endpoint);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $regions = RegionFactory::new()->count(3)->create();

        $response = $this->get($this->endpoint);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $versionedResponse = $this->get($this->endpoint . '?version=' . $version);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }
}