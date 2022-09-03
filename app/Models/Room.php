<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Room extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title', "description", "seo_title", "seo_description"];

    public function features(){
        return $this->BelongsToMany('App\Models\Icon',"features_icons",
            'room_id',"icon_id","id","id");
    }


    public function cost_include(){
        return $this->BelongsToMany('App\Models\Icon',"cost_include_icons",
            'room_id',"icon_id","id","id");
    }


    public function main_features(){
        return $this->BelongsToMany('App\Models\Icon',"main_features_icons",
            'room_id',"icon_id","id","id");
    }
}
