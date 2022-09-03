<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slide extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = [ "header", "description", "button_text", "description_adder"];

    public function icons(){
        return $this->BelongsToMany('App\Models\Icon',"icon_slide",
            'slide_id',"icon_id","id","id");
    }

    public function contacts(){
        return $this->BelongsToMany('App\Models\ContactItem',"contact_item_slide",
            'slide_id',"contact_item_id","id","id");
    }
}
