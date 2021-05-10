<?php

namespace Tests\Unit\Services\IncidentService;

use App\Models\Incident;
use App\Services\IncidentService;
use Tests\TestCase;

class ListTest extends TestCase
{
    /**
     * Test list
     *
     * @return void
     */
    public function testList(): void
    {
        $service   = new IncidentService(new Incident());
        $incidents = Incident::factory()
            ->times(3)
            ->create();

        $response = $service->list();
        $items    = collect($response->items());

        $this->assertEquals($response->total(), Incident::count());
        $incidents->each(function ($incident) use ($items) {
            $this->assertContains($incident->id, $items->pluck('id')->all());
            $this->assertContains($incident->title, $items->pluck('title')->all());
            $this->assertContains($incident->description, $items->pluck('description')->all());
        });
    }
}
