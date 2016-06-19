<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Collector extends Model
{
    /**
     * Get all of the staff member's photos.
     */
    public function users()
    {
        return $this->morphMany('App\User', 'delegation');
    }

    protected $fillable = ['name'];
}
