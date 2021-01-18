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

	/**
	 * Relation with TollItems
	 */
    public function itensTolls(){
        return $this->hasMany(TollItems::class);
    }

     /** Função que recebe os dados para pesquisa com e sem filtro;
     * 	@param request.
     * 	@return search;
     */
	public function searchQuery($request)
	{	
		// get query parameters
		$params = $request['searchParams'];

		// get pagination conditions
		if(isset($params["pagination"])) {
			$pagination = $params["pagination"];
		}
		else { // set default 
			$pagination =  ["actual" => 1, "itensPerPage" => 5 ] ;
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
	
	/**
	 * Store or edit TollCategory
	 * @param object $request
	 * @return TollCategory
	 */
	public function store($request){
		$tollCategory =  $request->editMode == true ? TollCategory::findOrFail($request->id) : new TollCategory();
		$tollCategory->name = $request->name;
		$tollCategory->save();

		return $tollCategory;
	}

	/**
	 * Check if exists
	 * @param string $name
	 * @return TollCategory
	 */
	public static function validadeIfExist($name){
		return self::where('name',$name)->first();
	}
}