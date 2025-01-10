<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Highlight;
use App\Models\Sale;
use App\Models\Console;
use App\Models\Accessory;
use App\Models\Pack;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if(Auth::user()->rank_id == 3){
            $highlightsSales = Highlight::where('item_type', 'games')->get();
            $sales = Sale::where('deleted', 0)->get();

            $highlightsConsoles = Highlight::where('item_type', 'consoles')->get();
            $consoles = Console::where('deleted', 0)->get();

            $highlightsAccessories = Highlight::where('item_type', 'accessories')->get();
            $accessories = Accessory::where('deleted', 0)->get();

            $highlightsPacks = Highlight::where('item_type', 'packs')->get();
            $packs = Pack::where('deleted', 0)->get();

            return view('admin.index', [
                'highlightsSales' => $highlightsSales,
                'sales' => $sales,
                'highlightsConsoles' => $highlightsConsoles,
                'consoles' => $consoles,
                'highlightsAccessories' => $highlightsAccessories,
                'accessories' => $accessories,
                'highlightsPacks' => $highlightsPacks,
                'packs' => $packs
            ]);
        } else{
            return redirect('/')->with('message', 'Jogsultsági hiba!');
        }
        
    }

    /**
     * Store the settings for admin.
     *
     * @param  int  $id
     */
    public function store(Request $request)
    {
        $sales = $request->added_sales;
        $consoles = $request->added_consoles;
        $accessories = $request->added_accessories;
        $packs = $request->added_packs;

        $maxorder = Highlight::select('item_order')->orderBy('item_order', 'desc')->first();
        
        if($sales && count($sales) > 0){
            foreach($sales as $sale){
                $highlightSale = new Highlight;

                $highlightSale->item_id = $sale;
                $highlightSale->item_type = 'games';
                $highlightSale->item_order = $maxorder->item_order +1;
                $highlightSale->save();
            }
        }

        if($consoles && count($consoles) > 0){
            foreach($consoles as $console){
                $highlightConsole = new Highlight;

                $highlightConsole->item_id = $console;
                $highlightConsole->item_type = 'consoles';
                $highlightConsole->item_order = $maxorder->item_order +1;
                $highlightConsole->save();
            }
        }

        if($accessories && count($accessories) > 0){
            foreach($accessories as $accessory){
                $highlightAccessory = new Highlight;

                $highlightAccessory->item_id = $accessory;
                $highlightAccessory->item_type = 'accessories';
                $highlightAccessory->item_order = $maxorder->item_order +1;
                $highlightAccessory->save();
            }
        }

        if($packs && count($packs) > 0){
            foreach($packs as $pack){
                $highlightPack = new Highlight;

                $highlightPack->item_id = $pack;
                $highlightPack->item_type = 'packs';
                $highlightPack->item_order = $maxorder->item_order +1;
                $highlightPack->save();
            }
        }

        return redirect(route('admin.index'))->with('Sikeres mentés!');
    }

    /**
     * Delete the highlight.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        $highlight = Highlight::find($id);

        if( Auth::user()->rank_id == 3 )
        {
            $highlight->delete();

            return redirect(route('admin.index'))->with('message', 'Törlés sikeres!');
        } else{
            return redirect(route('admin.index'))->with('message', 'Jogosultsági hiba!');
        }
    }
}