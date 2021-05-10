<?php

namespace Tests\Feature\Http\Controllers\IncidentsController;

use App\Models\Incident;
use App\Services\IncidentService;
use Mockery\MockInterface;
use Tests\TestCase;

class StoreTest extends TestCase
{
    /**
     * Test store
     *
     * @return void
     */
    public function testStore(): void
    {
        $incident = Incident::factory()->make();

        $response = $this->post(
            route('incidents.store'),
            [
                'title'       => $incident->title,
                'description' => $incident->description,
                'criticality' => $incident->criticality,
                'type'        => $incident->type,
                'status'      => 'on',
            ]
        );

        $response->assertRedirect(route('incidents.index'));

        $this->assertDatabaseHas('incidents', [
            'title'       => $incident->title,
            'description' => $incident->description,
            'criticality' => $incident->criticality,
            'type'        => $incident->type,
            'status'      => Incident::STATUS_ACTIVE,
        ]);
    }

    /**
     * Test store with inactive
     *
     * @return void
     */
    public function testStoreInactive(): void
    {
        $incident = Incident::factory()->make();

        $response = $this->post(
            route('incidents.store'),
            [
                'title'       => $incident->title,
                'description' => $incident->description,
                'criticality' => $incident->criticality,
                'type'        => $incident->type,
                'status'      => '',
            ]
        );

        $response->assertRedirect(route('incidents.index'));

        $this->assertDatabaseHas('incidents', [
            'title'       => $incident->title,
            'description' => $incident->description,
            'criticality' => $incident->criticality,
            'type'        => $incident->type,
            'status'      => Incident::STATUS_INACTIVE,
        ]);
    }

    /**
     * Test store with validation errors
     *
     * @return void
     */
    public function testStoreValidationErrors(): void
    {
        $response = $this->post(
            route('incidents.store'),
            [
                'title'       => '',  // Empty
                'description' => '',  // Empty
                'criticality' => 'X', // Invalid
                'type'        => 'X', // Invalid
                'status'      => 'on',
            ]
        );

        $response->assertRedirect(route('incidents.create'));
        $response->assertSessionHasInput('title', '');
        $response->assertSessionHasInput('description', '');
        $response->assertSessionHasInput('criticality', 'X');
        $response->assertSessionHasInput('type', 'X');
        $response->assertSessionHasInput('status', Incident::STATUS_ACTIVE);
        $this->assertCount(4, session('message-error'));
    }

    /**
     * Test store with error
     *
     * @return void
     */
    public function testStoreError(): void
    {
        $this->mock(IncidentService::class, function (MockInterface $mock) {
            $mock->shouldReceive('save')->andReturn(false);
        });

        $incident = Incident::factory()->make();

        $response = $this->post(
            route('incidents.store'),
            [
                'title'       => $incident->title,
                'description' => $incident->description,
                'criticality' => $incident->criticality,
                'type'        => $incident->type,
                'status'      => 'on',
            ]
        );

        $response->assertRedirect(route('incidents.create'));
        $response->assertSessionHasInput('title', $incident->title);
        $response->assertSessionHasInput('description', $incident->description);
        $response->assertSessionHasInput('criticality', $incident->criticality);
        $response->assertSessionHasInput('type', $incident->type);
        $response->assertSessionHasInput('status', $incident->status);
    }
}
