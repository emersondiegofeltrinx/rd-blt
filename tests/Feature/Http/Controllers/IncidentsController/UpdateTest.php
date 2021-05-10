<?php

namespace Tests\Feature\Http\Controllers\IncidentsController;

use App\Models\Incident;
use App\Services\IncidentService;
use Mockery\MockInterface;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * Test update
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $incidentOld = Incident::factory()->create();
        $incidentNew = Incident::factory()->make();

        $response = $this->put(
            route('incidents.update', $incidentOld->id),
            [
                'title'       => $incidentNew->title,
                'description' => $incidentNew->description,
                'criticality' => $incidentNew->criticality,
                'type'        => $incidentNew->type,
                'status'      => 'on',
            ]
        );

        $response->assertRedirect(route('incidents.index'));

        $this->assertDatabaseHas('incidents', [
            'id'          => $incidentOld->id,
            'title'       => $incidentNew->title,
            'description' => $incidentNew->description,
            'criticality' => $incidentNew->criticality,
            'type'        => $incidentNew->type,
            'status'      => Incident::STATUS_ACTIVE,
        ]);
    }

    /**
     * Test update with inactive
     *
     * @return void
     */
    public function testUpdateInactive(): void
    {
        $incidentOld = Incident::factory()->create();
        $incidentNew = Incident::factory()->make();

        $response = $this->put(
            route('incidents.update', ['id' => $incidentOld->id]),
            [
                'title'       => $incidentNew->title,
                'description' => $incidentNew->description,
                'criticality' => $incidentNew->criticality,
                'type'        => $incidentNew->type,
                'status'      => '',
            ]
        );

        $response->assertRedirect(route('incidents.index'));

        $this->assertDatabaseHas('incidents', [
            'id'          => $incidentOld->id,
            'title'       => $incidentNew->title,
            'description' => $incidentNew->description,
            'criticality' => $incidentNew->criticality,
            'type'        => $incidentNew->type,
            'status'      => Incident::STATUS_INACTIVE,
        ]);
    }

    /**
     * Test update with not found record
     *
     * @return void
     */
    public function testUpdateNotFound(): void
    {
        $incident = Incident::factory()->create();

        $response = $this->put(
            route('incidents.update', ['id' => 0]), // Not Found
            [
                'title'       => $incident->title,
                'description' => $incident->description,
                'criticality' => $incident->criticality,
                'type'        => $incident->type,
                'status'      => $incident->status,
            ]
        );

        $response->assertRedirect(route('incidents.edit', 0));
        $response->assertSessionHasInput('title', $incident->title);
        $response->assertSessionHasInput('description', $incident->description);
        $response->assertSessionHasInput('criticality', $incident->criticality);
        $response->assertSessionHasInput('type', $incident->type);
        $response->assertSessionHasInput('status', $incident->status);
        $this->assertCount(1, session('message-error'));
    }

    /**
     * Test update with validation errors
     *
     * @return void
     */
    public function testUpdateValidationErrors(): void
    {
        $incident = Incident::factory()->create();

        $response = $this->put(
            route('incidents.update', ['id' => $incident->id]),
            [
                'title'       => '',  // Empty
                'description' => '',  // Empty
                'criticality' => 'X', // Invalid
                'type'        => 'X', // Invalid
                'status'      => 'on',
            ]
        );

        $response->assertRedirect(route('incidents.edit', $incident->id));
        $response->assertSessionHasInput('title', '');
        $response->assertSessionHasInput('description', '');
        $response->assertSessionHasInput('criticality', 'X');
        $response->assertSessionHasInput('type', 'X');
        $response->assertSessionHasInput('status', Incident::STATUS_ACTIVE);
        $this->assertCount(4, session('message-error'));
    }

    /**
     * Test update with error
     *
     * @return void
     */
    public function testUpdateError(): void
    {
        $this->mock(IncidentService::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')->andReturn(false);
        });

        $incident = Incident::factory()->create();

        $response = $this->put(
            route('incidents.update', ['id' => $incident->id]),
            [
                'title'       => $incident->title,
                'description' => $incident->description,
                'criticality' => $incident->criticality,
                'type'        => $incident->type,
                'status'      => 'on',
            ]
        );

        $response->assertRedirect(route('incidents.edit', $incident->id));
        $response->assertSessionHasInput('title', $incident->title);
        $response->assertSessionHasInput('description', $incident->description);
        $response->assertSessionHasInput('criticality', $incident->criticality);
        $response->assertSessionHasInput('type', $incident->type);
        $response->assertSessionHasInput('status', $incident->status);
    }
}
