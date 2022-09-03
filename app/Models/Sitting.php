<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Sitting extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = [ "title", "button_text"];

    public function icons(){
        return $this->BelongsToMany('App\Models\Icon',"sitting_icon",
            'sitting_id',"icon_id","id","id");
    }
}
