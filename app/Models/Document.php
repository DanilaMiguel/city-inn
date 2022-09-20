<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    public function items(){
        return $this->BelongsToMany('App\Models\DocumentItem',"document_document_item",
            'document_id',"document_item_id","id","id");
    }
}
