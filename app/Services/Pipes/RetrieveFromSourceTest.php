<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use PhpUnit\Framework\TestCase;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;

final class RetrieveFromSourceTest extends TestCase
{
    #[Test]
    public function returnsFileContentsFromSource(): void
    {
        #TODO: fake
        $data = [
            'source' => 'https://freetestdata.com/wp-content/uploads/2021/09/Free_Test_Data_100KB_XLS.xls',
        ];

        $result = app(Pipeline::class)
            ->send($data)
            ->through([RetrieveFromSource::class])
            ->thenReturn();

        $this->assertEquals(
            Storage::disk('local')->get('excel/TestFile.xls'),
            $result['file']
        );
    }
}