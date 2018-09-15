<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectGalleryController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function destroy(Project $project, ProjectGallery $projectGallery) {
        Storage::delete($projectGallery->file_uri);
        $projectGallery->delete();
        return response([], 204);
    }
}
