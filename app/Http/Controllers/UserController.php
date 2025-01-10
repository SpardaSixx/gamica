<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\City;
use App\Models\Rank;
use App\Models\Collection;
use App\Models\Game;
use Illuminate\Http\Request;
use Image;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Show the users page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if(Auth::check()){
            switch ($request->input('orderby')) {
                case "username_asc":
                    $orderby = 'username';
                    $order = 'asc';
                    break;
                case "username_desc":
                    $orderby = 'username';
                    $order = 'desc';
                    break;
                case "xp_asc":
                    $orderby = 'xp_points';
                    $order = 'asc';
                    break;
                case "xp_desc":
                    $orderby = 'xp_points';
                    $order = 'desc';
                    break;
                default:
                    $orderby = 'xp_points';
                    $order = 'desc';
            }
    
            $query = User::where('deleted', 0)->orderby($orderby, $order);
    
            if ($request->filled('name')) {
                $username = $request->input('name');
                $query->where('username', 'LIKE', "%{$username}%");
            }
    
            if ($request->filled('city_id')) {
                $city_id = $request->input('city_id');
                $query->where('city_id', $city_id);
            }
    
            if ($request->filled('rank_id')) {
                $rank_id = $request->input('rank_id');
                $query->where('rank_id', $rank_id);
            }
    
            $user_cities = User::select('city_id')->get();
            $cities_array = [];
            foreach($user_cities as $city){
                array_push($cities_array, $city->city_id);
            }
    
            $users = $query->paginate(20);
            $cities = City::whereIn('id', $cities_array)->orderBy('name', 'asc')->get();
            $ranks = Rank::orderBy('id')->get();
    
            return view('users.index', [
                'users' => $users,
                'cities' => $cities,
                'ranks' => $ranks
            ]);
        } else{
            return redirect(route('index'))->with('message', 'A tagok megtekintéséhez jelentkezz be!');
        }
    }

    /**
     * Show the given user page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::find($id);

        if($user->deleted){
            return redirect(route('users.index', $id))->with('message', 'Törölt felhasználó!');
        }

        return view('users.show', [
            'user' => $user
        ]);
        
    }

    /**
     * Edit the given user page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if( Auth::user()->id == $id )
        {
            $user = User::findOrFail($id);
            $cities = City::orderBy('name', 'asc')->get();

            return view('users.edit', [
                'user' => $user,
                'cities' => $cities
            ]);
        } else{
            return redirect(route('users.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

     /**
     * Update the profile for a given user.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        if( Auth::user()->id == $id )
        {
            $password = $request->input('password');
            $repassword = $request->input('repassword');

            if( $password == $repassword )
            {
                $user = User::find($id);

                // Old name
                $oldName = strtolower($user->id . '_' . $user->username . '.jpg');
                $oldName = str_replace(" ", "_", $oldName);

                // Update user
                if( strlen($password) > 0 )
                {
                    $user->password = Hash::make($request->input('password'));
                }
                $user->default_language = $request->input('default_language');
                $user->username = $request->input('username');
                $user->email = $request->input('email');
                $user->fb_profile = $request->input('fb_profile');
                $user->ig_profile = $request->input('ig_profile');
                $user->city_id = $request->input('city_id');
                if( $request->file('image') )
                {
                    $user->has_photo = 1;
                }
    
                $user->save();

                // New name
                $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                $imageName = strtolower($user->id . '_' . str_replace($punctuations, '', $user->username) . '.jpg');
                $imageName = str_replace(" ", "_", $imageName);

                // Rename image
                if( file_exists( public_path() . '/img/users/' . $oldName )){
                    rename(public_path() . '/img/users/' . $oldName, public_path() . '/img/users/' . $imageName);
                }
                
                if( $request->file('image') )
                {
                    /* $this->validate($request, [
                        'title' => 'required',
                        'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                    ]); */
            
                    $image = $request->file('image');
                    $input['imagename'] = strtolower($user->id . '_' . str_replace($punctuations, "", $user->username) . '.jpg');
                    $input['imagename'] = str_replace(" ", "_", $input['imagename']);
                    
                    $img = Image::make($image->path());
                    $img->orientate()->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save('img/users/' . $input['imagename'], 80);
                }

                if(!$user->read_wiki){
                    return redirect(route('general-wiki'));
                } else{
                    return redirect(route('users.show', $id))->with('message', 'Frissítés sikeres!');
                }
            } else{
                return redirect(route('users.edit', $id))->with('message', 'Nem egyeznek a jelszavak!');
            }
        } else{
            return redirect(route('users.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given user.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        if( Auth::user()->id == $id )
        {
            $user = User::find($id);
            $user->update([
                'username' => 'Törölt felhasználó',
                'email' => Hash::make($user->email),
                'fb_profile' => null,
                'ig_profile' => null,
                'xp_points' => 0,
                'rank_id' => 20,
                'city_id' => 3154,
                'has_photo' => 0,
                'deleted' => 1,
                'email_verified_at' => null,
                'last_login' => null
            ]);

            Auth::guard('web')->logout();

            return redirect('/')->with('message', 'Törlés sikeres!');
        } else{
            return redirect(route('users.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the photo for a given user.
     *
     * @param  int  $id
     */
    public function deletePhoto($id)
    {
        $user = User::find($id);

        if( $user->id == Auth::id() )
        {
            $imageName = '/img/users/' . $user->getPhotoName();

            if( file_exists( public_path() . $imageName ))
            {
                unlink(public_path() . $imageName);
                $user->has_photo = 0;
                $user->save();

            } else{
                return redirect(route('users.edit', $id))->with('message', 'Nem található kép!');
            }

            return redirect(route('users.edit', $id))->with('message', 'Törlés sikeres!');
        } else{
            return redirect(route('users.index'))->with('message', 'Jogosultsági hiba!');
        }
    }
}
