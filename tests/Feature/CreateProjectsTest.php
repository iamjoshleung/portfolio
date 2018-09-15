<?php

namespace Tests\Feature;

use App\User;
use App\Project;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProjectsTest extends TestCase
{

    use RefreshDatabase;


    /** @test */
    public function guests_cannot_view_projects()
    {
        $this->get(route('admin.projects.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function logged_in_users_can_view_projects()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $this->get(route('admin.projects.index'))
            ->assertStatus(200);
    }

    /** @test */
    public function guests_cannot_create_projects()
    {
        $this->post(route('admin.projects.store'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function data_saved_to_DB_when_data_is_valid()
    {
        Storage::fake('public');

        $this->signIn();

        $data = [
            'type' => 'commercial',
            'name' => 'Some name',
            'subtitle' => 'Some subtitle',
            'finished_at' => '2018-05-01',
            'desc' => 'Some desc...',
            'github_url' => 'http://github.com/myrepo',
            'live_site_url' => 'http://mywebsite.com',
            'files' => [
                UploadedFile::fake()->image('1.jpg'),
                UploadedFile::fake()->image('2.jpg'),
            ],
            'tags' => ['PHP', 'Vue']
        ];

        // dd($this->post(route('admin.projects.store'), $data));
        $this->post(route('admin.projects.store'), $data)
            ->assertStatus(201);

        $this->assertCount(1, Project::all());
        Storage::disk('public')->assertExists('projects/1.jpg');
        Storage::disk('public')->assertExists('projects/2.jpg');
        $this->assertCount(2, Project::first()->tags);
        $this->assertCount(2, Project::first()->gallery);
    }

    /** @test */
    public function invalid_data_will_not_pass_validation() {
        $this->signIn();

        // dd($this->postJson(route('admin.projects.store'))->json());
        $this->postJson(route('admin.projects.store'))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'subtitle', 'finished_at', 'tags']);     
    }


}
