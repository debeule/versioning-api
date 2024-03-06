<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use App\Exports\Region as ExportRegion;
use App\Testing\TestCase;
use Database\Main\Factories\RegionFactory;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;

final class RegionByNameHandlerTest extends TestCase
{
    private string $endpoint = '/api/v1/regions/name/';

    #[Test]
    public function itReturnsRegionRecord(): void
    {
        $region = RegionFactory::new()->create();
        
        $response = $this->get($this->endpoint . $region->name);
        
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

        $response = $this->get($this->endpoint . $region->name);
        $region->delete();
        
        $versionedResponse = $this->get($this->endpoint . $region->name);

        $resultCount = count(json_decode($response->content(), true));
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
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
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
    }
}