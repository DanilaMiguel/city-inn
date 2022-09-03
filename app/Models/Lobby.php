<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Lobby extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title', "description", "menu_text", "book_text"];

    public function slides(){
        return $this->BelongsToMany('App\Models\Slide',"lobby_slide",
            'lobby_id',"slide_id","id","id");
    }
}
