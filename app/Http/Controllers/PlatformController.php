<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Platform;
use App\Models\Company;
use App\Models\Game;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Storage;
use Image;

class PlatformController extends Controller
{
    /**
     * Show the platforms page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Platform::where('deleted', 0)->orderby('title', 'asc');
        $platforms = $query->get();

        return view('platforms.index', [
            'platforms' => $platforms,
        ]);
    }

    /**
     * Show the given platform page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $platform = Platform::find($id);

        return view('platforms.show', [
            'platform' => $platform
        ]);
    }

    /**
     * Create platform.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if( Auth::check() && Auth::user()->rank_id == 3 )
        {
            $companies = Company::orderBy('name')->get();

            return view('platforms.create', [
                'companies' => $companies
            ]);
        } else{
            return redirect('/platforms')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store the profile for a given platform.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        if( Auth::check() && Auth::user()->rank_id == 3 ){
            $platform = new Platform;
 
            $platform->title = $request->title;
            $platform->title_short = $request->title_short;
            $platform->release_year = $request->release_year;
            $platform->company_id = $request->company_id;
            $platform->description = $request->description;

            if( $request->file('image') )
            {
                $platform->has_photo = 1;
            }
    
            $platform->save();

            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
                $input['imagename'] = strtolower($platform->id . '_' . str_replace($punctuations, "", $platform->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('img/platforms/' . $input['imagename'], 80);
            }

            return redirect(route('platforms.show', $platform->id))->with('message', 'Létrehozás sikeres!');
        } else{
            return redirect('/platforms')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Edit the given platform page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {        
        if( Auth::check() && Auth::user()->rank_id == 3 )
        {
            $platform = Platform::findOrFail($id);
            $companies = Company::all();

            return view('platforms.edit', [
                'platform' => $platform,
                'companies' => $companies
            ]);
        } else{
            return redirect('/platforms')->with('message', 'Jogosultsági hiba!');
        }
    }

     /**
     * Update the profile for a given platform.
     *
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        if( Auth::check() && Auth::user()->rank_id ==  3 )
        {
            $platform = Platform::find($id);

            // Old name
            $oldName = $platform->getPhotoName();

            $platform->title = $request->title;
            $platform->title_short = $request->input('title_short');
            $platform->release_year = $request->input('release_year');
            $platform->company_id = $request->input('company_id');
            $platform->description = $request->input('description');

            if( $request->file('image') )
            {
                $platform->has_photo = 1;
            }

            $platform->save();

            // New name
            $punctuations = [',', ';', '.', ':', '-', '_', '"', "'", '/', '?', '#'];
            $imageName = strtolower($platform->id . '_' . str_replace($punctuations, '', $platform->title) . '.jpg');
            $imageName = str_replace(" ", "_", $imageName);

            // Rename image
            if( file_exists( public_path() . '/img/platforms/' . $oldName )){
                rename(public_path() . '/img/platforms/' . $oldName, public_path() . '/img/platforms/' . $imageName);
            }
            
            if( $request->file('image') )
            {
                $this->validate($request, [
                    'title' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
                ]);
          
                $image = $request->file('image');
                $input['imagename'] = strtolower($platform->id . '_' . str_replace($punctuations, "", $platform->title) . '.jpg');
                $input['imagename'] = str_replace(" ", "_", $input['imagename']);

                $img = Image::make($image->path());
                $img->orientate()->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save('img/platforms/' . $input['imagename'], 80);
            }

            return redirect(route('platforms.show', $id))->with('message', 'Frissítés sikeres!');
        } else{
            return redirect('/platforms')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given user.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        if( Auth::check() && Auth::user()->rank_id == 3 )
        {
            $platform = Platform::find($id);
            $platform->deleted = 1;
            $platform->save();
            
            return redirect(route('platforms.index'))->with('message', 'Törlés sikeres!');
        } else{
            return redirect('/platforms')->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the photo for a given user.
     *
     * @param  int  $id
     */
    public function deletePhoto($id)
    {
        if( Auth::check() && Auth::user()->rank_id == 3 )
        {
            $platform = Platform::find($id);

            $imageName = '/img/platforms/' . $platform->getPhotoName();

            if( file_exists( public_path() . $imageName ))
            {
                unlink(public_path() . $imageName);
                $platform->has_photo = 0;
                $platform->save();

            } else{
                return redirect(route('platforms.edit', $id))->with('message', 'Nem található kép!');
            }

            return redirect(route('platforms.edit', $id))->with('message', 'Törlés sikeres!');
        } else{
            return redirect('/platforms')->with('message', 'Jogosultsági hiba!');
        }
    }
}
