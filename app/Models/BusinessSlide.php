<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BusinessSlide extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = [ "title", "description", "button_text", "price_for", "pre_price"];

    public function icons(){
        return $this->BelongsToMany('App\Models\Icon',"business_slide_icon",
            'business_slide_id',"icon_id","id","id");
    }
}
