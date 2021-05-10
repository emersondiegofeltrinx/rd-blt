<?php

namespace Tests\Feature\Http\Controllers\IncidentsController;

use Tests\TestCase;

class CreateTest extends TestCase
{
    /**
     * Test create
     *
     * @return void
     */
    public function testCreate(): void
    {
        $response = $this->get(route('incidents.create'));

        $response->assertViewHas('criticality');
        $response->assertViewHas('type');
        $response->assertViewHas('status');
    }
}
