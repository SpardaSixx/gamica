<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pack;
use App\Models\User;
use App\Models\Feed;
use Illuminate\Http\Request;
use Image;

class PackController extends Controller
{
    /**
     * Show the pack page.
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

        $query = Pack::where('deleted', 0)->orderby($orderby, $order);

        if ($request->filled('title')) {
            $title = $request->input('title');
            $query->where('title', 'LIKE', "%{$title}%");
        }

        if ($request->filled('user_id')) {
            $user_id = $request->input('user_id');
            $query->where('user_id', $user_id);
        }

        if ($request->filled('delivery')) {
            $query->where('delivery', 1);
        }

        $packs = $query->paginate(28);

        $usersIds = Pack::select('user_id')->distinct()->get();
        $users = User::whereIn('id', $usersIds)->get();

        return view('packs.index', [
            'packs' => $packs,
            'users' => $users
        ]);
    }

    /**
     * Show the given pack page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $pack = Pack::find($id);
        $pack->views += 1;
        $pack->save();

        return view('packs.show', [
            'pack' => $pack
        ]);
    }

    /**
     * Create pack.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if( Auth::check() ){

            return view('packs.create', [
            ]);
        } else{
            return redirect('/sales/packs')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store the profile for a given pack.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        if( Auth::check() ){
            $pack = new Pack;
 
            $pack->title = $request->title;
            $pack->description = $request->description;
            $pack->price = $request->price;
            $pack->delivery = $request->delivery == 'on' ? 1 : 0;
            $pack->user_id = Auth::id();

            if( $request->file('image') )
            {
                $pack->has_photo = 1;
            }
    
            $pack->save();

            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                $input['imagename'] = strtolower($pack->id . '_' . str_replace($punctuations, "", $pack->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                //$destinationPath = public_path('/thumbnail');
                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save('img/packs/' . $input['imagename'], 80);
            }

            if( $request->file('images') )
            {
                foreach($request->images as $index => $image){
                    $this->validate($request, [
                        'title' => 'required',
                        'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                    ]);
              
                    $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                    $input['imagename'] = strtolower($pack->id . '_' . str_replace($punctuations, "", $pack->title) . '_' .$index . '.jpg');
                    $input['imagename'] = str_replace(" ", "_", $input['imagename']);
    
                    $img = Image::make($image->path());
                    $img->orientate()->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save('img/packs/' . $input['imagename'], 80);
                }

                $pack->gallery_amount = count($request->file('images'));
            }

            $pack->save();

            $user = User::where('id', $pack->getUser->id)->first();

            $increment = 10;

            $user->xp_points = $user->xp_points + $increment;
            $user->save();
            $user->setRank();

            return redirect('/sales/packs/'.$pack->id)->with('message', 'Létrehozás sikeres!');
        } else{
            return redirect('/sales/packs')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given pack.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $pack = Pack::find($id);

        if( Auth::user()->id == $pack->getUser->id && $pack->is_sold == 0)
        {
            $pack->deleted = 1;
            $pack->save();
            
            return redirect('/sales/packs')->with('message', 'Törlés sikeres!');
        } else{
            return redirect('/sales/packs')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Mark as sold.
     *
     * @param  int  $id
     */
    public function sold($id)
    {
        $pack = Pack::find($id);

        if( Auth::user()->id == $pack->getUser->id )
        {
            $pack->is_sold = 1;
            $pack->save();

            return redirect('/sales/packs/'.$pack->id)->with('message', 'Mentés sikeres!');
        } else{
            return redirect('/sales/packs')->with('message', 'Jogosultsági hiba!');
        }
    }
}