<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Footer extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ['title'];

    public function items(){
        return $this->BelongsToMany('App\Models\FooterItem',"footer_footer_item",
            'footer_id',"footer_item_id","id","id");
    }

    public  function show(){
        $footerHeaders = self::where("active",1)->get()->sortBy("sort");
        $result["copyright"] = array(
            trans("controllers.CopyrightFirstField"),
            trans("controllers.CopyrightSecondField")
        );
        $result["columns"] = array();

        foreach ($footerHeaders as $header){
            $footerItems = $header->items()->get();

            $itemsInfo = array();

            foreach ($footerItems as $item){

                array_push($itemsInfo, array(
                    "text" => $item->title,
                    "link" => is_null($item->link) ? "" : $item->link
                ));
            }
            array_push($result["columns"],array(
                "title" => $header->title,
                "items" => $itemsInfo
            ));
        }


        return $result;
    }
}

