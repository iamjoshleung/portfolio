<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function non_admin_cannot_delete_projects() {
        $this->deleteJson(route('admin.projects.destroy', $projectId = 1))->assertStatus(401);
    }

    /** @test */
    public function admin_can_delete_projects() {
        $project = $this->createProject($galleryNum = 2)->json();

        Storage::disk('public')->assertExists('projects/1.jpg');
        Storage::disk('public')->assertExists('projects/2.jpg');
        
        $this->deleteJson(route('admin.projects.destroy', $project['id']))->assertStatus(204);

        $this->assertCount(0, Project::all());

        Storage::disk('public')->assertMissing('projects/1.jpg');
        Storage::disk('public')->assertMissing('projects/2.jpg');
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
