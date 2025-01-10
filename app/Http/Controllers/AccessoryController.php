<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Accessory;
use App\Models\Company;
use App\Models\User;
use App\Models\Feed;
use Illuminate\Http\Request;
use Image;

class AccessoryController extends Controller
{
    /**
     * Show the accessories page.
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

        $query = Accessory::where('deleted', 0)->orderby($orderby, $order);

        if ($request->filled('title')) {
            $title = $request->input('title');
            $query->where('title', 'LIKE', "%{$title}%");
        }

        if ($request->filled('company_id')) {
            $company_id = $request->input('company_id');
            $query->where('company_id', $company_id);
        }

        if ($request->filled('user_id')) {
            $user_id = $request->input('user_id');
            $query->where('user_id', $user_id);
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

        $accessories = $query->paginate(28);
        $companies = Company::orderBy('id')->get();

        $usersIds = Accessory::select('user_id')->distinct()->get();
        $users = User::whereIn('id', $usersIds)->get();

        return view('accessories.index', [
            'accessories' => $accessories,
            'companies' => $companies,
            'users' => $users,
        ]);
    }

    /**
     * Show the given accessory page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $accessory = Accessory::find($id);
        $accessory->views += 1;
        $accessory->save();

        return view('accessories.show', [
            'accessory' => $accessory
        ]);
    }

    /**
     * Create accessory.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if( Auth::check() ){
            $companies = Company::all();

            return view('accessories.create', [
                'companies' => $companies
            ]);
        } else{
            return redirect(route('accessories.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store the profile for a given accessory.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        if( Auth::check() ){
            $accessory = new Accessory;
 
            $accessory->title = $request->title;
            $accessory->company_id = $request->company_id;
            $accessory->serial_number = $request->serial_number;
            $accessory->box = $request->box == 'on' ? 1 : 0;
            $accessory->papers = $request->papers == 'on' ? 1 : 0;
            $accessory->sealed = $request->sealed == 'on' ? 1 : 0;
            $accessory->price = $request->price;
            $accessory->delivery = $request->delivery == 'on' ? 1 : 0;
            $accessory->user_id = Auth::id();
            $accessory->is_highlighted = 0;

            if( $request->file('image') )
            {
                $accessory->has_photo = 1;
            }
    
            $accessory->save();

            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                $input['imagename'] = strtolower($accessory->id . '_' . str_replace($punctuations, "", $accessory->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('img/accessories/' . $input['imagename'], 80);
            }

            if( $request->file('images') )
            {
                foreach($request->images as $index => $image){
                    $this->validate($request, [
                        'title' => 'required',
                        'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                    ]);
              
                    $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                    $input['imagename'] = strtolower($accessory->id . '_' . str_replace($punctuations, "", $accessory->title) . '_' .$index . '.jpg');
                    $input['imagename'] = str_replace(" ", "_", $input['imagename']);
    
                    $img = Image::make($image->path());
                    $img->orientate()->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save('img/accessories/' . $input['imagename'], 80);
                }

                $accessory->gallery_amount = count($request->file('images'));
            }

            $accessory->save();

            $user = User::where('id', $accessory->getUser->id)->first();

            $increment = 10;
            if($accessory->sealed){
                $increment += 5;
            }

            $user->xp_points = $user->xp_points + $increment;
            $user->save();
            $user->setRank();

            return redirect(route('accessories.show', $accessory->id))->with('message', 'Létrehozás sikeres!');
        } else{
            return redirect(route('accessories.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given accessory.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $accessory = Accessory::find($id);

        if( Auth::user()->id == $accessory->getUser->id && $accessory->is_sold == 0)
        {
            $accessory->deleted = 1;
            $accessory->save();
            
            return redirect(route('accessories.index'))->with('message', 'Törlés sikeres!');
        } else{
            return redirect(route('accessories.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Mark as sold.
     *
     * @param  int  $id
     */
    public function sold($id)
    {
        $accessory = Accessory::find($id);

        if( Auth::user()->id == $accessory->getUser->id )
        {
            $accessory->is_sold = 1;
            $accessory->save();

            return redirect(route('accessories.show', $accessory->id))->with('message', 'Mentés sikeres!');
        } else{
            return redirect(route('accessories.index'))->with('message', 'Jogosultsági hiba!');
        }
    }
}
