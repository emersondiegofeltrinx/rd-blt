<?php

namespace Tests\Unit\Services\IncidentService;

use App\Models\Incident;
use App\Services\IncidentService;
use Exception;
use Mockery\MockInterface;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * Test delete
     *
     * @return void
     */
    public function testDelete(): void
    {
        $service  = new IncidentService(new Incident());
        $incident = Incident::factory()->create();
        $response = $service->delete($incident->id);

        $this->assertTrue($response);
        $this->assertDatabaseMissing('incidents', [
            'id' => $incident->id,
        ]);
    }

    /**
     * Test delete with not found record
     *
     * @return void
     */
    public function testDeleteNotFound(): void
    {
        $service  = new IncidentService(new Incident());
        $response = $service->delete(0); // Not found

        $this->assertFalse($response);
    }

    /**
     * Test delete with exception
     *
     * @return void
     */
    public function testDeleteException(): void
    {
        $mock = $this->mock(Incident::class, function (MockInterface $mock) {
            $mock->shouldReceive('delete')->andReturn(new Exception());
        });

        $service  = new IncidentService($mock);
        $incident = Incident::factory()->create();
        $response = $service->delete($incident->id);

        $this->assertFalse($response);
    }
}
