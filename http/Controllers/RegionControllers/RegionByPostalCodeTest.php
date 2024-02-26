<?php

declare(strict_types=1);

namespace Http\Controllers\RegionControllers;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Controllers\RegionControllers\RegionByRegionNumber as RegionByRegionNumberController;
use Illuminate\Http\JsonResponse;
use App\Region\Region;
use Database\Main\Factories\RegionFactory;
use Database\Main\Factories\MunicipalityFactory;

final class RegionByPostalCodeTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/postal_code/';

    #[Test]
    public function itReturnsRegionRecord(): void
    {
        $region = RegionFactory::new()->create();
        $municipality = MunicipalityFactory::new()->withRegionId($region->id)->create();
        
        $response = $this->get($this->endpoint . $municipality->postal_code);
        
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
        $municipality = MunicipalityFactory::new()->withRegionId($region->id)->create();

        $response = $this->get($this->endpoint . $municipality->postal_code);

        $region->delete();
        
        $versionedResponse = $this->get($this->endpoint . $municipality->postal_code);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $region = RegionFactory::new()->create();
        $municipality = MunicipalityFactory::new()->withRegionId($region->id)->create();

        $response = $this->get($this->endpoint . $municipality->postal_code);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $versionedResponse = $this->get($this->endpoint . $municipality->postal_code . '?version=' . $version);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }
}