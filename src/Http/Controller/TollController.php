<?php

namespace Codificar\Toll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codificar\Toll\Http\Requests\ImportTollsFormRequest;
use Codificar\Toll\Imports\TollsImport;
use Codificar\Toll\Models\TollItems;
use Maatwebsite\Excel\Facades\Excel;

class TollController extends Controller 
{
    /**
     * Render list tolls page
     * @return view
     */
    public function tollList()
    {
        return view('toll::list');
    }

    public function fetchTolls(Request $request)
    {
        $model = new TollItems();

        $toll = $model->searchQuery($request);
        
        return json_encode($toll);
    }

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