<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Sale;
use App\Models\Platform;
use App\Models\Region;
use App\Models\Release;
use App\Models\User;
use App\Models\Language;
use App\Models\Feed;
use Illuminate\Http\Request;
use Image;

class SaleController extends Controller
{
    /**
     * Show the sales page.
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

        $query = Sale::where('deleted', 0)->orderby($orderby, $order);

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

        if ($request->filled('delivery')) {
            $query->where('delivery', 1);
        }

        $sales = $query->paginate(28);
        $platforms = Platform::orderBy('amount', 'desc')->get();
        $regions = Region::orderBy('id')->get();
        $releases = Release::orderBy('id')->get();
        $languages = Language::orderBy('id')->get();

        $usersIds = Sale::select('user_id')->distinct()->get();
        $users = User::whereIn('id', $usersIds)->get();

        return view('sales.index', [
            'sales' => $sales,
            'platforms' => $platforms,
            'regions' => $regions,
            'releases' => $releases,
            'languages' => $languages,
            'users' => $users,
        ]);
    }

    /**
     * Show the given sale page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $sale = Sale::find($id);
        $sale->views += 1;
        $sale->save();

        return view('sales.show', [
            'sale' => $sale
        ]);
    }

    /**
     * Create sale.
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

            return view('sales.create', [
                'platforms' => $platforms,
                'regions' => $regions,
                'releases' => $releases,
                'languages' => $languages
            ]);
        } else{
            return redirect('/sales/games')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store the profile for a given sale.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        if( Auth::check() ){
            $sale = new Sale;
 
            $sale->title = $request->title;
            $sale->release_year = $request->release_year;
            $sale->platform_id = $request->platform_id;
            $sale->serial_number = $request->serial_number;
            $sale->region_id = $request->region_id;
            $sale->release_id = $request->release_id;
            $sale->cover_language_id = $request->cover_language_id;
            $sale->game_language_id = $request->game_language_id;
            $sale->manual = $request->manual == 'on' ? 1 : 0;
            $sale->special_edition = $request->special_edition == 'on' ? 1 : 0;
            $sale->sealed = $request->sealed == 'on' ? 1 : 0;
            $sale->price = $request->price;
            $sale->delivery = $request->delivery == 'on' ? 1 : 0;
            $sale->user_id = Auth::id();

            if( $request->file('image') )
            {
                $sale->has_photo = 1;
            }
    
            $sale->save();

            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                $input['imagename'] = strtolower($sale->id . '_' . str_replace($punctuations, "", $sale->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('img/sales/' . $input['imagename'], 80);
            }

            if( $request->file('images') )
            {
                foreach($request->images as $index => $image){
                    $this->validate($request, [
                        'title' => 'required',
                        'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                    ]);
              
                    $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                    $input['imagename'] = strtolower($sale->id . '_' . str_replace($punctuations, "", $sale->title) . '_' .$index . '.jpg');
                    $input['imagename'] = str_replace(" ", "_", $input['imagename']);
    
                    $img = Image::make($image->path());
                    $img->orientate()->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save('img/sales/' . $input['imagename'], 80);
                }

                $sale->gallery_amount = count($request->file('images'));
            }

            $sale->save();

            $user = User::where('id', $sale->getUser->id)->first();

            $increment = 10;
            if($sale->sealed){
                $increment += 5;
            }
            if($sale->special_edition){
                $increment += 5;
            }

            $user->xp_points = $user->xp_points + $increment;
            $user->save();
            $user->setRank();

            return redirect('/sales/games/'.$sale->id)->with('message', 'Létrehozás sikeres!');
        } else{
            return redirect('/sales/games')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given sale.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);

        if( Auth::user()->id == $sale->getUser->id && $sale->is_sold == 0)
        {
            $sale->deleted = 1;
            $sale->save();
            
            return redirect('/sales/games')->with('message', 'Törlés sikeres!');
        } else{
            return redirect('/sales/games')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Mark as sold.
     *
     * @param  int  $id
     */
    public function sold($id)
    {
        $sale = Sale::find($id);

        if( Auth::user()->id == $sale->getUser->id )
        {
            $sale->is_sold = 1;
            $sale->save();

            return redirect('/sales/games/'.$sale->id)->with('message', 'Mentés sikeres!');
        } else{
            return redirect('/sales/games')->with('message', 'Jogosultsági hiba!');
        }
    }
}