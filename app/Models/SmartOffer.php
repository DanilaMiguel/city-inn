<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SmartOffer extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title', "text_top", "text_bottom", "book_text"];

    public function slides(){
        return $this->BelongsToMany('App\Models\Slide',"smart_offer_slide",
            'smart_offer_id',"slide_id","id","id");
    }

    public function services(){
        return $this->BelongsToMany('App\Models\Icon',"smart_offer_services",
            'smart_offer_id',"icon_id","id","id");
    }
}
