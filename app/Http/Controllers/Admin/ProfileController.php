<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Profiles;
use Carbon\Carbon;
use App\Profile_History;

class ProfileController extends Controller
{
     public function add()
    {
        return view('admin.profile.create');
    }

    public function create(Request $request)
    {
        $this->validate($request, Profiles::$rules);

        $profiles = new Profiles;
        $form = $request->all();
        $profiles->fill($form);
        $profiles->save();
        
        return redirect('admin/profile/create');
    }

    public function edit(Request $request)
    {
        $profiles = Profiles::find($request->id);
        if (empty($profiles)) {
        abort(404);    
        }
        return view('admin.profile.edit', ['profiles_form' => $profiles]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Profiles::$rules);
        
        $profiles = Profiles::find($request->id);
        
        $profiles_form = $request->all();
        
        $profiles->fill($profiles_form)->save();
        
        $profile_history = new Profile_History;
        $profile_history->profiles_id = $profiles->id;
        $profile_history->edited_at = Carbon::now();
        $profile_history->save();
        
        return redirect('admin/profile/');
    }
    
    public function index(Request $request)
  {
      $cond_title = $request->cond_title;
      if ($cond_title != '') {
          $posts = Profiles::where('title', $cond_title)->get();
      } else {
          $posts = Profiles::all();
      }
      return view('admin.profile.index', ['posts' => $posts, 'cond_title' => $cond_title]);
  }
  
        public function delete(Request $request)
  {
      $profiles = Profiles::find($request->id);
      // 削除する
      $profiles->delete();
      return redirect('admin/profile/');
  }  
}
