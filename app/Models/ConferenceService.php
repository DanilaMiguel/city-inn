<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ConferenceService extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title', "description", "section_title", "section_description", "seo_title",
                            "seo_description", "why_title", "park_title", "park_description", "button_text"];

    public function offers(){
        return $this->BelongsToMany('App\Models\BusinessSlide',"conference_service_offer",
            'conference_service_id',"business_slide_id","id","id");
    }

    public function food(){
        return $this->BelongsToMany('App\Models\BusinessSlide',"conference_service_food",
            'conference_service_id',"business_slide_id","id","id");
    }

    public function tabs(){
        return $this->BelongsToMany('App\Models\Tab',"conference_service_tab",
            'conference_service_id',"tab_id","id","id");
    }

    public function icons(){
        return $this->BelongsToMany('App\Models\Icon',"conference_service_icon",
            'conference_service_id',"icon_id","id","id");
    }

    public function sittings(){
        return $this->BelongsToMany('App\Models\Sitting',"conference_service_sitting",
            'conference_service_id',"sitting_id","id","id");
    }
}
