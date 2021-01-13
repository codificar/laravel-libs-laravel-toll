<?php

namespace Codificar\Toll\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Codificar\Geolocation\Lib\MapsFactory;
use Codificar\Toll\Models\Toll;
use Codificar\Toll\Models\TollCategory;
use Codificar\Toll\Models\TollItems;

class TollsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $factory = new MapsFactory('places');
        $clicker = $factory->createMaps();
        
        foreach ($rows as $row) {
            if ($row[6] != null && gettype($row[6]) != 'string') {
                $place = $clicker->getGeocodeWithAddress($this->formatAddress($row));
                $point = $place['success'] ? 
                    new Point($place['data']['latitude'], $place['data']['longitude']) :
                    null;
                
                try {
                    $toll = new Toll;
                    $toll->name = $row[0];
                    $toll->highway = $row[1];
                    $toll->km = $row[2];
                    $toll->category = $row[3];
                    $toll->axis = $row[4];
                    $toll->category_description = $row[5];
                    $toll->value = $row[6];
                    $toll->position = $point;
                    $toll->save();
    
                    $tollCategory = TollCategory::where('name', $row[5])->first();
    
                    if ($tollCategory) {
                        $tollItems =  new TollItems;
                        $tollItems->toll()->associate($toll);
                        $tollItems->toll_category_id = $tollCategory->id;
                        $tollItems->save();
                    }
                } catch (\Throwable $th) {
                    \Log::error($th->getMessage());
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Format address to search geocode
     * @param array $data
     * @return string
     */
    public function formatAddress($data)
    {
        try {
            return $data[0] . ' ' . $data[1] . ', Km ' . $data[2] . ' Brasil';
        } catch (\Throwable $th) {
            \Log::error($th->getMessage());
            return '';
        }
    }
}