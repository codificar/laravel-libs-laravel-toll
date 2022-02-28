<?php
namespace Database\Seeders;
use Codificar\Toll\Models\TollCategory;
use Illuminate\Database\Seeder;

class AddTollCategories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TollCategory::updateOrCreate(['name' => 'Automóvel Caminhonete Furgão'], ['name' => 'Automóvel Caminhonete Furgão']);
        TollCategory::updateOrCreate(['name' => 'Caminhão leve Ônibus Caminhão-trator Furgão'], ['name' => 'Caminhão leve Ônibus Caminhão-trator Furgão']);
        TollCategory::updateOrCreate(['name' => 'Caminhão-trator Caminhão-trator com semi-reboque Ônibus'], ['name' => 'Caminhão-trator Caminhão-trator com semi-reboque Ônibus']);
        TollCategory::updateOrCreate(['name' => 'Caminhão com reboque Caminhão-trator com semi-reboque'], ['name' => 'Caminhão com reboque Caminhão-trator com semi-reboque']);
        TollCategory::updateOrCreate(['name' => 'Automóvel e Caminhonete com semi-reboque'], ['name' => 'Automóvel e Caminhonete com semi-reboque']);
        TollCategory::updateOrCreate(['name' => 'Automóvel e Caminhonete com reboque'], ['name' => 'Automóvel e Caminhonete com reboque']);
        TollCategory::updateOrCreate(['name' => 'Motocicleta Motoneta Bicicleta a motor'], ['name' => 'Motocicleta Motoneta Bicicleta a motor']);
    }
}
