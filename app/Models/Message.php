<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'messages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'from_id',
        'to_id',
        'message',
        'is_read'
    ];

    public function getFrom()
    {
        return $this->hasOne(User::class, 'id', 'from_id');
    }

    public function getTo()
    {
        return $this->hasOne(User::class, 'id', 'to_id');
    }

    public function getItem($id){
        if($this->subject_type == 1){
            return Sale::find($id);
        } elseif($this->subject_type == 2){
            return Console::find($id);
        } elseif($this->subject_type == 3){
            return Accessory::find($id);
        } elseif($this->subject_type == 4){
            return Pack::find($id);
        } elseif($this->subject_type == 5){
            return Wanted::find($id);
        } else{
            return null;
        }
    }

    public function getURL($type, $id){
        switch($type){
            case 1:
                $url = 'games';
                break;
            case 2:
                $url = 'consoles';
                break;
            case 3:
                $url = 'accessories';
                break;
            case 4:
                $url = 'packs';
                break;
            case 5:
                $url = 'wanteds';
                break;
            default:
                $url = null;
        }

        if($type == 5){
            return $url.'/'.$id;
        } else{
            return '/sales/'.$url.'/'.$id;
        }
    }
}
