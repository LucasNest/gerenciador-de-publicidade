<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use App\Models\CadEstado;
use App\Models\CadPublicidade;
use Illuminate\Database\Seeder;

class PublicidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publicidades = [
            [
                'titulo' => 'Convite Especial para Prefeitos(as) e Secretários(as)',
                'descricao' => 'Vagas limitadas e exclusivas para Prefeitos(as) e Secretários(as) — até 3 por município. Confirmação de presença até 05 de maio:',
                'imagem' => 'storage/uploads/prefeituraImagem.png',
                'botao_link' => 'https://www.youtube.com/',
                'titulo_botao_link' => 'Convite Especial',
                'dt_inicio' => '2025-07-07',
                'dt_fim' => '2025-07-09',
            ],
            [
                'titulo' => 'Bem-vindo ao GEOSIAP!',
                'descricao' => 'Um ambiente integrado e inteligente para transformar a gestão pública. O GEOSIAP reúne uma ampla coleção de sistemas e ferramentas pensadas para facilitar e modernizar a administração municipal e estadual, promovendo eficiência, transparência e controle em todas as etapas do trabalho.',
                'imagem' => 'storage/uploads/logoEmbras.png',
                'botao_link' => 'https://www.youtube.com/',
                'titulo_botao_link' => 'GEOSIAP!',
                'dt_inicio' => '2025-07-10',
                'dt_fim' => '2025-07-12',
            ],
            [
                'titulo' => 'Festival de Inverno Rio 2025',
                'descricao' => 'De 10 a 20 de julho de 2025, o Festival de Inverno Rio retorna para transformar a cidade em um grande palco de cultura, música e arte. Serão dias repletos de shows imperdíveis, apresentações de artistas consagrados e novas promessas, gastronomia de primeira e uma atmosfera única que só o Rio sabe oferecer.',
                'imagem' => 'storage/uploads/rioFestival.png',
                'botao_link' => 'https://www.youtube.com/',
                'titulo_botao_link' => 'Festival de Inverno',
                'dt_inicio' => '2025-07-13',
                'dt_fim' => '2025-07-14',
            ]
        ];

        
        foreach ($publicidades as $publicidade) {
            $publicidade = CadPublicidade::updateOrCreate(
                ['titulo' => $publicidade['titulo']],
                $publicidade
            );

            $publicidade->estados()->sync([1, 2, 3]);
        }
    }
}
