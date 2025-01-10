<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Region;
use App\Models\Release;
use App\Models\User;
use App\Models\Language;
use App\Models\Series;
use App\Models\Feed;
use App\Models\Games2Likes;
use Illuminate\Http\Request;
use Image;

class GameController extends Controller
{
    /**
     * Show the games page.
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
            case "views_asc":
                $orderby = 'views';
                $order = 'asc';
                break;
            case "views_desc":
                $orderby = 'views';
                $order = 'desc';
                break;
            case "likes_asc":
                $orderby = 'likes';
                $order = 'asc';
                break;
            case "likes_desc":
                $orderby = 'likes';
                $order = 'desc';
                break;
            default:
                $orderby = 'id';
                $order = 'desc';
        }

        $query = Game::where('deleted', 0)->orderby($orderby, $order);


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

        $games = $query->paginate(28);
        $platforms = Platform::orderBy('amount', 'desc')->get();
        $regions = Region::orderBy('id')->get();
        $releases = Release::orderBy('id')->get();
        $languages = Language::orderBy('id')->get();

        $usersIds = Game::select('user_id')->distinct()->get();
        $users = User::whereIn('id', $usersIds)->get();

        return view('games.index', [
            'games' => $games,
            'platforms' => $platforms,
            'regions' => $regions,
            'releases' => $releases,
            'languages' => $languages,
            'users' => $users
        ]);
    }

    /**
     * Show the given user page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $game = Game::find($id);
        $game->views += 1;
        $game->save();

        return view('games.show', [
            'game' => $game
        ]);
    }

    /**
     * Create game.
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
            $series = Series::where('user_id', Auth::user()->id)->get();

            return view('games.create', [
                'platforms' => $platforms,
                'regions' => $regions,
                'releases' => $releases,
                'languages' => $languages,
                'series' => $series,
            ]);
        } else{
            return redirect('/collections/games')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store the profile for a given game.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        if( Auth::check() ){
            $game = new Game;
 
            $game->title = $request->title;
            $game->release_year = $request->release_year;
            $game->platform_id = $request->platform_id;
            $game->serial_number = $request->serial_number;
            $game->region_id = $request->region_id;
            $game->release_id = $request->release_id;
            $game->cover_language_id = $request->cover_language_id;
            $game->game_language_id = $request->game_language_id;
            $game->series_id = $request->series_id;
            $game->manual = $request->manual == 'on' ? 1 : 0;
            $game->special_edition = $request->special_edition == 'on' ? 1 : 0;
            $game->sealed = $request->sealed == 'on' ? 1 : 0;
            $game->user_id = Auth::id();

            if( $request->file('image') )
            {
                $game->has_photo = 1;
            }
    
            $game->save();

            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                $input['imagename'] = strtolower($game->id . '_' . str_replace($punctuations, "", $game->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('img/games/' . $input['imagename'], 80);
            }

            $platformIncrement = Platform::where('id', $game->platform_id)->first();
            $platformIncrement->amount = $platformIncrement->amount +1;
            $platformIncrement->save();

            $user = User::where('id', $game->getUser->id)->first();

            $increment = 10;
            if($game->sealed){
                $increment += 5;
            }
            if($game->special_edition){
                $increment += 5;
            }

            $user->xp_points = $user->xp_points + $increment;
            $user->save();
            $user->setRank();

            return redirect('/collections/games/'.$game->id)->with('message', 'Létrehozás sikeres!');
        } else{
            return redirect('/collections/games')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Edit the given user page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        if( Auth::check() ){
            $game = Game::find($id);
            $platforms = Platform::orderBy('title', 'asc')->get();
            $regions = Region::all();
            $releases = Release::all();
            $languages = Language::orderBy('title', 'asc')->get();
            $series = Series::where('user_id', Auth::user()->id)->get();

            if( Auth::user()->id == $game->getUser->id )
            {
                $game = Game::findOrFail($id);

                return view('games.edit', [
                    'game' => $game,
                    'platforms' => $platforms,
                    'regions' => $regions,
                    'releases' => $releases,
                    'languages' => $languages,
                    'series' => $series,
                ]);
            } else{
                return redirect('/collections/games')->with('message', 'Jogosultsági hiba!');
            }
        } else{
            return redirect('/collections/games')->with('message', 'Jogosultsági hiba!');
        }
    }

     /**
     * Update the profile for a given user.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $game = Game::find($id);

        if( Auth::user()->id ==  $game->getUser->id )
        {
            $game = Game::find($id);

            // Old name
            $oldName = $game->getPhotoName();

            $game->title = $request->title;
            $game->release_year = $request->release_year;
            $game->platform_id = $request->input('platform_id');
            $game->serial_number = $request->input('serial_number');
            $game->region_id = $request->input('region_id');
            $game->release_id = $request->input('release_id');
            $game->cover_language_id = $request->input('cover_language_id');
            $game->game_language_id = $request->input('game_language_id');
            $game->series_id = $request->input('series_id');
            $game->manual = $request->input('manual') == 'on' ? 1 : 0;
            $game->special_edition = $request->input('special_edition') == 'on' ? 1 : 0;
            $game->sealed = $request->input('sealed') == 'on' ? 1 : 0;

            if( $request->file('image') )
            {
                $game->has_photo = 1;
            }

            $game->save();

            // New name
            $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
            $imageName = strtolower($game->id . '_' . str_replace($punctuations, '', $game->title) . '.jpg');
            $imageName = str_replace(" ", "_", $imageName);

            // Rename image
            if( file_exists( public_path() . '/img/games/' . $oldName )){
                rename(public_path() . '/img/games/' . $oldName, public_path() . '/img/games/' . $imageName);
            }
            
            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $input['imagename'] = strtolower($game->id . '_' . str_replace($punctuations, "", $game->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('img/games/' . $input['imagename'], 80);
            }

            return redirect('/collections/games/'.$game->id)->with('message', 'Frissítés sikeres!');
        } else{
            return redirect('/collections/games')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given user.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $game = Game::find($id);

        if( Auth::user()->id == $game->getUser->id )
        {
            $game->deleted = 1;
            $game->save();

            $platformDecrement = Platform::where('id', $game->platform_id)->first();
            $platformDecrement->amount = $platformDecrement->amount -1;
            $platformDecrement->save();

            return redirect('/collections/games')->with('message', 'Törlés sikeres!');
        } else{
            return redirect('/collections/games')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the photo for a given user.
     *
     * @param  int  $id
     */
    public function deletePhoto($id)
    {
        $game = Game::find($id);

        if( $game->getUser->id == Auth::id() )
        {
            $imageName = '/img/games/' . $game->getPhotoName();

            if( file_exists( public_path() . $imageName ))
            {
                unlink(public_path() . $imageName);
                $game->has_photo = 0;
                $game->save();

            } else{
                return redirect('/collections/games/'.$id)->with('message', 'Nem található kép!');
            }

            return redirect('/collections/games/'.$id.'/edit')->with('message', 'Törlés sikeres!');
        } else{
            return redirect('/collections/games')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Increment likes when pressed.
     *
     * @param  int  $id
     */
    public function countLike($id)
    {
        $game = Game::find($id);
        
        if(Auth::check()){
            $game->likes++;
            $game->save();
    
            $like = new Games2Likes();
            $like->user_id = Auth::id();
            $like->game_id = $id;
            $like->save();
    
            return redirect('/collections/games/'.$game->id);
        } else{
            return redirect('/collections/games/'.$game->id)->with('message', 'A játék lájkolásához jelentkezz be!');
        }
        
    }
}
