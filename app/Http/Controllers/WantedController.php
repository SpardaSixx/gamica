<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Wanted;
use App\Models\Platform;
use App\Models\Region;
use App\Models\Release;
use App\Models\User;
use App\Models\Language;
use App\Models\County;
use App\Models\Feed;
use Illuminate\Http\Request;
use Image;

class WantedController extends Controller
{
    /**
     * Show the wanteds page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        switch ($request->input('orderby')) {
            case "title_asc":
                $orderby = 'title';
                $order = 'asc';
                break;
            case "title_desc":
                $orderby = 'title';
                $order = 'desc';
                break;
            case "price_asc":
                $orderby = 'price';
                $order = 'asc';
                break;
            case "price_desc":
                $orderby = 'price';
                $order = 'desc';
                break;
            default:
                $orderby = 'id';
                $order = 'desc';
        }

        $query = Wanted::where('deleted', 0)->orderby($orderby, $order);

        if ($request->filled('title')) {
            $title = $request->input('title');
            $query->where('title', 'LIKE', "%{$title}%");
        }

        if ($request->filled('platform_id')) {
            $platform_id = $request->input('platform_id');
            $query->where('platform_id', $platform_id);
        }

        if ($request->filled('region_id')) {
            $region_id = $request->input('region_id');
            $query->where('region_id', $region_id);
        }

        if ($request->filled('release_id')) {
            $release_id = $request->input('release_id');
            $query->where('release_id', $release_id);
        }

        if ($request->filled('cover_language_id')) {
            $cover_language_id = $request->input('cover_language_id');
            $query->where('cover_language_id', $cover_language_id);
        }

        if ($request->filled('game_language_id')) {
            $game_language_id = $request->input('game_language_id');
            $query->where('game_language_id', $game_language_id);
        }

        if ($request->filled('preferred_area')) {
            $preferred_area = $request->input('preferred_area');
            $query->where('preferred_area', $preferred_area);
        }

        if ($request->filled('user_id')) {
            $user_id = $request->input('user_id');
            $query->where('user_id', $user_id);
        }

        if ($request->filled('manual')) {
            $query->where('manual', 1);
        }

        if ($request->filled('special_edition')) {
            $query->where('special_edition', 1);
        }

        if ($request->filled('sealed')) {
            $query->where('sealed', 1);
        }

        if ($request->filled('delivery')) {
            $query->where('delivery', 1);
        }

        if ($request->filled('is_found')) {
            $query->where('is_found', 0);
        }

        $wanteds = $query->paginate(28);
        $platforms = Platform::orderBy('amount', 'desc')->get();
        $regions = Region::orderBy('id')->get();
        $releases = Release::orderBy('id')->get();
        $languages = Language::orderBy('id')->get();
        $counties = County::orderBy('id')->get();
        
        $usersIds = Wanted::select('user_id')->distinct()->get();
        $users = User::whereIn('id', $usersIds)->get();

        return view('wanteds.index', [
            'wanteds' => $wanteds,
            'platforms' => $platforms,
            'regions' => $regions,
            'releases' => $releases,
            'languages' => $languages,
            'counties' => $counties,
            'users' => $users
        ]);
    }

    /**
     * Show the given wanted page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $wanted = Wanted::find($id);

        return view('wanteds.show', [
            'wanted' => $wanted
        ]);
    }

    /**
     * Create wanted.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if( Auth::check() ){
            $platforms = Platform::orderBy('title', 'asc')->get();
            $regions = Region::all();
            $releases = Release::all();
            $languages = Language::orderBy('title', 'asc')->get();
            $counties = County::all();

            return view('wanteds.create', [
                'platforms' => $platforms,
                'regions' => $regions,
                'releases' => $releases,
                'languages' => $languages,
                'counties' => $counties
            ]);
        } else{
            return redirect(route('wanteds.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store the profile for a given wanted.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        if( Auth::check() ){
            $wanted = new Wanted;
 
            $wanted->title = $request->title;
            $wanted->release_year = $request->release_year;
            $wanted->platform_id = $request->platform_id;
            $wanted->serial_number = $request->serial_number;
            $wanted->region_id = $request->region_id;
            $wanted->release_id = $request->release_id;
            $wanted->cover_language_id = $request->cover_language_id;
            $wanted->game_language_id = $request->game_language_id;
            $wanted->manual = $request->manual == 'on' ? 1 : 0;
            $wanted->special_edition = $request->special_edition == 'on' ? 1 : 0;
            $wanted->sealed = $request->sealed == 'on' ? 1 : 0;
            $wanted->price = $request->price;
            $wanted->delivery = $request->delivery == 'on' ? 1 : 0;
            $wanted->preferred_area = $request->preferred_area;
            $wanted->user_id = Auth::id();

            if( $request->file('image') )
            {
                $wanted->has_photo = 1;
            }
    
            $wanted->save();

            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                $input['imagename'] = strtolower($wanted->id . '_' . str_replace($punctuations, "", $wanted->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('img/wanteds/' . $input['imagename'], 80);
            }

            if( $request->file('images') )
            {
                foreach($request->images as $index => $image){
                    $this->validate($request, [
                        'title' => 'required',
                        'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                    ]);
              
                    $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                    $input['imagename'] = strtolower($wanted->id . '_' . str_replace($punctuations, "", $wanted->title) . '_' .$index . '.jpg');
                    $input['imagename'] = str_replace(" ", "_", $input['imagename']);
    
                    $img = Image::make($image->path());
                    $img->orientate()->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save('img/wanteds/' . $input['imagename'], 80);
                }

                $wanted->gallery_amount = count($request->file('images'));
            }

            $wanted->save();

            $user = User::where('id', $wanted->getUser->id)->first();

            $increment = 10;

            $user->xp_points = $user->xp_points + $increment;
            $user->save();
            $user->setRank();

            return redirect(route('wanteds.show', $wanted->id))->with('message', 'Létrehozás sikeres!');
        } else{
            return redirect(route('wanteds.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given wanted.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $wanted = Wanted::find($id);

        if( Auth::user()->id == $wanted->getUser->id && $wanted->is_found == 0)
        {
            $wanted->deleted = 1;
            $wanted->save();
            
            return redirect(route('wanteds.index'))->with('message', 'Törlés sikeres!');
        } else{
            return redirect(route('wanteds.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Mark as found.
     *
     * @param  int  $id
     */
    public function found($id)
    {
        $wanted = Wanted::find($id);

        if( Auth::user()->id == $wanted->getUser->id )
        {
            $wanted->is_found = 1;
            $wanted->save();

            return redirect(route('wanteds.show', $id))->with('message', 'Mentés sikeres!');
        } else{
            return redirect(route('wanteds.index'))->with('message', 'Jogosultsági hiba!');
        }
    }
}