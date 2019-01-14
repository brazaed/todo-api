<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{
    
    use WithFaker, RefreshDatabase;

    /** @test */
    public function can_create_a_task()
    {
        

        $attributes = [

            'title' => $word = $this->faker->word,            
            'description' => $description = $this->faker->paragraph
        ];
        
        $response = $this->json('POST', '/api/tasks', $attributes);

        $this->assertDatabaseHas('tasks', $attributes);

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['title', 'description', 'created_at'])
            ->assertJson([                
                'title' => $word,
                'description' => $description
            ]);
    }   

    /**
     * @test
     */
    public function can_see_tasks()
    {

        factory(\App\Task::class, 20)->create();

        $this->json('GET', '/api/tasks')
                ->assertStatus(206)
                ->assertJsonStructure([
                    'data' => [
                        '*' => ['id', 'title', 'description', 'updated_at']
                    ],
                    'links'                      
                ]);

    }

    /**
     * @test
     **/
    public function can_see_one_task()
    {
        factory(\App\Task::class, 20)->create();

        $this->json('GET', '/api/tasks/1')
            ->assertStatus(200)
            ->assertJsonStructure(['title', 'description', 'created_at']);

    }

    /**
     * @test
     */
    public function task_not_found()
    {
        
        $this->json('GET', '/api/tasks/-1')->assertStatus(404);
        $this->json('DELETE', '/api/tasks/-1')->assertStatus(404);

    }

    /**
     * @test
     */
    public function can_update()
    {
        $this->withoutExceptionHandling();

        factory(\App\Task::class, 20)->create();
        
        $response = $this->json('PUT', '/api/tasks/1', [
            'title' =>  'study math',
            'description' => $this->faker->words
        ])->assertStatus(200);
    }   
    
    /**
     * @test
     */
    public function can_delete()
    {
        $this->withoutExceptionHandling();

        factory(\App\Task::class, 20)->create();
        
        $response = $this->json('DELETE', '/api/tasks/1')
            ->assertJson(['message' => 'Task deleted.'])
            ->assertStatus(200);
    }     
}
