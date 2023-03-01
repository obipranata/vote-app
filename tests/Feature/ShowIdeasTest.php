<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Idea;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_ideas_shows_on_main_page(){
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open',]);
        $statusConsidering = Status::factory()->create(['name' => 'Considering',]);
        $statusInProgress = Status::factory()->create(['name' => 'In Progress', ]);
        $statusImplemented = Status::factory()->create(['name' => 'Implemented', ]);
        $statusClosed = Status::factory()->create(['name' => 'Closed',]);

        $ideaOne = Idea::factory()->create([
            'user_id' => User::factory()->create(['name' => 'Obito', 'email'=>'obito@gmail.com'])->id,
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea'
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => User::factory()->create(['name' => 'Obito', 'email'=>'obito1@gmail.com'])->id,
            'title' => 'My second idea',
            'category_id' => $categoryTwo->id,
            'status_id' => $statusConsidering->id,
            'description' => 'Description of my second idea'
        ]);

        $response = $this->get(route('idea.index'));
        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee($statusConsidering->name);
        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
    }

    /** @test */
    public function single_idea_shows_correctly_on_the_show_page(){
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $statusOpen = Status::factory()->create(['name' => 'Open']);
        $idea = Idea::factory()->create([
            'user_id' => User::factory()->create(['name' => 'Obito', 'email'=>'obito@gmail.com'])->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My first idea',
            'description' => 'Description of my first idea'
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee('Open');
    }

    /** @test */
    public function ideas_pagination_works()
    {
        $ideaOne = Idea::factory()->create();

        Idea::factory($ideaOne->getPerPage())->create();

        $response = $this->get('/');

        $response->assertSee(Idea::find(Idea::count())->title);
        $response->assertDontSee($ideaOne->title);

        $response = $this->get('/?page=2');

        $response->assertDontSee(Idea::find(Idea::count())->title);
        $response->assertSee($ideaOne->title);
    }

    /** @test */
    public function same_idea_title_different_slugs()
    {
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $status = Status::factory()->create(['name' => 'Status 1',]);
        $ideaOne = Idea::factory()->create([
            'user_id' => User::factory()->create(['name' => 'Obito', 'email'=>'obito@gmail.com'])->id,
            'category_id' => $categoryOne->id,
            'status_id' => $status->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $ideaTwo = Idea::factory()->create([
            'user_id' => User::factory()->create(['name' => 'Obito', 'email'=>'obito1@gmail.com'])->id,
            'category_id' => $categoryOne->id,
            'status_id' => $status->id,
            'title' => 'My First Idea',
            'description' => 'Description for my first idea',
        ]);

        $response = $this->get(route('idea.show', $ideaOne));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea');

        $response = $this->get(route('idea.show', $ideaTwo));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea-2');
    }

    /** @test */
    public function in_app_back_button_works_when_index_page_visited_first(){
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open',]);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', ]);
        $statusInProgress = Status::factory()->create(['name' => 'In Progress', ]);
        $statusImplemented = Status::factory()->create(['name' => 'Implemented', ]);
        $statusClosed = Status::factory()->create(['name' => 'Closed', ]);

        $ideaOne = Idea::factory()->create([
            'user_id' => User::factory()->create(['name' => 'Obito', 'email'=>'obito@gmail.com'])->id,
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea'
        ]);

        $response = $this->get('/?category=Category%202&status=Considering');
        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertStringContainsString('/?category=Category%202&status=Considering', $response['backUrl']);
    }

    /** @test */
    public function in_app_back_button_works_when_show_page_only_page_visited(){
        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open',]);
        $statusConsidering = Status::factory()->create(['name' => 'Considering', ]);
        $statusInProgress = Status::factory()->create(['name' => 'In Progress', ]);
        $statusImplemented = Status::factory()->create(['name' => 'Implemented', ]);
        $statusClosed = Status::factory()->create(['name' => 'Closed',]);

        $ideaOne = Idea::factory()->create([
            'user_id' => User::factory()->create(['name' => 'Obito', 'email'=>'obito@gmail.com'])->id,
            'title' => 'My first idea',
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'description' => 'Description of my first idea'
        ]);

        $response = $this->get(route('idea.show', $ideaOne));

        $this->assertEquals(route('idea.index'), $response['backUrl']);
    }
}
