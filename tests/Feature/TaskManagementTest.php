<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskManagementTest extends TestCase
{
    use RefreshDatabase;
    protected function signIn()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        return $user;
    }


    public function testIndex()
    {
        $this->signIn();

        $response = $this->get(route('tasks.index'));

        $response->assertStatus(200);

    }



    public function testStore()
    {
        $this->signIn();

        $taskData = [
            'title' => 'Test Task',
            'description' => 'This is a test post.',
            'completed'=>1
        ];

        $response = $this->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $taskData);
    }


    public function testUpdate()
    {
        $this->signIn();

        $task = Task::factory()->create();
        $updatedData = [
            'title' => 'Update Test Task',
            'description' => 'This is a test post.',
            'completed'=>1
        ];

        $response = $this->put(route('tasks.update', $task->id), $updatedData);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $updatedData);
    }


}
