<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Highlight extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'highlights';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_id',
        'item_type',
        'item_order'
    ];

    public function getItem($itemId){
        if($this->item_type == 'games'){
            return Sale::find($itemId);
        }

        if($this->item_type == 'consoles'){
            return Console::find($itemId);
        }

        if($this->item_type == 'accessories'){
            return Accessory::find($itemId);
        }

        if($this->item_type == 'packs'){
            return Pack::find($itemId);
        }
    }
}