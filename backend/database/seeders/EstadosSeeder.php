<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['descricao' => 'Acre', 'sigla' => 'AC'],
            ['descricao' => 'Alagoas', 'sigla' => 'AL'],
            ['descricao' => 'Amapá', 'sigla' => 'AP'],
            ['descricao' => 'Amazonas', 'sigla' => 'AM'],
            ['descricao' => 'Bahia', 'sigla' => 'BA'],
            ['descricao' => 'Ceará', 'sigla' => 'CE'],
            ['descricao' => 'Distrito Federal', 'sigla' => 'DF'],
            ['descricao' => 'Espírito Santo', 'sigla' => 'ES'],
            ['descricao' => 'Goiás', 'sigla' => 'GO'],
            ['descricao' => 'Maranhão', 'sigla' => 'MA'],
        ];

        DB::table('cad_estados')->insert($estados);
    }
}
