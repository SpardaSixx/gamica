<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Gyros;
use App\Models\Game;

class GyrosController extends Controller
{
    /**
     * Show the gyros counter.
    *
    * @return \Illuminate\View\View
    */
    public function index()
    {
        $user = Auth::id();
        $counter = Gyros::find(1)->counter;

        return view('gyros', [
            'counter' => $counter,
            'user' => $user
        ]);
    }

    /**
     * Increment the gyros counter by one.
    *
    * @return \Illuminate\View\View
    */
    public function increment()
    {
        if(Auth::id() == 28){
            $counter = Gyros::find(1);
            $counter->counter++;
            $counter->save();
    
            return redirect(route('gyros-counter'))->with('message', 'Ügyes vagy!');
        } else{
            return redirect(route('gyros-counter'))->with('message', 'Te itt nem Gyros-ozol!');
        }
        
    }
}
