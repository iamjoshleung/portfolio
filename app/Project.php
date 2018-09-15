<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use \Conner\Tagging\Taggable;

    protected $guarded = [];

    protected $with = ['gallery', 'tagged'];

    protected $appends = ['tags'];

    /**
     * 
     * 
     * @return 
     */
    public function gallery() {
        return $this->hasMany(ProjectGallery::class);
    }

    /**
     * 
     * 
     * @return 
     */
    public function getTagsAttribute() {
        return $this->tagNames();
    }
}
