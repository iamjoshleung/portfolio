<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function index()
    {
        if( request()->wantsJson() ) {
            return response(Project::all(), 200);
        }
        
        return view('projects.index', ['projects' => Project::all()]);
    }

    /**
     * 
     * 
     * @return 
     */
    public function create()
    {

        return view('projects.create');
    }

    /**
     * 
     * 
     * @return 
     */
    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'subtitle' => ['required'],
            'finished_at' => ['required'],
            'tags' => ['required'],
            'files' => ['required'],
            'type' => ['required'],
        ]);

        $project = Project::create(
            request()->only('name', 'subtitle', 'finished_at', 'desc', 'github_url', 'live_site_url', 'type')
        );

        // attach tags
        foreach (request('tags') as $tag) {
            $project->tag($tag);
        }

        // store files and create ProjectGallery
        $this->saveGallery($project);

        return response($project, 201);
    }

    /**
     * 
     * 
     * @return 
     */
    public function show(Project $project)
    {
        return view('projects.show', ['project' => $project]);
    }

    /**
     * 
     * 
     * @return 
     */
    public function update(Project $project)
    {
        request()->validate([
            'name' => ['required'],
            'subtitle' => ['required'],
            'finished_at' => ['required'],
            'tags' => ['required'],
            'type' => ['required'],
        ]);

        $project->update(
            request()->only('name', 'subtitle', 'finished_at', 'desc', 'github_url', 'live_site_url', 'type')
        );

        $project->retag(request('tags'));

        if (request()->file('files')) {
            $this->saveGallery($project);
        }

        return response($project->fresh(), 200);
    }

    /**
     * 
     * 
     * @return 
     */
    public function destroy(Project $project)
    {
        $project->untag();

        $filenames = collect($project->gallery)->pluck('file_uri')
            ->each(function ($fileUri) {
                Storage::delete($fileUri);
            });

        $project->delete();

        return response([], 204);
    }

    protected function saveGallery(Project $project)
    {
        foreach (request()->file('files') as $file) {
            $path = Storage::putFileAs('projects', $file, $file->getClientOriginalName());
            $project->gallery()->create([
                'file_uri' => $path
            ]);
        }
    }
}
