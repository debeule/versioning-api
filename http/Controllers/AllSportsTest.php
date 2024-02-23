<?php

declare(strict_types=1);

namespace Http\Controllers;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Controllers\AllSports as AllSportsController;
use Illuminate\Http\JsonResponse;
use App\Sport\Sport;
use Database\Main\Factories\SportFactory;

final class AllSportsTest extends TestCase
{
    #[Test]
    public function itReturnsSportRecords(): void
    {
        $AllSportsController = new AllSportsController();

        SportFactory::new()->count(3)->create();

        $result = $AllSportsController(new Request);

        $resultInstance = json_decode($result->content(), true)[0];
        
        $sport = new Sport;

        foreach ($sport->getFillable() as $fillable) 
        {
            $this->assertArrayHasKey($fillable, $resultInstance);
        }
    }

    #[Test]
    public function itDoesNotReturnRecordsDeletedAfterVersion(): void
    {
        $AllSportsController = new AllSportsController();

        SportFactory::new()->count(3)->create();

        $result = $AllSportsController(new Request);

        Sport::first()->delete();
        
        $version = (string) new Version();
        $request = Request::create('/v1/sports/all', 'GET', ['version' => $version]);
        $versionedResult = $AllSportsController($request);

        $resultCount = count(json_decode($result->content()));
        $versionedResultCount = count(json_decode($versionedResult->content()));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedBeforeVersion(): void
    {
        $AllSportsController = new AllSportsController();

        SportFactory::new()->count(3)->create();

        $result = $AllSportsController(new Request);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $request = Request::create('/v1/sports/all', 'GET', ['version' => $version]);
        $versionedResult = $AllSportsController($request);

        $resultCount = count(json_decode($result->content()));
        $versionedResultCount = count(json_decode($versionedResult->content()));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }
}