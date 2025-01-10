<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
//use App\Models\Game;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'default_language',
        'fb_profile',
        'ig_profile',
        'xp_points',
        'rank_id',
        'city_id',
        'deleted'
        ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCity()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function getRank()
    {
        return $this->hasOne(Rank::class, 'id', 'rank_id');
    }

    public function setRank(){
        $xp = $this->xp_points;

        if($this->rank_id != 3){
            if($xp >= 0 && $xp <= 9){
                $this->rank_id = 1;
                $this->save();
            } elseif($xp >= 10 && $xp <= 2499){
                $this->rank_id = 21;
                $this->save();
            } elseif($xp >= 2500 && $xp <= 4999){
                $this->rank_id = 22;
                $this->save();
            } elseif($xp >= 5000 && $xp <= 7499){
                $this->rank_id = 23;
                $this->save();
            } elseif($xp >= 7500 && $xp <= 9999){
                $this->rank_id = 24;
                $this->save();
            } elseif($xp >= 10000 && $xp <= 99999){
                $this->rank_id = 25;
                $this->save();
            } else{
                $this->rank_id = 20;
                $this->save();
            }
        }
    }

    public function getPhoto()
    {
        $photoName = strtolower($this->id . '_' . $this->username . '.jpg');
        $photoName = str_replace(" ", "_", $photoName);
        if(file_exists('img/users/' . $photoName)){
            return asset('img/users/' . $photoName);
        } else{
            return ('/img/default.png');
        }
    }

    public function getPhotoName()
    {
        $photoName = strtolower($this->id . '_' . $this->username . '.jpg');
        $photoName = str_replace(" ", "_", $photoName);
        return $photoName;
    }

    public function getGames()
    {
        return Game::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getGamesLimited()
    {
        return Game::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->limit(10)->get();
    }

    public function getRecommendations()
    {
        return Game::where('user_id', $this->id)->where('deleted', 0)->inRandomOrder()->limit(10)->get();
    }

    public function getSeries()
    {
        return Series::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getSeriesLimited()
    {
        return Series::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->limit(10)->get();
    }

    public function getSales()
    {
        return Sale::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getSalesLimited()
    {
        return Sale::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->limit(10)->get();
    }

    public function getConsoles()
    {
        return Console::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getConsolesLimited()
    {
        return Console::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->limit(10)->get();
    }

    public function getWanteds()
    {
        return Wanted::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getWantedsLimited()
    {
        return Wanted::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->limit(10)->get();
    }

    public function getAccessories()
    {
        return Accessory::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getAccessoriesLimited()
    {
        return Accessory::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->limit(10)->get();
    }

    public function getPacks()
    {
        return Pack::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->get();
    }

    public function getPacksLimited()
    {
        return Pack::where('user_id', $this->id)->where('deleted', 0)->orderBy('id', 'desc')->limit(10)->get();
    }

    public function getLastMessage($partnerId){
        return Message::where('from_id', $this->id)->where('to_id', $partnerId)
            ->orWhere('from_id', $partnerId)->where('to_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function getLastInMessage($partnerId){
        $message = Message::where('to_id', $this->id)->where('from_id', $partnerId)
            ->orderBy('created_at', 'desc')
            ->first();

        if($message){
            return $message->is_read ? true : false;
        } else{
            return true;
        }
    }
}
