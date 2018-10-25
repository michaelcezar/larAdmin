<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserClientStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('user_client_status')->insert(
            [
                'description' => 'Ativo',
            ]           
        );
        DB::table('user_client_status')->insert(
            [
                'description' => 'Bloqueado',
            ]
        );
        DB::table('user_client_status')->insert(
            [
                'description' => 'Excluido',
            ]

        );
    }
}
