<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use App\ProjectGallery;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SortGalleryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_sort_gallery()
    {
        $this->postJson(route('admin.project.gallery.update', 1))->assertStatus(401);
    }

    /** @test */
    public function admin_can_sort_the_gallery_of_a_project()
    {
        $this->signIn();
        $project = factory(Project::class)->create();
        $gallery = factory(ProjectGallery::class, 3)->create([
            'project_id' => $project->id
        ])->toArray();

        $galleryReversed = array_reverse($gallery);
        
        $this->postJson(route('admin.project.gallery.update', $project), ['gallery' => $galleryReversed])
            ->assertStatus(204);

        $this->assertEquals(0, ProjectGallery::find($gallery[2]['id'])->order);
        $this->assertEquals(1, ProjectGallery::find($gallery[1]['id'])->order);
        $this->assertEquals(2, ProjectGallery::find($gallery[0]['id'])->order);
    }
}
