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
    
    protected $spatialFields = [
        'position'
    ];

    public function itens_tolls(){
        return $this->hasMany(TollItems::class);
    }

    /**
     * Get toll by name and multipoint
     * 
     * @param string $multipoint
     * @param string $name
     * @return Toll
     */
    public static function getToll($multipoint, $name)
    {
        return self::whereRaw("ST_Distance_Sphere(ST_GEOMFROMTEXT('$multipoint'), POINT(st_y(position), st_x(position))) < 300")
            ->where('category_description', $name)
            ->select(\DB::raw('sum(value) as value'))
            ->first();
    }
	
}
