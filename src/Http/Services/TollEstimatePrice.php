<?php

namespace Codificar\Toll\Http\Services;

use Codificar\Toll\Models\Toll;
use Codificar\Toll\Models\TollCategory;
use Location\Coordinate;
use Location\Distance\Vincenty;

class TollEstimatePrice
{
    /**
     * Check and return value of toll
     * @param int $type
     * @param array $polyline
     * @return array
     */
    public static function getPriceToll($type, $polyline)
    {
        try {
            $providerType = \ProviderType::find($type);

            if ($polyline && !is_array($polyline) && get_class($polyline) == 'Illuminate\Database\Eloquent\Collection') {
                $polylineData = [];
                foreach ($polyline as $item) {
                    $polylineData[] = [
                        'lat' => $item->latitude,
                        'lng' => $item->longitude
                    ];
                }
            } else {
                $polylineData = $polyline;
            }

            if ($polylineData && $providerType && $providerType->toll_category_id && $tollCategory = TollCategory::find($providerType->toll_category_id)) {
                $tolls = Toll::where('category_description', $tollCategory->name)->get();
                
                foreach ($polylineData as $item) {
                    for ($i=0; $i < count($tolls); $i++) { 
                        $toll = $tolls[$i];
                        
                        $tollPoint = new Coordinate($toll->position->getLat(), $toll->position->getLng());
                        $polylinePoint     = new Coordinate($item['lat'], $item['lng']);
                        
                        $calculator = new Vincenty();

                        $distance   = $calculator->getDistance(	$tollPoint, $polylinePoint );
                        $check 		= round($distance) <= 300; 

                        if ($check) {
                            return [
                                'value' => $toll->value,
                                'toll_description' => $toll->category_description
                            ];
                        } 
                    }
                }
            }

            return [
                'value' => 0,
                'toll_description' => null
            ];
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return [
                'value' => 0,
                'toll_description' => null
            ];
        }
        
    }
}