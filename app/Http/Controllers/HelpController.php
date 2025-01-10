<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\HelpQuestion;
use App\Models\HelpAnswer;
use App\Models\HelpQuestions2Answers;
use App\Models\User;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Show the help page.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        if(Auth::check()){
            if($request->input('orderby')){
                $orderby = $request->input('orderby');
            } else{
                $orderby = 'id';
            }
    
            if($request->input('order')){
                $order = $request->input('order');
            } else{
                $order = 'asc';
            }
    
            $query = helpQuestion::orderby($orderby, $order);
            $helpQuestions = $query->paginate(10);
    
            //dd($helpQuestions->first());
    
            return view('help.index', [
                'helpQuestions' => $helpQuestions
            ]);
        } else{
            return redirect(route('index'))->with('message', 'A segítségkérések megtekintéséhez jelentkezz be!');
        }
    }

    /**
     * Create help.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function create()
    {
        if( Auth::check() )
        {
            return view('help.create', [
            ]);
        } else{
            return redirect('/help')->with('message', 'Segítségkéréshez jelentkezz be!');
        }
    }

    /**
     * Store the profile for a given help.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        if( Auth::check() ){
            $helpQuestion = new HelpQuestion;
 
            $helpQuestion->question = $request->question;
            $helpQuestion->anonymous = $request->input('anonymous') == 'on' ? 1 : 0;
            $helpQuestion->user_id = Auth::id();
    
            $helpQuestion->save();

            $user = User::where('id', $helpQuestion->getUser->id)->first();

            $increment = 10;

            $user->xp_points = $user->xp_points + $increment;
            $user->save();
            $user->setRank();

            return redirect(route('help.index'))->with('message', 'Létrehozás sikeres!');
        } else{
            return redirect(route('help.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given help.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $helpQuestion = HelpQuestion::find($id);

        if( Auth::user()->id == $helpQuestion->getUser->id )
        {
            //$game = Game::find($id);
            $helpQuestion->deleted = 1;
            $helpQuestion->save();

            return redirect(route('help.index'))->with('message', 'Törlés sikeres!');
        } else{
            return redirect(route('help.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Delete the profile for a given help.
     *
     * @param  int  $id
     */
    public function postAnswer(Request $request, $id)
    {
        if( Auth::check() )
        {            
            $helpAnswer = new HelpAnswer;
            $helpAnswer->answer = $request->answer;
            $helpAnswer->anonymous = $request->input('anonymous') == 'on' ? 1 : 0;
            $helpAnswer->user_id = Auth::id();
            $helpAnswer->save();

            $helpQuestion2Answer = new HelpQuestions2Answers;
            $helpQuestion2Answer->question_id = $id;
            $helpQuestion2Answer->answer_id = $helpAnswer->id;
            $helpQuestion2Answer->save();

            return redirect(route('help.index'))->with('message', 'Válasz sikeres!');
        } else{
            return redirect(route('help.index'))->with('message', 'Jogosultsági hiba!');
        }
    }
}
