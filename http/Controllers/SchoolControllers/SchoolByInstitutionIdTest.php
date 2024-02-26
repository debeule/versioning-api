<?php

declare(strict_types=1);

namespace Http\Controllers\SchoolControllers;

use App\Testing\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use DateInterval;
use Http\Controllers\SchoolControllers\SchoolByInstitutionId as SchoolByInstitutionIdController;
use Illuminate\Http\JsonResponse;
use App\School\School;
use Database\Main\Factories\SchoolFactory;

final class SchoolByInstitutionIdTest extends TestCase
{
    private string $endpoint = '/api/v1/schools/institution_id/';

    #[Test]
    public function itReturnsSchoolRecord(): void
    {
        $school = SchoolFactory::new()->create();
        
        $response = $this->get($this->endpoint . $school->institution_id);
        
        $result = json_decode($response->content(), true);
        

        foreach ($school->getFillable() as $fillable) 
        {
            $this->assertArrayHasKey($fillable, $result);
        }
    }

    #[Test]
    public function itDoesNotReturnRecordsDeletedBeforeVersion(): void
    {
        $school = SchoolFactory::new()->create();

        $response = $this->get($this->endpoint . $school->institution_id);

        $school->delete();
        
        $versionedResponse = $this->get($this->endpoint . $school->institution_id);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }

    #[Test]
    public function itDoesNotReturnRecordsCreatedAfterVersion(): void
    {
        $school = SchoolFactory::new()->create();

        $response = $this->get($this->endpoint . $school->institution_id);
        
        $version = new DateTimeImmutable();
        $version = $version->sub(new DateInterval('P1D'));
        $version = $version->format('Y-m-d');
        
        $versionedResponse = $this->get($this->endpoint . $school->institution_id . '?version=' . $version);

        $resultCount = count(json_decode($response->content(), true));
        $versionedResultCount = count(json_decode($versionedResponse->content(), true));

        $this->assertGreaterThan($versionedResultCount, $resultCount);
    }
}