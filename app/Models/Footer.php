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
        $addresses = Address::all()->where("active",1);
        $addressItems = array();
        foreach ($addresses as $address){
            array_push($addressItems,array(
                "text" => $address->text,
                "link" => is_null($address->link) ? "" : $address->link
            ));
        }
        $addresses = array(array(
            "title" => "Адреса",
            "items" => $addressItems
        ));

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
                    "link" => $item->link
                ));
            }
            array_push($result["columns"],array(
                "title" => $header->title,
                "items" => $itemsInfo
            ));
        }
        if($result["columns"])
            array_splice($result["columns"], 1, 0, $addresses);

        return $result;
    }
}

