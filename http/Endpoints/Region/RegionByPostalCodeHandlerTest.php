<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use App\Imports\Values\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Endpoints\Region\RegionByRegionNumber as RegionByRegionNumberController;
use Illuminate\Http\JsonResponse;
use App\Location\Region;
use App\Exports\Region as ExportRegion;
use Database\Main\Factories\RegionFactory;
use Database\Main\Factories\MunicipalityFactory;

final class RegionByPostalCodeHandlerTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/postal_code/';

    #[Test]
    public function itReturnsRegionRecord(): void
    {
        $region = RegionFactory::new()->create();
        $municipality = MunicipalityFactory::new()->withRegionId($region->id)->create();
        
        $response = $this->get($this->endpoint . $municipality->postal_code);
        
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
        $municipality = MunicipalityFactory::new()->withRegionId($region->id)->create();

        $response = $this->get($this->endpoint . $municipality->postal_code);

        $municipality->delete();
        
        $versionedResponse = $this->get($this->endpoint . $municipality->postal_code);

        $resultCount = count(json_decode($response->content(), true));
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
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
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
    }
}