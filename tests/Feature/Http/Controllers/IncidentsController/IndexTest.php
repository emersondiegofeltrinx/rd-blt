<?php

namespace Tests\Feature\Http\Controllers\IncidentsController;

use App\Models\Incident;
use Illuminate\Support\Arr;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /**
     * Test index
     *
     * @return void
     */
    public function testIndex(): void
    {
        $incidents = Incident::factory()
            ->times(3)
            ->create();

        $response = $this->get(route('incidents.index'));

        $response->assertViewHas('incidents');

        $data  = $response->getOriginalContent()->getData();
        $items = collect($data['incidents']->items());

        $incidents->each(function ($incident) use ($items) {
            $this->assertContains($incident->id, $items->pluck('id')->all());
            $this->assertContains($incident->title, $items->pluck('title')->all());
            $this->assertContains($incident->description, $items->pluck('description')->all());
        });
    }
}
