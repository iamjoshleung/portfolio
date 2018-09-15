<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class SortProjectController extends Controller
{
    /**
     * 
     * 
     * @return 
     */
    public function store() {
        $projectsRaw = request()->get('projects');
        $projects = Project::find(collect($projectsRaw)->pluck('id'));

        foreach($projectsRaw as $key => $pR) {
            foreach($projects as $p) {
                if($p->id == $pR['id']) {
                    $p->update([
                        'order' => $key
                    ]);
                }
            }
        }

        return response([], 204);
    }
}
