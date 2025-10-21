<?php

namespace Tests\Feature;

use App\Models\Record;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecordTest extends TestCase
{
    public function test_get_list_records()
    {
        $response = $this->get('/api/records', [
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
    public function test_create_record(): void
    {
        $response = $this->postJson('/api/records', [
            'record_category_id' => 1,
            'amount' => 100000,
            'comment' => 'test comment',
            'date' => '2021-01-01',
        ]);
        $response->assertStatus(200);
        $this->assertNotNull(Record::latest()->first());

        $response = $this->postJson('/api/records', [
            'record_category_id' => 'aaaaaaaaaa',
            'amount' => 'aaaaaaaaaa',
            'comment' => 'test comment',
            'date' => '2021-01-01',
        ]);
        $response->assertStatus(422);
    }

    public function test_update_record(): void
    {
        $id = Record::latest('id')->value('id');
        $response = $this->putJson('/api/records/' . 8, [
            'record_category_id' => 1,
            'amount' => 5000,
            'comment' => 'test comment 1',
            'date' => '2021-01-01',
        ]);

        $response->assertStatus(200);
    }

    public function test_delete_record(): void
    {
        $id = Record::where('id', 8)->value('id');
        $response = $this->deleteJson('/api/records/' . $id);

        $response->assertStatus(200);
    }
}
