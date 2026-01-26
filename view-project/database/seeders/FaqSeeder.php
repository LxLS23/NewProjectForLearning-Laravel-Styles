<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        Faq::create([
            'pregunta' => '¿Cuál es el horario de atención?',
            'respuesta' => 'El Instituto Tecnológico del Valle atiende de lunes a viernes de 8:00 a 16:00 hrs.',
            'palabras_clave' => 'horario,atención,abrir',
            'activo' => true
        ]);

        Faq::create([
            'pregunta' => '¿Dónde están ubicados?',
            'respuesta' => 'Nos ubicamos en Av. Central #123, Ciudad Valle.',
            'palabras_clave' => 'ubicación,dirección,donde',
            'activo' => true
        ]);

        Faq::create([
            'pregunta' => '¿Qué servicios ofrecen?',
            'respuesta' => 'Ofrecemos inscripciones, constancias, asesorías académicas y atención estudiantil.',
            'palabras_clave' => 'servicios,trámites,ofrecen',
            'activo' => true
        ]);
    }
}
