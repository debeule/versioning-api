<?php

declare(strict_types=1);

namespace Http\Controllers\RegionControllers;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Controllers\RegionControllers\RegionByName as RegionByNameController;
use Illuminate\Http\JsonResponse;
use App\Region\Region;
use Database\Main\Factories\RegionFactory;

final class RegionByNameTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/name/';

    #[Test]
    public function itReturnsRegionRecord(): void
    {
        $region = RegionFactory::new()->create();
        
        $response = $this->get($this->endpoint . $region->name);
        
        $result = json_decode($response->content(), true);

        foreach ($region->getFillable() as $fillable) 
        {
            $this->assertArrayHasKey($fillable, $result);
        }
    }

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $region = RegionFactory::new()->create();

        $response = $this->get($this->endpoint . $region->name);

        $region->delete();
        
        $versionedResponse = $this->get($this->endpoint . $region->name);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $region = RegionFactory::new()->create();

        $response = $this->get($this->endpoint . $region->name);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $versionedResponse = $this->get($this->endpoint . $region->name . '?version=' . $version);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }
}