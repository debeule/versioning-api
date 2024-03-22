<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use App\Testing\TestCase;
use Database\Main\Factories\MunicipalityFactory;
use Database\Main\Factories\RegionFactory;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;

final class RegionByPostalCodeHandlerTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/postal_code/';

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $region = RegionFactory::new()->create();
        $municipality = MunicipalityFactory::new()->withRegionId($region->id)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ])->get($this->endpoint . $municipality->postal_code);

        $municipality->delete();
        
        $versionedResponse = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ])->get($this->endpoint . $municipality->postal_code);

        $resultCount = count(json_decode($response->content(), true));
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $region = RegionFactory::new()->create();
        $municipality = MunicipalityFactory::new()->withRegionId($region->id)->create();

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->getApiToken(),
        ])->get($this->endpoint . $municipality->postal_code);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $versionedResponse = $this->get($this->endpoint . $municipality->postal_code . '?version=' . $version);

        $resultCount = count(json_decode($response->content(), true));
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
    }
}