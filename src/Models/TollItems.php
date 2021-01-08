<?php

namespace Codificar\Toll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class TollItems extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
    protected $table = 'toll_items';
    
    protected $primaryKey = 'id';

    public $fillable = [
        'name',
        'toll_id',
        'axis',
        'toll_category_id'
    ];

    public function toll(){
        return $this->belongsTo(Toll::class);
	}
	
	public function tollCategory(){
		return $this->belongsTo(TollCategory::class);
	}
    
    /** Função que recebe os dados para pesquisa com e sem filtro;
     * 	@param request.
     * 	@return search;
     */
	public function searchQuery(Request $request)
	{
		// get query parameters
		$params = $request->all();

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
		$query = TollItems::WhereNotNull('toll_items.id');
		$query->leftjoin('toll', 'toll_items.toll_id', '=', 'toll.id');
			
		// get filters conditions
		$filters = isset($params["filters"]) ? $params["filters"] : $params;

		if(isset($filters["Toll"])){
			$TollConditions = $filters["Toll"] ;
			if(isset($TollConditions["name"]))
				$query->where('toll.name', 'LIKE', '%'.$TollConditions["name"].'%');

			if(isset($TollConditions["axis"]))
				 $query->where('toll_items.axis', 'LIKE', '%'.$TollConditions["axis"].'%');
			
		}

		return $query->paginate($pagination["itensPerPage"], array('toll.address as ad','toll.address as address','toll.name as name', 'toll_items.id as id','toll_items.axis as axis'));
    }
	
	/** Função que limpa as tabelas;	
     * 	@return boolean - true ou false;	
     */
    public function clearTableDB(){
		try {
		  DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		  DB::table('toll_items')->truncate();
		  DB::table('toll')->truncate();
		  DB::table('vehicle_type')->truncate();
		  DB::statement('SET FOREIGN_KEY_CHECKS=1;');
  
		} catch (\Throwable $th) {
		  return false;
		}
		
		return true;
	  }
  
}
