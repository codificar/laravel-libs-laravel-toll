<?php

namespace Codificar\Toll\Http\Controllers;

use App\Http\Controllers\Controller;
use Codificar\Toll\Http\Requests\ImportTollsFormRequest;
use Codificar\Toll\Imports\TollsImport;
use Maatwebsite\Excel\Facades\Excel;

class TollController extends Controller 
{
    /**
     * @api {POST} /api/lib/toll/import 
     * Import toll data from file
     * @param ImportTollsFormRequest $request
     * @return json
     */
    public function importTolls(ImportTollsFormRequest $request)
    {
        Excel::import(new TollsImport, $request->file);

        return response()->json([
            'success' => true
        ]);
    }
}