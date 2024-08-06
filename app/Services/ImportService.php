<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class ImportService
{
    public function import_old_db()
    {

        $dbOld = DB::connection('old');
        $dbOld->table('products')->dd();
    }
}
