<?php

namespace Codificar\Toll\Http\Services;

use Codificar\Toll\Models\Toll;
use Codificar\Toll\Models\TollCategory;
use Codificar\Toll\Utils\Helper;

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
            if (!Helper::getIsTollActive()) {
                return [
                    'value' => 0,
                    'toll_description' => null
                ];
            }

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

            if (count($polylineData) && $providerType && $providerType->toll_category_id && $tollCategory = TollCategory::find($providerType->toll_category_id)) {
                $multipoint = self::getMultipointText($polylineData);

                $toll = Toll::getToll($multipoint, $tollCategory->name);
                
                if ($toll)
                    return [
                        'value' => $toll->value,
                        'toll_description' => $tollCategory->name
                    ];
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

    /**
     * Get multipoint text for query
     * 
     * @param array $polylineData
     * @return string
     */
    public static function getMultipointText($polylineData)
    {
        $multipoint = '';

        foreach ($polylineData as $item) {
            if (array_key_exists('lat', $item))
                $multipoint = $multipoint . $item['lat'] . ' ' . $item['lng'] . ',';
            else if (array_key_exists('latitude', $item))
                $multipoint = $multipoint . $item['latitude'] . ' ' . $item['longitude'] . ',';
        }
        
        $multipoint = 'MULTIPOINT(' . substr($multipoint, 0, -1) . ')';

        return $multipoint;
    }
}