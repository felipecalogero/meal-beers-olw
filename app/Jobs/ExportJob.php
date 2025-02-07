<?php

namespace App\Jobs;

use App\Exports\BeerExport;
use App\Services\PunkapiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filename;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $data,
        string $filename,
        protected PunkapiService $service = new PunkapiService
    ) {
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $beers = $this->service->getBeers(...$this->data);

        $filteredBeers = array_map(function ($value) {
            return collect($value)
                ->only(['name', 'tagline', 'first_brewed', 'description'])
                ->toArray();
        }, $beers);

        Excel::store(
            new BeerExport($filteredBeers),
            $this->filename,
            's3'
        );
    }
}
