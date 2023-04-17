<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'nombre' => 'Administrador',
                'apellido_paterno' => 'Administrador',
                'apellido_materno' => 'Administrador',
                'email' => 'administrador@gmail.com',
                'password' => bcrypt('123456'),
                'tipo_usuario' => 'ADMINISTRADOR',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'nombre' => 'Empleado',
                'apellido_paterno' => 'Empleado',
                'apellido_materno' => 'Empleado',
                'email' => 'empleado@gmail.com',
                'password' => bcrypt('123456'),
                'tipo_usuario' => 'EMPLEADO',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
