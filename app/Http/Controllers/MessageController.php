<?php
 
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Sale;
use App\Models\Console;
use App\Models\Accessory;
use App\Models\Pack;
use App\Models\Wanted;
use Illuminate\Support\Facades\Mail;
use Validator,Redirect,Response;

class MessageController extends Controller
{
    /**
     * Show the messages page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if( Auth::check() ){
            $messages = Message::where('from_id', Auth::id())->orWhere('to_id', Auth::id())->get();

            $partners = [];
            foreach($messages as $message){
                if($message->from_id == Auth::id()){
                    array_push($partners, $message->to_id);
                }

                if($message->to_id == Auth::id()){
                    array_push($partners, $message->from_id);
                }
            }

            $partners = User::whereIn('id', array_unique($partners))->get();
            //$in = Message::where('to_id', Auth::id())->orderBy('id', 'desc')->get();
            //$out = Message::where('from_id', Auth::id())->orderBy('id', 'desc')->get();
    
            /* $inGroup = $in->groupBy(function($data) {
                return $data->from_id;
            }); */
    
            /* $outGroup = $out->groupBy(function($data) {
                return $data->to_id;
            }); */
    
            return view('messages.index', [
                'partners' => $partners->reverse()
                //'inGroup' => $inGroup,
                //'outGroup' => $outGroup
            ]);
        } else{
            return redirect(route('index'))->with('message', 'Az üzeneteid megtekintéséhez jelentkezz be!');
        }
    }

    /**
     * Show the given message page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $messages = Message::where('from_id', Auth::id())->where('to_id', $id)
            ->orWhere('from_id', $id)->where('to_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        foreach($messages as $message){
            if($message->to_id == Auth::id() && $message->is_read == 0){
                $message->is_read = 1;
                $message->save();
            }
        }

        $partner = User::find($id);

        return view('messages.show', [
            'partner' => $partner,
            'messages' => $messages
        ]);
    }

    /**
     * Store message.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        if( Auth::check() ){
            $message = new Message;
 
            $message->from_id = Auth::id();
            $message->to_id = $request->to;
            $message->message = $request->message;
            $message->is_read = 0;
            $message->subject_type = $request->subject_type != null ? $request->subject_type : null;
            $message->item_id = $request->item_id != null ? $request->item_id : null;
            
            $message->save();

            //send mail
            $to = User::find($message->to_id);
            $from = User::find($message->from_id);

            $data = [
                'to' => $to->username,
                'from' => $from->username,
                'url' => 'https://gamica.hu/messages'
            ];

            $toEmail = $to->email;
            $toName = $to->username;

            Mail::send('components.notification', $data, function($message) use ($toEmail, $toName)
            {   
                $message->from('noreply@gamica.hu', 'Gamica');
                $message->to($toEmail, $toName)->subject('Új üzenet');
            });

            return redirect(route('messages.index'))->with('message', 'Üzenet elküldve!')->with('openChat', $request->to);
        } else{
            return redirect(route('messages.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store message.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function storeAjax(Request $request)
    {
        if( Auth::check() ){
            $message = new Message;
 
            $message->from_id = Auth::id();
            $message->to_id = $request->to_id;
            $message->message = $request->message;
            $message->is_read = 0;
            $message->subject_type = $request->subject_type != null ? $request->subject_type : null;
            $message->item_id = $request->item_id != null ? $request->item_id : null;
            
            $message->save();

            return response()->json(['success' => 'Üzenet elküldve']);
        } else{
            return redirect(route('messages.index'))->with('message', 'Jogosultsági hiba!');
        }
    }

    /**
     * Store buy intent.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function buy($type, $id)
    {
        //return abort(500);

        if( Auth::check() ){
            switch ($type) { //game, console, accessory, pack
                case 3:
                    $item = Accessory::find($id);
                    $url = 'accessories';
                    break;
                case 2:
                    $item = Console::find($id);
                    $url = 'consoles';
                    break;
                case 1:
                    $item = Sale::find($id);
                    $url = 'games';
                    break;
                case 4:
                    $item = Pack::find($id);
                    $url = 'packs';
                    break;
                default:
                    $item = null;
            }

            return view('messages.buy', [
                'type' => $type,
                'item' => $item,
                'url' => $url
            ]);
        } else{
            return redirect(route('sales.index'))->with('message', 'Jogosultsági hiba!');
        }
        
    }

    /**
     * Store offer intent.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function offer($id)
    {
        if( Auth::check() ){
            $wanted = Wanted::find($id);

            return view('messages.offer', [
                'wanted' => $wanted,
            ]);
        } else{
            return redirect(route('wanteds.index'))->with('message', 'Jogosultsági hiba!');
        }
        
    }

    public function sync($id){
        $message = Message::where('from_id', Auth::id())->where('to_id', $id)
            ->orWhere('from_id', $id)->where('to_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->first();

        return json_encode($message);
    }
}
