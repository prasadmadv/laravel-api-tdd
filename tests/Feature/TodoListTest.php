<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TodoList;

class TodoListTest extends TestCase
{
    use RefreshDatabase;
    private $list;

    public function setup() : void {
        parent::setup();
        $this->list = TodoList::factory()->create();

    }

    public function test_get_todo_list()
    {
        //prepare

        //perform
        $response = $this->getJson('api/todo-list');

        //predict
        $this->assertEquals(1, count($response->json()));
    }

    public function test_get_single_todo_list(){

        //prepare
        $list = TodoList::factory()->create();

        //perform

        $response = $this->get('api/todo-list/'.$list->id)->assertOk()->json();

        //predicts
        $this->assertEquals($response['name'], $list->name);
    }

    public function test_create_new_todo_list(){

        //prepare
        $data = TodoList::factory()->make()->toArray();
        // $data = [
        //     'name' => 'Laravel TDD practice',
        //     'category' => 'Coding'
        // ];

        //perform
        //create new todo list
        $response = $this->postJson('api/todo-list/',$data)->assertCreated()->json();
        $this->assertEquals($response['name'], $data['name']);
        $this->assertDatabaseHas('todo_lists', ['name' => $data['name']]);

    }


    public function test_validation_create_new_todo_list(){
        //prepare
        $this->withExceptionHandling();
        $response = $this->postJson('api/todo-list',[])->assertUnprocessable();
        $response->assertJsonValidationErrors(['category']);

    }

    public function test_delete_todo_list(){

        //dd($this->list->id);
        $this->deleteJson('api/todo-list/'.$this->list->id)
            ->assertNoContent();

        $this->assertDatabaseMissing('todo_lists',['name' => $this->list->name]);

    }

    public function test_update_todo_list(){
        $this->patchJson('api/todo-list/'.$this->list->id,[
            'name' => 'Nunu Mangola',
        ])->assertOk();

        $this->assertDatabasehas('todo_lists',[
            'id' => $this->list->id,
            'name' => 'Nunu Mangola'
        ]);
    }
}
