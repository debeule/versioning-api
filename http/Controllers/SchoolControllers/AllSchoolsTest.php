<?php

declare(strict_types=1);

namespace Http\Controllers\SchoolControllers;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Controllers\SchoolControllers\AllSchools as AllSchoolsController;
use Illuminate\Http\JsonResponse;
use App\School\School;
use App\Exports\School as ExportSchool;
use Database\Main\Factories\SchoolFactory;
use Database\Main\Factories\BillingProfileFactory;

final class AllSchoolsTest extends TestCase
{
    private string $endpoint = '/api/v1/schools/all/';

    #[Test]
    public function itReturnsValidSchoolRecord(): void
    {
        $schools = SchoolFactory::new()->create();
        BillingProfileFactory::new()->withSchoolId($schools->id)->create();

        $response = $this->get($this->endpoint);

        $result = json_decode($response->content(), true)[0];

        $school = new ExportSchool;
        foreach ($school->getFillable() as $fillable) 
        {
            $this->assertArrayHasKey($fillable, $result);
        }
    }

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $schools = SchoolFactory::new()->count(3)->create();

        $response = $this->get($this->endpoint);

        $schools->first()->delete();
        
        $versionedResponse = $this->get($this->endpoint);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $schools = SchoolFactory::new()->count(3)->create();

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