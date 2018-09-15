<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditProjectsTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function admin_can_remove_a_project_photo()
    {
        
        $numOfPhotos = 2;
        $res = $this->createProject($numOfPhotos);
        
        $res->assertStatus(201);

        $project = $res->json();

        Storage::disk('public')->assertExists('projects/1.jpg');
        Storage::disk('public')->assertExists('projects/2.jpg');

        $this->deleteJson("/admin/projects/{$project['id']}/gallery/1")
            ->assertStatus(204);

        Storage::disk('public')->assertMissing('projects/1.jpg');
        $this->assertCount(1, Project::first()->gallery);
    }

    /** @test */
    public function guests_cannot_remove_a_project_photo() {
        $this->deleteJson("/admin/projects/1/gallery/1")
            ->assertStatus(401);
    }


    /** @test */
    public function admin_can_modify_a_project() {
       
        $numOfPhotos = 1;
        $project = $this->createProject($numOfPhotos)->json();

        $this->patchJson("/admin/projects/{$project['id']}", [
            'type' => 'commercial',
            'name' => 'Another name',
            'subtitle' => 'Some subtitle',
            'tags' => ['PHP', 'Vue', 'JS'],
            'finished_at' => '2018-04-05',
            'files' => [
                UploadedFile::fake()->image('2.jpg'),
            ],
        ])->assertStatus(200);

        tap(Project::first(), function($project) {
            $this->assertEquals('Another name', $project->name);
            $this->assertCount(2, $project->gallery);
            Storage::disk('public')->assertExists('projects/1.jpg');
            Storage::disk('public')->assertExists('projects/2.jpg');
            $this->assertCount(3, $project->tagged);
            $this->assertContains('Php', $project->tags);
            $this->assertContains('Vue', $project->tags);
            $this->assertContains('Js', $project->tags);
        });
    }

    /** @test */
    public function guests_cannot_update_projects() {
        $this->patchJson("/admin/projects/1}")->assertStatus(401);
    }

    protected function createProject(int $numOfPhotos) {
        Storage::fake('public');

        $this->signIn();

        $files = [];

        for($i = 1; $i <= $numOfPhotos; $i++) {
            $files[] = UploadedFile::fake()->image("{$i}.jpg");
        }

        $data = [
            'type' => 'commercial',
            'name' => 'Some name',
            'subtitle' => 'Some subtitle',
            'finished_at' => '2018-05-01',
            'desc' => 'Some desc...',
            'github_url' => 'http://github.com/myrepo',
            'live_site_url' => 'http://mywebsite.com',
            'files' => $files,
            'tags' => ['PHP', 'Vue']
        ];

        return $this->postJson(route('admin.projects.store'), $data);
    }
}
