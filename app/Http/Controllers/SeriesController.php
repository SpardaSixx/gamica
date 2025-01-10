<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Series;
use App\Models\Game;
use App\Models\User;
use App\Models\Feed;
use Illuminate\Http\Request;
use Image;

class SeriesController extends Controller
{
    /**
     * Show the series page.
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
            default:
                $orderby = 'id';
                $order = 'desc';
        }

        $query = Series::where('deleted', 0)->orderby($orderby, $order);

        if ($request->filled('title')) {
            $title = $request->input('title');
            $query->where('title', 'LIKE', "%{$title}%");
        }

        if ($request->filled('user_id')) {
            $user_id = $request->input('user_id');
            $query->where('user_id', $user_id);
        }

        $series = $query->orderBy('id', 'desc')->paginate(28);
        
        $usersIds = Series::select('user_id')->distinct()->get();
        $users = User::whereIn('id', $usersIds)->get();

        return view('series.index', [
            'series' => $series,
            'users' => $users
        ]);
    }

    /**
     * Show the given series page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $series = Series::find($id);
        $series->views += 1;
        $series->save();

        return view('series.show', [
            'series' => $series,
        ]);
    }

    /**
     * Create series.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if( Auth::check() ){
            return view('series.create', [

            ]);
        } else{
            return redirect(route('series.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store the profile for a given collection.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        if( Auth::check() ){
            $series = new Series;
 
            $series->title = $request->title;
            $series->user_id = Auth::id();

            if( $request->file('image') )
            {
                $series->has_photo = 1;
            }

            $series->save();

            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                $input['imagename'] = strtolower($series->id . '_' . str_replace($punctuations, "", $series->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('img/series/' . $input['imagename'], 80);
            }

            $user = User::where('id', $series->getUser->id)->first();
            $increment = 10;
            $user->xp_points = $user->xp_points + $increment;
            $user->save();
            $user->setRank();

            return redirect(route('series.show', $series->id))->with('message', 'Létrehozás sikeres!');
        } else{
            return redirect(route('series.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Edit the given series page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $series = Series::find($id);

        if( Auth::user()->id == $series->getUser->id )
        {            
            $games = Game::where(function ($query) use ($id) {
                $query->where('series_id', '!=', $id)
                      ->orWhere('series_id', null);
            })->where('user_id', Auth::id())->get();

            return view('series.edit', [
                'series' => $series,
                'games' => $games,
            ]);
        } else{
            return redirect(route('series.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

     /**
     * Update the profile for a given series.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        $series = Series::find($id);

        if( Auth::user()->id ==  $series->getUser->id )
        {
            // Old name
            $oldName = $series->getPhotoName();

            $series->title = $request->title;

            if( $request->file('image') )
            {
                $series->has_photo = 1;
            }

            $addedGames = $request->input('added_games');
            if($addedGames){
                foreach($addedGames as $game){
                    $game = Game::where('id', $game)->update(['series_id' => $id]);
                }
            }

            $series->save();

            // New name
            $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
            $imageName = strtolower($series->id . '_' . str_replace($punctuations, '', $series->title) . '.jpg');
            $imageName = str_replace(" ", "_", $imageName);

            // Rename image
            if( file_exists( public_path() . '/img/series/' . $oldName )){
                rename(public_path() . '/img/series/' . $oldName, public_path() . '/img/series/' . $imageName);
            }
            
            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $input['imagename'] = strtolower($series->id . '_' . str_replace($punctuations, "", $series->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('img/series/' . $input['imagename'], 80);
            }

            return redirect(route('series.show', $id))->with('message', 'Frissítés sikeres!');
        } else{
            return redirect(route('series.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given series.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $series = Series::find($id);

        if( Auth::user()->id == $series->getUser->id )
        {
            $series->deleted = 1;
            $series->save();
            
            return redirect(route('series.index'))->with('message', 'Törlés sikeres!');
        } else{
            return redirect(route('series.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the photo for a given series.
     *
     * @param  int  $id
     */
    public function deletePhoto($id)
    {
        $series = Series::find($id);

        if( $series->getUser->id == Auth::id() )
        {
            $imageName = '/img/series/' . $series->getPhotoName();

            if( file_exists( public_path() . $imageName ))
            {
                unlink(public_path() . $imageName);
                $series->has_photo = 0;
                $series->save();

            } else{
                return redirect(route('series.edit', $id))->with('message', 'Nem található kép!');
            }

            return redirect(route('series.edit', $id))->with('message', 'Sikeres törlés!');
        } else{
            return redirect(route('series.index'))->with('message', 'Jogosultsági hiba!');
        }
    }
}
