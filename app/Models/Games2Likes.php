<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Games2Likes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'games_2_likes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'game_id',
        'user_id'
    ];

    public function getUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getGame()
    {
        return $this->hasOne(Game::class, 'id', 'game_id');
    }
}
