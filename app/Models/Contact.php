<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Contact extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title', "description", "menu_text", "book_text"];

    public function items(){
        return $this->BelongsToMany('App\Models\ContactItem',"contact_contact_item",
            'contact_id',"contact_item_id","id","id");
    }
}
