<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = []; // alternative for fillables
    //protected $fillable = ['title'];
    public function user(){
        return $this->belongsTo(User::class); // setting relationship b/w users and posts
    }

    /* Setting up a mutator, we're not got gonna use this function coz we're
        gonna effect the database with all our changes so for limiting our changes
        we will use an accessor instead */
    //     public function setPostImageAttribute($value){

    //        $this->attributes['post_image'] = asset($value);

    // }

    /* an accessor method that will fire when you try to access that property.
     It simply checks if the data inside the database table column starts with the https or http,
     if it does then it means the image is on some site so we are not showing it from our server,
    then it builds the url starting with http.
     Otherwise it just displays it from our storage folder. */
    public function getPostImageAttribute($value)
    {
        if (strpos($value, 'https://') !== false || strpos($value, 'http://') !== false) {
            return $value;
        }
 
        return asset('storage/' . $value);
    }
}
