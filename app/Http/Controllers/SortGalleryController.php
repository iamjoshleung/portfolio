<?php

namespace App\Http\Controllers;

use App\Project;
use App\ProjectGallery;
use Illuminate\Http\Request;

class SortGalleryController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function update(Project $project) {
        $galleryRaw = request()->get('gallery');
        $gallery = ProjectGallery::find(collect($galleryRaw)->pluck('id'));

        foreach($galleryRaw as $key => $gR) {
            foreach($gallery as $g) {
                if($g->id == $gR['id']) {
                    $g->update([
                        'order' => $key
                    ]);
                }
            }
        }

        return response([], 204);
    }
}
