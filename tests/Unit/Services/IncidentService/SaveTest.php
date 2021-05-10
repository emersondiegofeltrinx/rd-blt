<?php

namespace Tests\Unit\Services\IncidentService;

use App\Models\Incident;
use App\Services\IncidentService;
use Exception;
use Mockery\MockInterface;
use Tests\TestCase;

class SaveTest extends TestCase
{
    /**
     * Test save
     *
     * @return void
     */
    public function testSave(): void
    {
        $service  = new IncidentService(new Incident());
        $incident = Incident::factory()->make();
        $response = $service->save(
            $incident->title,
            $incident->description,
            $incident->criticality,
            $incident->type,
            $incident->status
        );

        $this->assertTrue($response);
        $this->assertDatabaseHas('incidents', [
            'title'       => $incident->title,
            'description' => $incident->description,
            'criticality' => $incident->criticality,
            'type'        => $incident->type,
            'status'      => $incident->status,
        ]);
    }

    /**
     * Test save with exception
     *
     * @return void
     */
    public function testSaveException(): void
    {
        $mock = $this->mock(Incident::class, function (MockInterface $mock) {
            $mock->shouldReceive('save')->andReturn(new Exception());
        });

        $service  = new IncidentService($mock);
        $incident = Incident::factory()->make();
        $response = $service->save(
            $incident->title,
            $incident->description,
            $incident->criticality,
            $incident->type,
            $incident->status
        );

        $this->assertFalse($response);
    }
}
