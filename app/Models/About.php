<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class About extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title', "text_top", "text_bottom", "button_text"];

    public function slides(){
        return $this->BelongsToMany('App\Models\Slide',"about_slide",
            'about_id',"slide_id","id","id");
    }

    public function tabs(){
        return $this->BelongsToMany('App\Models\Tab',"about_tab",
            'about_id',"tab_id","id","id");
    }
}
