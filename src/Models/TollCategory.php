<?php

namespace Codificar\Toll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class TollCategory extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
    protected $table = 'toll_category';
    
    protected $primaryKey = 'id';

    public $fillable = [
        'name'
    ];

    public function itensTolls(){
        return $this->hasMany(TollItems::class);
    }

     /** Função que recebe os dados para pesquisa com e sem filtro;
     * 	@param request.
     * 	@return search;
     */
	public function searchQuery(Request $request)
	{	
		// get query parameters
		$params = $request['searchParams'];

		// get pagination conditions
		if(isset($params["pagination"])) {
			$pagination = $params["pagination"];
		}
		else { // set default 
			$pagination =  ["actual" => 1, "itensPerPage" => 25 ] ;
		}

		// resolve current page
		$currentPage = $pagination["actual"];
		Paginator::currentPageResolver(function () use ($currentPage) {
			return $currentPage;
		});	

		// set first condition 1=1 (all results)
		$query = TollCategory::WhereNotNull('toll_category.id');
	
		// get filters conditions
		$filters = isset($params["filters"]) ? $params["filters"] : $params;

		if(isset($filters["Categoryfilter"])){
			$tollCategoryConditions = $filters["Categoryfilter"] ;
			if(isset($tollCategoryConditions["name"]))
				$query->where('toll_category.name', 'LIKE', '%'.$tollCategoryConditions["name"].'%');

		}
		return $query->paginate($pagination["itensPerPage"], array('toll_category.id as id','toll_category.name as name'));

	}
	
	public function store(Request $request){
		$tollCategory =  $request->editMode == true ? TollCategory::findOrFail($request->id) : new TollCategory();
		$tollCategory->name = $request->name;
		if($tollCategory->save()){
			return $tollCategory;
		}
	}

	public function validadeIfExist(Request $request){
		return TollCategory::where('name',$request->name)->first();
	}
}