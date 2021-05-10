<?php

namespace Tests\Unit\Services\IncidentService;

use App\Models\Incident;
use App\Services\IncidentService;
use Exception;
use Mockery\MockInterface;
use Tests\TestCase;

class GetTest extends TestCase
{
    /**
     * Test get
     *
     * @return void
     */
    public function testGet(): void
    {
        $service  = new IncidentService(new Incident());
        $incident = Incident::factory()->create();
        $response = $service->get($incident->id);

        $this->assertEquals($incident->id, $response->id);
        $this->assertEquals($incident->title, $response->title);
        $this->assertEquals($incident->description, $response->description);
    }

    /**
     * Test get with not found record
     *
     * @return void
     */
    public function testGetNotFound(): void
    {
        $service  = new IncidentService(new Incident());
        $response = $service->get(0); // Not found

        $this->assertNull($response);
    }

    /**
     * Test get with exception
     *
     * @return void
     */
    public function testGetException(): void
    {
        $mock = $this->mock(Incident::class, function (MockInterface $mock) {
            $mock->shouldReceive('first')->andReturn(new Exception());
        });

        $service  = new IncidentService($mock);
        $incident = Incident::factory()->create();
        $response = $service->get($incident->id);

        $this->assertNull($response);
    }
}
