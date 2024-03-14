<?php

declare(strict_types=1);

namespace Http\Endpoints\School;

use App\Exports\School as ExportSchool;
use App\Testing\TestCase;
use Database\Main\Factories\BillingProfileFactory;
use Database\Main\Factories\SchoolFactory;
use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\Test;

final class SchoolByInstitutionIdHandlerTest extends TestCase
{
    private string $endpoint = '/api/v1/schools/institution_id/';

    #[Test]
    public function itReturnsSchoolRecord(): void
    {
        $school = SchoolFactory::new()->create();
        BillingProfileFactory::new()->withrecordId($school->id)->create();
        
        $response = $this->get($this->endpoint . $school->institution_id);
        
        $result = json_decode($response->content(), true);

        $school = new ExportSchool;
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
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
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
        
        $this->assertGreaterThan(0, $resultCount);
        $this->assertEquals('404', $versionedResponse->status());
    }
}