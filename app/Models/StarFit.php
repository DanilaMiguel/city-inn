<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StarFit extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title', "text_top", "text_bottom", "button_text"];

    public function slides(){
        return $this->BelongsToMany('App\Models\Slide',"starfit_slide",
            'star_fit_id',"slide_id","id","id");
    }

    public function services(){
        return $this->BelongsToMany('App\Models\Icon',"starfit_services",
            'star_fit_id',"icon_id","id","id");
    }
}
