<?php

declare(strict_types=1);

namespace Http\Controllers\SportControllers;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Controllers\SportControllers\SportByName as SportByNameController;
use Illuminate\Http\JsonResponse;
use App\Sport\Sport;
use Database\Main\Factories\SportFactory;

final class SportByNameTest extends TestCase
{
    private string $endpoint = '/api/v1/sports/name/';

    #[Test]
    public function itReturnsSportRecord(): void
    {
        $sport = SportFactory::new()->create();
        
        $response = $this->get($this->endpoint . $sport->name);
        
        $result = json_decode($response->content(), true);

        foreach ($sport->getFillable() as $fillable) 
        {
            $this->assertArrayHasKey($fillable, $result);
        }
    }

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $sport = SportFactory::new()->create();

        $response = $this->get($this->endpoint . $sport->name);

        $sport->delete();
        
        $versionedResponse = $this->get($this->endpoint . $sport->name);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $sport = SportFactory::new()->create();

        $response = $this->get($this->endpoint . $sport->name);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $versionedResponse = $this->get($this->endpoint . $sport->name . '?version=' . $version);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }
}