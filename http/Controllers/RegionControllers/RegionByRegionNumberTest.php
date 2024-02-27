<?php

declare(strict_types=1);

namespace Http\Controllers\RegionControllers;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use App\Imports\Values\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Controllers\RegionControllers\RegionByRegionNumber as RegionByRegionNumberController;
use Illuminate\Http\JsonResponse;
use App\Region\Region;
use App\Exports\Region as ExportRegion;
use Database\Main\Factories\RegionFactory;

final class RegionByRegionNumberTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/region_number/';

    #[Test]
    public function itReturnsRegionRecord(): void
    {
        $region = RegionFactory::new()->create();
        
        $response = $this->get($this->endpoint . $region->region_number);
        
        $result = json_decode($response->content(), true);        

        $region = new ExportRegion;
        foreach ($region->getFillable() as $fillable) 
        {
            $this->assertArrayHasKey($fillable, $result);
        }
    }

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $region = RegionFactory::new()->create();

        $response = $this->get($this->endpoint . $region->region_number);

        $region->delete();
        
        $versionedResponse = $this->get($this->endpoint . $region->region_number);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true) ?? []);

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $region = RegionFactory::new()->create();

        $response = $this->get($this->endpoint . $region->region_number);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $versionedResponse = $this->get($this->endpoint . $region->region_number . '?version=' . $version);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true) ?? []);

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }
}