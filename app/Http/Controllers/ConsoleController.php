<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Console;
use App\Models\Company;
use App\Models\Region;
use App\Models\User;
use App\Models\Feed;
use Illuminate\Http\Request;
use Image;

class ConsoleController extends Controller
{
    /**
     * Show the consoles page.
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

        $query = Console::where('deleted', 0)->orderby($orderby, $order);

        if ($request->filled('title')) {
            $title = $request->input('title');
            $query->where('title', 'LIKE', "%{$title}%");
        }

        if ($request->filled('company_id')) {
            $company_id = $request->input('company_id');
            $query->where('company_id', $company_id);
        }

        if ($request->filled('region_id')) {
            $region_id = $request->input('region_id');
            $query->where('region_id', $region_id);
        }

        if ($request->filled('version')) {
            $version = $request->input('version');
            $query->where('version', 'LIKE', "%{$version}%");
        }

        if ($request->filled('user_id')) {
            $user_id = $request->input('user_id');
            $query->where('user_id', $user_id);
        }

        if ($request->filled('special_edition')) {
            $query->where('special_edition', 1);
        }

        if ($request->filled('sealed')) {
            $query->where('sealed', 1);
        }

        if ($request->filled('box')) {
            $query->where('box', 1);
        }

        if ($request->filled('papers')) {
            $query->where('papers', 1);
        }

        if ($request->filled('delivery')) {
            $query->where('delivery', 1);
        }

        $consoles = $query->paginate(28);
        $regions = Region::orderBy('id')->get();
        $companies = Company::orderBy('id')->get();

        $usersIds = Console::select('user_id')->distinct()->get();
        $users = User::whereIn('id', $usersIds)->get();

        return view('consoles.index', [
            'consoles' => $consoles,
            'regions' => $regions,
            'companies' => $companies,
            'users' => $users
        ]);
    }

    /**
     * Show the given console page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $console = Console::find($id);
        $console->views += 1;
        $console->save();

        return view('consoles.show', [
            'console' => $console
        ]);
    }

    /**
     * Create console.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if( Auth::check() ){
            $regions = Region::all();
            $companies = Company::all();

            return view('consoles.create', [
                'regions' => $regions,
                'companies' => $companies
            ]);
        } else{
            return redirect(route('consoles.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store the profile for a given console.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        if( Auth::check() ){
            $console = new Console;
 
            $console->title = $request->title;
            $console->release_year = $request->release_year;
            $console->company_id = $request->company_id;
            $console->serial_number = $request->serial_number;
            $console->region_id = $request->region_id;
            $console->version = $request->version;
            $console->box = $request->box == 'on' ? 1 : 0;
            $console->papers = $request->papers == 'on' ? 1 : 0;
            $console->special_edition = $request->special_edition == 'on' ? 1 : 0;
            $console->sealed = $request->sealed == 'on' ? 1 : 0;
            $console->price = $request->price;
            $console->delivery = $request->delivery == 'on' ? 1 : 0;
            $console->user_id = Auth::id();

            if( $request->file('image') )
            {
                $console->has_photo = 1;
            }
    
            $console->save();

            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                $input['imagename'] = strtolower($console->id . '_' . str_replace($punctuations, "", $console->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save('img/consoles/' . $input['imagename'], 80);
            }

            if( $request->file('images') )
            {
                foreach($request->images as $index => $image){
                    $this->validate($request, [
                        'title' => 'required',
                        'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                    ]);
              
                    $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                    $input['imagename'] = strtolower($console->id . '_' . str_replace($punctuations, "", $console->title) . '_' .$index . '.jpg');
                    $input['imagename'] = str_replace(" ", "_", $input['imagename']);
    
                    $img = Image::make($image->path());
                    $img->orientate()->resize(800, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save('img/consoles/' . $input['imagename'], 80);
                }

                $console->gallery_amount = count($request->file('images'));
            }

            $console->save();

            $user = User::where('id', $console->getUser->id)->first();

            $increment = 10;
            if($console->sealed){
                $increment += 5;
            }
            if($console->special_edition){
                $increment += 5;
            }

            $user->xp_points = $user->xp_points + $increment;
            $user->save();
            $user->setRank();

            return redirect(route('consoles.show', $console->id))->with('message', 'Létrehozás sikeres!');
        } else{
            return redirect(route('consoles.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given console.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $console = Console::find($id);

        if( Auth::user()->id == $console->getUser->id && $console->is_sold == 0)
        {
            $console->deleted = 1;
            $console->save();
            
            return redirect(route('consoles.index'))->with('message', 'Törlés sikeres!');
        } else{
            return redirect(route('consoles.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Mark as sold.
     *
     * @param  int  $id
     */
    public function sold($id)
    {
        $console = Console::find($id);

        if( Auth::user()->id == $console->getUser->id )
        {
            $console->is_sold = 1;
            $console->save();

            return redirect(route('consoles.show', $console->id))->with('message', 'Mentés sikeres!');
        } else{
            return redirect(route('consoles.index'))->with('message', 'Jogosultsági hiba!');
        }
    }
}