<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['taggable'];
    
    /**
     * Get all of the posts that are assigned this tag.
     */

    public function collectors()
    {
        return $this->morphedByMany('App\Collector', 'taggable');
    }

}
