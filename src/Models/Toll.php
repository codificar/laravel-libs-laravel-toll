<?php

namespace Codificar\Toll\Models;

use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Toll extends Model
{
    use SpatialTrait;
    
     /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
    protected $table = 'toll';
    
    protected $primaryKey = 'id';

    public $fillable = [
		'name',
        'address',
        'position'
    ];
    
    protected $spatialFields = [
        'position'
    ];

    public function itens_tolls(){
        return $this->hasMany(TollItems::class);
    }


	
}
