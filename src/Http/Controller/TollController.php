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

    /**
     * @api {POST} /api/lib/toll/fetch
     * List tolls
     * @param Request $request
     * @param TollItems $items
     * @return json
     */
    public function fetchTolls(Request $request, TollItems $items)
    {
        return response()->json([
            'toll' => $items->searchQuery($request)
        ]);
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

    /** Função que recebe os dados para serem deletados e os elimina do banco de dados;
     * 	@param id int - id do campo na tabela toll, referente ao campo que deve ser deletado.
     * 	@return json
     */
    public function delete($id) {
        $tollItems = TollItems::findOrFail($id);
        $tollItems->delete();
        return response()->json(['success' => true, 'message' => trans('success_delete')]);
    }
}