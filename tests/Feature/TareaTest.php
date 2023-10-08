<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Tarea;

class TareaTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase; 

    public function test_InsertarTarea()
    {
        $response = $this->post('/api/tarea', [
            "titulo" => "Tarea de Prueba",
            "contenido" => "Contenido de prueba",
            "estado" => "En progreso",
            "autor" => "Autor de Prueba",
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tarea', [
            "titulo" => "Tarea de Prueba",
            "contenido" => "Contenido de prueba",
            "estado" => "En progreso",
            "autor" => "Autor de Prueba",
        ]);
    }

    public function test_ListarTareas()
    {
        $response = $this->get('/api/tarea');

        $response->assertStatus(200);
    }

    public function test_EliminarTarea()
    {
        $tarea = factory(Tarea::class)->create();

        $response = $this->delete('/api/tarea/' . $tarea->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tarea', [
            'id' => $tarea->id,
        ]);
    }
}