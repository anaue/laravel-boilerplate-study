<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    /**
     * Get all of the collector's users.
     */
    public function users()
    {
        return $this->morphMany('App\User', 'delegation');
    }
    /**
     * Get all of the tags for the collect.
     */
    public function tags()
    {
        return $this->morphToMany('App\Tag', 'taggable');
    }

    protected $fillable = ['name'];
}
