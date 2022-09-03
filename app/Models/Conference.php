<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Conference extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title', "description", "button_text"];

    public function slides(){
        return $this->BelongsToMany('App\Models\Slide',"conference_slide",
            'conference_id',"slide_id","id","id");
    }

    public function tabs(){
        return $this->BelongsToMany('App\Models\Tab',"conference_tab",
            'conference_id',"tab_id","id","id");
    }
}
