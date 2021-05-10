<?php

namespace Tests\Feature\Http\Controllers\IncidentsController;

use App\Models\Incident;
use Tests\TestCase;

class EditTest extends TestCase
{
    /**
     * Test edit
     *
     * @return void
     */
    public function testEdit(): void
    {
        $incident = Incident::factory()->create();

        $response = $this->get(route('incidents.edit', $incident->id));

        $response->assertViewHas('incident');
        $response->assertViewHas('criticality');
        $response->assertViewHas('type');
        $response->assertViewHas('status');

        $data  = $response->getOriginalContent()->getData();

        $this->assertEquals($incident->id, $data['incident']->id);
        $this->assertEquals($incident->title, $data['incident']->title);
        $this->assertEquals($incident->description, $data['incident']->description);
    }

    /**
     * Test edit with not found record
     *
     * @return void
     */
    public function testEditNotFound(): void
    {
        $response = $this->get(route('incidents.edit', ['id' => 0])); // Not found

        $response->assertRedirect(route('incidents.index'));
        $this->assertCount(1, session('message-error'));
    }


    /**
     * Test edit with validation errors
     *
     * @return void
     */
    public function testEditValidationErrors(): void
    {
        $response = $this->get(route('incidents.edit', ['id' => 'X'])); // Invalid

        $response->assertRedirect(route('incidents.index'));
        $this->assertCount(1, session('message-error'));
    }
}
