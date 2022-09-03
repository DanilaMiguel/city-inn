<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Teammate extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = [ "title", "description"];


    public function contacts(){
        return $this->BelongsToMany('App\Models\ContactItem',"contact_item_teammate",
            'teammate_id',"contact_item_id","id","id");
    }
}
