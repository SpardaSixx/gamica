<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use App\Models\Message;
use App\Models\Wanted;
use App\Models\Game;
use App\Models\Sale;
use App\Models\Series;
use App\Models\Console;
use App\Models\Accessory;
use App\Models\Pack;
use App\Models\User;
use App\Models\Platform;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $unreadMessages = Message::where('to_id', Auth::id())
                ->where('is_read', 0)
                ->count();

            View::share('unreadMessages', $unreadMessages);
            View::share('pageTitle', $this->setTitle());
            View::share('ogImage', $this->setOgImage());

            return $next($request);
        });
    }

    public function setTitle(){
        switch (Route::currentRouteName()) {
            // GAMES
            case 'games.index':
                $url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

                if( strpos($url,'collections') !== false ){
                    return 'Gyűjtemény játékok - Gamica';
                } else{
                    return 'Gyűjtemény játékok - Gamica';
                }
                break;
            case 'games.show':
                $url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

                if( strpos($url,'collections') !== false ){
                    $id = basename($_SERVER['REQUEST_URI']);
                    return Game::find($id)->title . ' - Gamica';
                } else{
                    $id = basename($_SERVER['REQUEST_URI']);
                    return Sale::find($id)->title . ' - Gamica';
                }
                break;
            // SERIES
            case 'series.index':
                return 'Gyűjtemény sorozatok - Gamica';
                break;
            case 'series.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Series::find($id)->title . ' - Gamica';
                break;
            // CONSOLES
            case 'consoles.index':
                return 'Eladó konzolok - Gamica';
                break;
            case 'consoles.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Console::find($id)->title . ' - Gamica';
                break;
            // ACCESSORIES
            case 'accessories.index':
                return 'Eladó kiegészítők - Gamica';
                break;
            case 'accessories.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Accessory::find($id)->title . ' - Gamica';
                break;
            // PACKS
            case 'packs.index':
                return 'Eladó csomagok - Gamica';
                break;
            case 'packs.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Pack::find($id)->title . ' - Gamica';
                break;
            // WANTEDS
            case 'wanteds.index':
                return 'Kérések - Gamica';
                break;
            case 'wanteds.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Wanted::find($id)->title . ' - Gamica';
                break;
            //USERS
            case 'users.index':
                return 'Tagok - Gamica';
                break;
            case 'users.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return User::find($id)->username . ' - Gamica';
                break;
            //PLATFORMS
            case 'platforms.index':
                return 'Konzolok - Gamica';
                break;
            case 'platforms.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Platform::find($id)->title . ' - Gamica';
                break;
            //WIKI
            case 'general-wiki':
                return 'Wiki - Gamica';
                break;
            //FEED
            case 'feed.index':
                return 'Hírfolyam - Gamica';
                break;
            //CONTACT
            case 'contact':
                return 'Kapcsolat - Gamica';
                break;
            default:
                return 'Gamica';
        }
    }

    public function setOgImage(){
        switch (Route::currentRouteName()) {
            // GAMES
            case 'games.show':
                $url = 'https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

                if( strpos($url,'collections') !== false ){
                    $id = basename($_SERVER['REQUEST_URI']);
                    return Game::find($id)->getPhoto();
                } else{
                    $id = basename($_SERVER['REQUEST_URI']);
                    return Sale::find($id)->getPhoto();
                }
                break;
            // SERIES
            case 'series.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Series::find($id)->getPhoto();
                break;
            // CONSOLES
            case 'consoles.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Console::find($id)->getPhoto();
                break;
            // ACCESSORIES
            case 'accessories.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Accessory::find($id)->getPhoto();
                break;
            // PACKS
            case 'packs.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Pack::find($id)->getPhoto();
                break;
            // WANTEDS
            case 'wanteds.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Wanted::find($id)->getPhoto();
                break;
            //USERS
            case 'users.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return User::find($id)->getPhoto();
                break;
            //PLATFORMS
            case 'platforms.show':
                $id = basename($_SERVER['REQUEST_URI']);
                return Platform::find($id)->getPhoto();
                break;
            default:
                return 'https://gamica.hu/img/gamica_og_default.png';
        }
    }
}
