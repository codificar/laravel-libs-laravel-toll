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
    public function list () {
        return view('toll::list_category');
    }

    public function query(Request $request) {
     
        $model = new TollCategory();
        
        $tollCategory = $model->searchQuery($request);
        
        return  TollCategoryResource::collection($tollCategory);
    }

    /** Função que responsavel realizar insert and edit;	
    * 	@return true or false, json message;	
    */
    public function store(TollCategoryFormRequest $request){
        $model = new TollCategory();
        if($request->editMode == false){
            $tollCategory = $model->validadeIfExist($request);
            if($tollCategory){
                return response()->json(
                    [
                        'success' => false,
                        'errors' => [trans('category.name.toll_category_exist')],
                        'error_code' => \ApiErrors::REQUEST_FAILED
                    ]
                );  
            }
        }
        $tollCategory = $model->store($request);
        return new TollCategoryResource($tollCategory); 
    }

     /** Função que recebe os dados para serem deletados e os elimina do banco de dados;
     * 	@param id int - id do campo na tabela toll_Category, referente ao campo que deve ser deletado.
     * 	@return response-success;
     */
    public function destroy($id) {
        $tollCategory = TollCategory::findOrFail($id);
        if($tollCategory->delete()){
            return new TollCategoryResource($tollCategory); 
        }
    }
}