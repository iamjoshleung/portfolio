<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortProjectsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_sort_projects() {
        $this->postJson(route('admin.projects.sort'))->assertStatus(401);
    }

    /** @test */
    public function admin_can_sort_projects() {
        $this->signIn();
        $projects = factory(Project::class, 2)->create()->toArray();

        $projectsReversed = array_reverse($projects);

        $this->postJson(route('admin.projects.sort'), ['projects' => $projectsReversed])
            ->assertStatus(204);

        $this->assertEquals(0, Project::find($projects[1]['id'])->order);
        $this->assertEquals(1, Project::find($projects[0]['id'])->order);
    }
}
