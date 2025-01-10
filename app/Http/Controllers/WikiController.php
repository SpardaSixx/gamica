<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class WikiController extends Controller
{
    /**
     * Show the wiki page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    { 
        return view('wiki', [
        ]);
    }

    public function setRead($id){
        $user = User::find($id);
        $user->read_wiki = 1;
        $user->save();

        return redirect('/')->with('message', 'Köszönjük a megerősítést!');
    }
}
