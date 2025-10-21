<?php

namespace Tests\Feature;

use App\Models\RecordCategory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecordCategoryTest extends TestCase
{
    public function test_get_list_records_category()
    {
        $response = $this->get('/api/record_categories', [
            'direction' => 'desc',
            'column' => 'name',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'data' => []
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_create_record_category(): void
    {
        $response = $this->postJson('/api/record_categories', [
            'name' => 'test',
            'type' => 'incoming',
        ]);
        $response->assertStatus(200);
        $this->assertNotNull(RecordCategory::latest()->first());

        $response = $this->postJson('/api/record_categories', [
            'name' => 'aaaaaaaaaa',
            'type' => 'aaaaaaaaaa',
        ]);
        $response->assertStatus(422);
    }

    public function test_update_record_category(): void
    {
        $id = RecordCategory::latest('id')->value('id');
        $response = $this->putJson('/api/record_categories/' . $id, [
            'id' => $id,
            'name' => 'test1',
            'type' => 'outgoing',
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_record_category(): void
    {
        $id = RecordCategory::latest()->value('id');
        $response = $this->deleteJson('/api/record_categories/' . $id);

        $response->assertStatus(200);
    }
}
