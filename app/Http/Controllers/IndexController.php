<?php
 
namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Game;
use App\Models\Series;
use App\Models\Sale;
use App\Models\Console;
use App\Models\Accessory;
use App\Models\Pack;
use App\Models\Wanted;
use App\Models\Platform;
use App\Models\Highlight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    /**
     * Show the index page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function index()
    {        
        $sales = Sale::where('deleted', 0)->orderBy('is_sold', 'asc')->orderBy('created_at', 'desc')->limit(10)->get();
        $consoles = Console::where('deleted', 0)->orderBy('is_sold', 'asc')->orderBy('created_at', 'desc')->limit(10)->get();
        $accessories = Accessory::where('deleted', 0)->orderBy('is_sold', 'asc')->orderBy('created_at', 'desc')->limit(10)->get();
        $packs = Pack::where('deleted', 0)->orderBy('is_sold', 'asc')->orderBy('created_at', 'desc')->limit(10)->get();
        $wanteds = Wanted::where('deleted', 0)->orderBy('is_found', 'asc')->orderBy('created_at', 'desc')->limit(10)->get();
        $games = Game::where('deleted', 0)->orderBy('created_at', 'desc')->limit(10)->get();
        $series = Series::where('deleted', 0)->orderBy('created_at', 'desc')->limit(10)->get();

        $countSales = Sale::where('deleted', 0)->count();
        $countConsoles = Console::where('deleted', 0)->count();
        $countAccessories = Accessory::where('deleted', 0)->count();
        $countPacks = Pack::where('deleted', 0)->count();
        $countWanteds = Wanted::where('deleted', 0)->count();
        $countGames = Game::where('deleted', 0)->count();
        $countSeries = Series::where('deleted', 0)->count();

        $totalItems = $countSales + $countConsoles + $countAccessories + $countPacks + $countWanteds + $countGames + $countSeries;

        $highlights = Highlight::orderBy('item_order', 'asc')->get();

        return view('index', [
            'sales' => $sales,
            'consoles' => $consoles,
            'accessories' => $accessories,
            'packs' => $packs,
            'wanteds' => $wanteds,
            'games' => $games,
            'series' => $series,
            'totalItems' => $totalItems,
            'highlights' => $highlights
        ]);
    }

    /**
     * Show the search page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $queryCategory = $request->input('query-category');

        $resultSales = Sale::where('deleted', 0)->where('title', 'LIKE', "%{$query}%")->get();
        $resultConsoles = Console::where('deleted', 0)->where('title', 'LIKE', "%{$query}%")->get();
        $resultAccessories = Accessory::where('deleted', 0)->where('title', 'LIKE', "%{$query}%")->get();
        $resultPacks = Pack::where('deleted', 0)->where('title', 'LIKE', "%{$query}%")->get();
        $resultWanteds = Wanted::where('deleted', 0)->where('title', 'LIKE', "%{$query}%")->get();
        $resultGames = Game::where('deleted', 0)->where('title', 'LIKE', "%{$query}%")->get();
        $resultSeries = Series::where('deleted', 0)->where('title', 'LIKE', "%{$query}%")->get();

        $countSales = Sale::where('deleted', 0)->count();
        $countConsoles = Console::where('deleted', 0)->count();
        $countAccessories = Accessory::where('deleted', 0)->count();
        $countPacks = Pack::where('deleted', 0)->count();
        $countWanteds = Wanted::where('deleted', 0)->count();
        $countGames = Game::where('deleted', 0)->count();
        $countSeries = Series::where('deleted', 0)->count();

        $totalItems = $countSales + $countConsoles + $countAccessories + $countPacks + $countWanteds + $countGames + $countSeries;

        return view('search', [
            'resultSales' => $resultSales,
            'resultConsoles' => $resultConsoles,
            'resultAccessories' => $resultAccessories,
            'resultPacks' => $resultPacks,
            'resultWanteds' => $resultWanteds,
            'resultGames' => $resultGames,
            'resultSeries' => $resultSeries,
            'queryCategory' => $queryCategory,
            'totalItems' => $totalItems
        ]);
    }

    /**
     * Show the contact page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function contact(){
        return view('contact', [
            
        ]);
    }

    /**
     * Send the contact email.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function sendContactEmail(Request $request){
        $name = $request->name;
        $email = $request->email;
        $text = $request->text;

        DB::table('contact_messages')->insert([
            'name' => $name,
            'email' => $email,
            'text' => $text
        ]);

        $data = [
            'name' => $name,
            'email' => $email,
            'text' => $text
        ];

        Mail::send(['text'=>'components.mail'], $data, function($message) {
            $message->to('spardasixx@gmail.com', 'Görbicz Roland')->subject('Kapcsolatfelvétel E-mail érkezett');
            $message->from('noreply@gamica.hu', 'Gamica');
        });

        return redirect('/')->with('message', 'Sikeres üzenet!');
    }

    /**
     * Show the op-birthdays page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function birthdays(){
        $users = DB::table('birthdays')->orderBy('month', 'asc')->get();

        return view('op-birthdays', [
            'users' => $users
        ]);
    }
}

