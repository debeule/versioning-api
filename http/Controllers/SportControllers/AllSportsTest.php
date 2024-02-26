<?php

declare(strict_types=1);

namespace Http\Controllers\SportControllers;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Controllers\SportControllers\AllSports as AllSportsController;
use Illuminate\Http\JsonResponse;
use App\Sport\Sport;
use Database\Main\Factories\SportFactory;

final class AllSportsTest extends TestCase
{
    private string $endpoint = '/api/v1/sports/all/';

    #[Test]
    public function itReturnsValidSportRecord(): void
    {
        $sports = SportFactory::new()->create();

        $response = $this->get($this->endpoint);

        $result = json_decode($response->content(), true)[0];

        foreach ($sports->first()->getFillable() as $fillable) 
        {
            $this->assertArrayHasKey($fillable, $result);
        }
    }

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $sports = SportFactory::new()->count(3)->create();

        $response = $this->get($this->endpoint);

        $sports->first()->delete();
        
        $versionedResponse = $this->get($this->endpoint);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $sports = SportFactory::new()->count(3)->create();

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