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
use Database\Main\Factories\MunicipalityFactory;

final class LinkedMunicipalitiesTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/linked_municipalities/';

    #[Test]
    public function itReturnsMunicipalityRecords(): void
    {
        $region = RegionFactory::new()->create();
        $municipalities = MunicipalityFactory::new()->withRegionId($region->id)->count(3)->create();
        
        $response = $this->get($this->endpoint . $region->region_number);
        
        $result = json_decode($response->content(), true)[0];
        
        foreach ($municipalities->first()->getFillable() as $fillable) 
        {
            $this->assertArrayHasKey($fillable, $result);
        }
    }

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $region = RegionFactory::new()->create();
        $municipalities = MunicipalityFactory::new()->withRegionId($region->id)->count(3)->create();

        $response = $this->get($this->endpoint . $region->region_number);

        $municipalities->first()->delete();
        
        $versionedResponse = $this->get($this->endpoint . $region->region_number);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $region = RegionFactory::new()->create();
        $municipalities = MunicipalityFactory::new()->withRegionId($region->id)->count(3)->create();

        $response = $this->get($this->endpoint . $region->region_number);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $versionedResponse = $this->get($this->endpoint . $region->region_number . '?version=' . $version);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }
}