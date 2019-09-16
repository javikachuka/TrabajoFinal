<?php

use App\Rubro;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ZonaTableSeeder::class ,
            RolTableSeeder::class,
            PermissionsTableSeeder::class,
            UserTableSeeder::class ,
            EstadosTableSeeder::class ,
            RubroTableSeeder::class,
            TipoComprobanteTableSeeder::class ,
            PrioridadTableSeeder::class ,
        ]);

    }
}
