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
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Inertia\Inertia;

class BeerController extends Controller
{
    public function index(BeerRequest $request, PunkapiService $service)
    {
        $filters = $request->validated();
        $beers = $service->getBeers(...$filters);
        $meals = Meal::all();

        return Inertia::render('Beers', [
            'beers' => $beers,
            'meals' => $meals,
            'filters' => $filters
        ]);
    }

    public function export(BeerRequest $request, PunkapiService $service)
    {

        $filename = "cervejas-" . now()->format('Y-m-d - H_i') . ".xlsx";

        ExportJob::withChain([
            new SendExportEmailJob($filename),
            new StoreExportDataJob(auth()->user(), $filename)
        ])->dispatch($request->validated(), $filename);

        return redirect()->back();
    }
}
