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

        \Log::info($response->getContent());
        

        $this->assertDatabaseHas('tasks', $attributes);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'title', 'description', 'created_at'
            ])
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
        
        $this->withoutExceptionHandling();


        factory(\App\Task::class, 20)->create();

        $response = $this->json('GET', '/api/tasks')
                     ->assertStatus(200)
                     ->assertJsonStructure([
                        'data' => [
                            '*' => ['id', 'title', 'description', 'updated_at']
                        ],
                        'links'                      
                     ]);

    }

}
