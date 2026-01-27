<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // SALUDOS
        // =====================
        Faq::create([
            'pregunta' => 'Hola',
            'respuesta' => '¡Hola!, Bienvenido al Instituto de Salud. ¿En qué puedo ayudarte?',
            'palabras_clave' => 'hola,buenas,hey,qué tal',
            'activo' => true
        ]);

        Faq::create([
            'pregunta' => 'Buenos días',
            'respuesta' => '¡Buenos días! ¿Cómo puedo apoyarte hoy?',
            'palabras_clave' => 'buenos días,buen dia',
            'activo' => true
        ]);

        Faq::create([
            'pregunta' => 'Buenas tardes',
            'respuesta' => '¡Buenas tardes! Estoy aquí para ayudarte.',
            'palabras_clave' => 'buenas tardes',
            'activo' => true
        ]);

        // =====================
        // INFORMACIÓN GENERAL
        // =====================
        Faq::create([
            'pregunta' => '¿Cuál es el horario de atención?',
            'respuesta' => 'Nuestro horario de atención es de lunes a viernes de 7:00 a 18:00 hrs.',
            'palabras_clave' => 'horario,atención,abren,cierran',
            'activo' => true
        ]);

        Faq::create([
            'pregunta' => '¿Dónde están ubicados?',
            'respuesta' => 'Nos encontramos en Av. Salud #456, Colonia Centro.',
            'palabras_clave' => 'ubicación,dirección,donde',
            'activo' => true
        ]);

        // =====================
        // SERVICIOS MÉDICOS
        // =====================
        Faq::create([
            'pregunta' => '¿Qué servicios médicos ofrecen?',
            'respuesta' => 'Ofrecemos consulta general, enfermería, vacunación, laboratorio y farmacia.',
            'palabras_clave' => 'servicios,consultas,atención médica',
            'activo' => true
        ]);

        Faq::create([
            'pregunta' => '¿Atienden consultas médicas?',
            'respuesta' => 'Sí, contamos con consultas médicas generales previa cita.',
            'palabras_clave' => 'consulta,médico,doctor',
            'activo' => true
        ]);

        // =====================
        // CITAS
        // =====================
        Faq::create([
            'pregunta' => '¿Cómo puedo agendar una cita?',
            'respuesta' => 'Puedes agendar una cita directamente en recepción o llamando a nuestro número telefónico.',
            'palabras_clave' => 'cita,agendar,consulta',
            'activo' => true
        ]);

        // =====================
        // EMERGENCIAS
        // =====================
        Faq::create([
            'pregunta' => '¿Atienden emergencias?',
            'respuesta' => 'En caso de emergencia, acude inmediatamente al hospital más cercano o llama al 911.',
            'palabras_clave' => 'emergencia,urgencia,grave',
            'activo' => true
        ]);

        // =====================
        // CONTACTO
        // =====================
        Faq::create([
            'pregunta' => '¿Cuál es su número de teléfono?',
            'respuesta' => 'Puedes comunicarte con nosotros al teléfono (555) 123-4567.',
            'palabras_clave' => 'teléfono,contacto,llamar',
            'activo' => true
        ]);

        // =====================
        // DESPEDIDAS
        // =====================
        Faq::create([
            'pregunta' => 'Gracias',
            'respuesta' => '¡Con gusto!, Si necesitas algo más, aquí estaré.',
            'palabras_clave' => 'gracias,muchas gracias',
            'activo' => true
        ]);

        Faq::create([
            'pregunta' => 'Adiós',
            'respuesta' => '¡Hasta luego!, Que tengas un excelente día.',
            'palabras_clave' => 'adiós,hasta luego,nos vemos',
            'activo' => true
        ]);
    }
}