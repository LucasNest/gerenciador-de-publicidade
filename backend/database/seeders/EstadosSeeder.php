<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use App\Models\CadEstado;
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
            ['descricao' => 'Mato Grosso', 'sigla' => 'MT'],
            ['descricao' => 'Mato Grosso do Sul', 'sigla' => 'MS'],
            ['descricao' => 'Minas Gerais', 'sigla' => 'MG'],
            ['descricao' => 'Pará', 'sigla' => 'PA'],
            ['descricao' => 'Paraíba', 'sigla' => 'PB'],
            ['descricao' => 'Paraná', 'sigla' => 'PR'],
            ['descricao' => 'Pernambuco', 'sigla' => 'PE'],
            ['descricao' => 'Piauí', 'sigla' => 'PI'],
            ['descricao' => 'Rio de Janeiro', 'sigla' => 'RJ'],
            ['descricao' => 'São Paulo', 'sigla' => 'SP'],
        ];

        foreach ($estados as $estado) {
            $estado = CadEstado::updateOrCreate(
                ['sigla' => $estado['sigla']],
                $estado
            );
        }
    }
}
