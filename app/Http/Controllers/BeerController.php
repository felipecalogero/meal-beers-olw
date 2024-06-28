<?php

namespace App\Http\Controllers;

use App\Exports\BeerExport;
use App\Services\PunkapiService;
use App\Http\Requests\BeerRequest;
use App\Jobs\ExportJob;
use App\Jobs\SendExportEmailJob;
use App\Jobs\StoreExportDataJob;
use Maatwebsite\Excel\Facades\Excel;
use App\Mail\ExportEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Export;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class BeerController extends Controller
{
    public function index(BeerRequest $request, PunkapiService $service)
    {
        return $service->getBeers(...$request->validated());
    }

    public function export(BeerRequest $request, PunkapiService $service)
    {

        $filename = "cervejas-" . now()->format('Y-m-d - H_i') . ".xlsx";

        ExportJob::withChain([
            new SendExportEmailJob($filename),
            new StoreExportDataJob(auth()->user(), $filename)
        ])->dispatch($request->validated(), $filename);


        return 'relatorio criado!';
    }
}
