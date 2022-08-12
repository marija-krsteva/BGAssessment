<?php

namespace Tests\Unit;

use App\Http\Resources\ItemResource;
use App\Models\Item;
use Tests\TestCase;

class ItemTest extends TestCase
{

    /**
     * Testing items.index
     *
     * @return void
     */
    public function test_items_index()
    {
        $items = ItemResource::collection(Item::paginate(10))->response()->getData(true)['data'];
        $response = $this->get('/api/items')->json()['data'];

        $this->assertEquals($items, $response);
    }

    /**
     * Testing items.show
     *
     * @return void
     */
    public function test_items_show()
    {
        $resource = new ItemResource(Item::find(1));
        $item = $resource->response()->getData(true);
        $response = $this->get('/api/items/1')->json();

        $this->assertEquals($item, $response);
    }

    /**
     * Testing items.store
     *
     * @return void
     */
    public function test_items_store()
    {
        $response = $this->post('/api/items', ['name' => fake()->word])->json();

        $resource = new ItemResource(Item::latest()->first());
        $item = $resource->response()->getData(true);

        $this->assertEquals($item, $response);
    }

    /**
     * Testing items.update
     *
     * @return void
     */
    public function test_items_update()
    {
        $item = Item::latest()->first();

        $response = $this->put('/api/items/'. $item->id, ['name' => fake()->word])->json();

        $resource = new ItemResource(Item::latest()->first());
        $item = $resource->response()->getData(true);

        $this->assertEquals($item, $response);
    }

    /**
     * Testing items.destroy
     *
     * @return void
     */
    public function test_items_destroy()
    {
        $item = Item::latest()->first();

        $this->delete('/api/items/'. $item->id);
        $this->assertDatabaseMissing('items', ['id' => $item->id]);
    }
}
