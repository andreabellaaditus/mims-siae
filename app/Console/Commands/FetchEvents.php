<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Services\SiaeService;
use App\Models\Site;

class FetchEvents extends Command
{
    protected $signature = 'job:fetch-events';
    protected $description = 'Fetch events for all user sites';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sites = Site::whereRaw('cod_location_siae IS NOT NULL')->get();
        $siaeService = new SiaeService();
        $token = $siaeService->getToken();
        foreach($sites as $site){
            $startDate = Carbon::today()->format('Y-m-d 00:00:00');
            $endDate = Carbon::today()->addMonths(6)->format('Y-m-d 23:59:59');
            $siaeService->getEventi($token, $site->id, $startDate, $endDate);

        }
    }
}
