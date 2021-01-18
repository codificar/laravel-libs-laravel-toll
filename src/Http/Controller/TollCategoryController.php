<?php

namespace Codificar\Toll\Http\Controllers;

use App\Http\Controllers\Controller;
use Codificar\Toll\Http\Requests\TollCategoryFormRequest;
use Illuminate\Http\Request;
use Codificar\Toll\Http\Resources\TollCategoryResource;
use Codificar\Toll\Models\TollCategory;

class TollCategoryController extends Controller 
{
    /**
     * Render list category page
     * @return view
     */
    public function list () 
    {
        return view('toll::list_category');
    }

    /** 
     * @api {POST} /api/lib/toll_categories
     * Função que responsavel realizar insert and edit
     * @param TollCategoryFormRequest $request	
     * @return TollCategoryResource
     */
    public function store(TollCategoryFormRequest $request, TollCategory $model)
    {
        return new TollCategoryResource($model->store($request)); 
    }

    /**
     * @api {POST} /api/lib/toll_category/fetch
     * Fetch the toll categories registers
     * @param Request $request
     * @param TollCategory $tollCategory
     * @return json
     */
    public function fetch(Request $request, TollCategory $tollCategory) 
    {
        return response()->json([
            'toll' => $tollCategory->searchQuery($request)
        ]);
    }

     /** 
      * Função que recebe os dados para serem deletados e os elimina do banco de dados;
      * @param id int - id do campo na tabela toll_Category, referente ao campo que deve ser deletado.
      * @return response
      */
    public function destroy($id) {
        $tollCategory = TollCategory::findOrFail($id);
        if($tollCategory->delete()){
            return new TollCategoryResource($tollCategory); 
        }
    }
}