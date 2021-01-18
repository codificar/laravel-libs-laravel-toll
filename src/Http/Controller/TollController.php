<?php

namespace Codificar\Toll\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codificar\Toll\Http\Requests\ImportTollsFormRequest;
use Codificar\Toll\Imports\TollsImport;
use Codificar\Toll\Models\TollItems;
use Codificar\Toll\Utils\Helper;
use Maatwebsite\Excel\Facades\Excel;
use Settings;

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

    public function settings()
    {
        return view('toll::settings', [
            'is_toll_active' => Helper::getIsTollActive(),
            'apply_toll_in_estimate' => Helper::getApplyInEstimate()
        ]);
    }

    /**
     * Save setting for toll
     * @param Request $request
     * @return json
     */
    public function saveSetting(Request $request)
    {
        try {
            Settings::updateOrCreate([
                'key' => 'is_toll_active'
            ], [
                'key' => 'is_toll_active',
                'value' => $request->is_toll_active
            ]);

            Settings::updateOrCreate([
                'key' => 'apply_toll_in_estimate'
            ], [
                'key' => 'apply_toll_in_estimate',
                'value' => $request->apply_toll_in_estimate
            ]);
    
            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return response()->json([
                'success' => false
            ]);
        }
    }
}