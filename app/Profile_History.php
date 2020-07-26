<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile_History extends Model
{
    protected $table = 'profile_histories';
    protected $guarded = array('id');

    public static $rules = array(
        'profiles_id' => 'required',
        'edited_at' => 'required',
    );
    public function profile_histories()
    {
      return $this->hasMany('App\Profile_History');
    }
}
