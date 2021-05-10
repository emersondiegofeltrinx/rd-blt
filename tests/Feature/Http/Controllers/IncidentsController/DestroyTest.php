<?php

namespace Tests\Feature\Http\Controllers\IncidentsController;

use App\Models\Incident;
use App\Services\IncidentService;
use Mockery\MockInterface;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    /**
     * Test destroy
     *
     * @return void
     */
    public function testDestroy(): void
    {
        $incident = Incident::factory()->create();

        $response = $this->delete(route('incidents.destroy', $incident->id));

        $response->assertRedirect(route('incidents.index'));

        $this->assertDatabaseMissing('incidents', [
            'id' => $incident->id
        ]);
    }

    /**
     * Test delete with not found record
     *
     * @return void
     */
    public function testDeleteNotFound(): void
    {
        $response = $this->delete(route('incidents.destroy', ['id' => 0])); // Not Found

        $response->assertRedirect(route('incidents.index'));
        $this->assertCount(1, session('message-error'));
    }

    /**
     * Test destroy with validation errors
     *
     * @return void
     */
    public function testDestroyValidationErrors(): void
    {
        $response = $this->delete(route('incidents.destroy', ['id' => 'X'])); // Invalid

        $response->assertRedirect(route('incidents.index'));
        $this->assertCount(1, session('message-error'));
    }

    /**
     * Test destroy with error
     *
     * @return void
     */
    public function testDestroyError(): void
    {
        $this->mock(IncidentService::class, function (MockInterface $mock) {
            $mock->shouldReceive('delete')->andReturn(false);
        });

        $incident = Incident::factory()->create();

        $response = $this->delete(route('incidents.destroy', ['id' => $incident->id]));

        $response->assertRedirect(route('incidents.index'));
    }
}
