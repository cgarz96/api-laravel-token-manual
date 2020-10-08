<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        

DB::table('usuarios')->insert([
           	['usuario' => 'cris',
            'clave' =>  hash('md5', '1234')
            ],
            ['usuario' => 'leo',
            'clave' =>  hash('md5', '12345')
            ]
        ]);


    }
}
