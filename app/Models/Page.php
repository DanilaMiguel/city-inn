<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OptimistDigital\MediaField\MediaField;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasFactory;
    use HasTranslations;
    public $translatable = ["title", "subtitle", "description", "seo_title", "seo_description","section_title",
        "header_one", "header_two","reserve_text","more_text"];

    public function team(){

        $result = array();

        $teammates = Teammate::where("active", 1)->get()->sortBy("sort");
        $imageObject = new MediaField("");

        foreach ($teammates as $mate){
            $contacts = array();
            foreach ($mate->contacts()->get() as $contact){
                array_push($contacts,array(
                    "text" =>  $contact->title,
                    "link"  =>  $contact->link
                ));
            }
            $image = $imageObject->resolveResponseValue($mate->image);

            array_push($result,array(
                "title" => $mate->title,
                "description" => $mate->description,
                "image" => array(
                    "webp" => array(
                        "mobile" => "/storage/" . $image->path . $image->webp_name,
                        "tablet" => "/storage/" . $image->path . $image->webp_name,
                        "desktop" => "/storage/" . $image->path . $image->webp_name,
                    ),
                    "jpg" => array(
                        "mobile" => "/storage/" . $image->path . $image->file_name,
                        "tablet" => "/storage/" . $image->path . $image->file_name,
                        "desktop" => "/storage/" . $image->path . $image->file_name,
                    )
                ),
                "contacts" => $contacts
            ));
        }

        return $result;
    }

    public function stats(){
        $result = array();

        $stats = Stat::all()->sortBy("sort");

        foreach ($stats as $stat){

            array_push($result,array(
                "textTop" => $stat->text_top,
                "textBottom" => $stat->text_bottom,
                "number" => $stat->number,
            ));
        }

        return $result;
    }
}
