<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class GroupRequest extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title', 'subtitle', "description", "button_text"];

    public function slides(){
        return $this->BelongsToMany('App\Models\Slide',"group_request_slide",
            'group_request_id',"slide_id","id","id");
    }

    public function tabs(){
        return $this->BelongsToMany('App\Models\Tab',"group_request_tab",
            'group_request_id',"tab_id","id","id");
    }
}
