<?php

namespace Codificar\Toll\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Codificar\Geolocation\Lib\MapsFactory;
use Codificar\Toll\Models\Toll;

class TollsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        $factory = new MapsFactory('places');
        $clicker = $factory->createMaps();
        
        foreach ($rows as $row) {
            $place = $clicker->getGeocodeWithAddress($row[1]);
            $point = $place['success'] ? 
                new Point($place['data']['latitude'], $place['data']['longitude']) :
                null;
            
            try {
                $toll = new Toll;
                $toll->name = $row[0];
                $toll->address = $row[1];
                $toll->position = $point;
                $toll->save();
            } catch (\Throwable $th) {
                \Log::error($th->getMessage());
                return false;
            }
        }

        return true;
    }
}