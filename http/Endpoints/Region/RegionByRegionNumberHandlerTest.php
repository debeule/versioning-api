<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use App\Location\Presentation\Region as ExportRegion;
use App\Testing\TestCase;
use Database\Main\Factories\RegionFactory;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;

final class RegionByRegionNumberHandlerTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/region_number/';

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $region = RegionFactory::new()->create();

        $response = $this->get($this->endpoint . $region->region_number);

        $region->delete();
        
        $versionedResponse = $this->get($this->endpoint . $region->region_number);

        $resultCount = count(json_decode($response->content(), true));
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
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
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
    }
}