<?php

namespace Tests\Unit\Services\IncidentService;

use App\Models\Incident;
use App\Services\IncidentService;
use Exception;
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
        $service     = new IncidentService(new Incident());
        $incidentOld = Incident::factory()->create();
        $incidentNew = Incident::factory()->make();
        $response    = $service->update(
            $incidentOld->id,
            $incidentNew->title,
            $incidentNew->description,
            $incidentNew->criticality,
            $incidentNew->type,
            $incidentNew->status
        );

        $this->assertTrue($response);
        $this->assertDatabaseHas('incidents', [
            'id'          => $incidentOld->id,
            'title'       => $incidentNew->title,
            'description' => $incidentNew->description,
            'criticality' => $incidentNew->criticality,
            'type'        => $incidentNew->type,
            'status'      => $incidentNew->status,
        ]);
    }

    /**
     * Test update with not found record
     *
     * @return void
     */
    public function testUpdateNotFound(): void
    {
        $service  = new IncidentService(new Incident());
        $incident = Incident::factory()->make();
        $response = $service->update(
            0, // Not found
            $incident->title,
            $incident->description,
            $incident->criticality,
            $incident->type,
            $incident->status
        );

        $this->assertFalse($response);
    }

    /**
     * Test update with exception
     *
     * @return void
     */
    public function testUpdateException(): void
    {
        $mock = $this->mock(Incident::class, function (MockInterface $mock) {
            $mock->shouldReceive('update')->andReturn(new Exception());
        });

        $service  = new IncidentService($mock);
        $incident = Incident::factory()->create();
        $response = $service->update(
            $incident->id,
            $incident->title,
            $incident->description,
            $incident->criticality,
            $incident->type,
            $incident->status
        );

        $this->assertFalse($response);
    }
}
