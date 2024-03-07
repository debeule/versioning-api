<?php

declare(strict_types=1);

namespace App\Bpost\Queries;

use App\Bpost\Services\DownloadMunicipalities;
use App\Bpost\Services\StoreMunicipalities;
use App\Bpost\Services\ImportMunicipalities;

final class AllMunicipalities
{
    public function __construct(
        private DownloadMunicipalities $download = new DownloadMunicipalities,
        private StoreMunicipalities $store = new StoreMunicipalities,
        private ImportMunicipalities $import = new ImportMunicipalities,
    ) {
        $this->filePath = (string) $bpostUri;
    }

    public function query()
    {
        $file = $this->download->get();
        $this->store->get($file);
        
        return $this->import->get();
    }

    public function get()
    {
        return $this->query();
    }
}