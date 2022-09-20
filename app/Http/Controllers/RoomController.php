<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Contact;
use App\Models\Footer;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\Room;
use App;
use OptimistDigital\MediaField\MediaField;

class RoomController extends Controller
{
    public function index(){
        $seoBlock = Page::where("section_name","smart")->first();

        if($seoBlock) {
            $imageObject = new MediaField("");

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);
            $result = array(
                "title" => $seoBlock->title,
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "language" => App::getLocale(),
                "template" => "rooms",
                "image" => array(
                    "webp" => array(
                        "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImage->path . $mobileImage->webp_name,
                        "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImage->path . $tabletImage->webp_name,
                        "desktop" => "https://admin.city-inn.com.ua/storage/" . $image->path . $image->webp_name,
                    ),
                    "jpg" => array(
                        "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImage->path . $mobileImage->file_name,
                        "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImage->path . $tabletImage->file_name,
                        "desktop" => "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name,
                    )
                )
            );

            if ($seoBlock->subtitle)
                $result["content"]['top']["subTitle"] = $seoBlock->subtitle;
            if ($seoBlock->description)
                $result["content"]["top"]["description"] = $seoBlock->description;

            $result["items"] = array();
            $rooms = Room::where("active", 1)->get()->sortBy("sort");
            foreach ($rooms as $room) {


                $features = $room->main_features()->get();
                $features_data = array();
                foreach ($features as $feature) {
                    $image = $imageObject->resolveResponseValue($feature->icon);
                    array_push($features_data, array(
                        "title" => $feature->title,
                        "icon" => "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name
                    ));
                }

                $image = $imageObject->resolveResponseValue($room->preview_image);
                $tabletImage = $imageObject->resolveResponseValue($room->tablet_preview_image);
                $mobileImage = $imageObject->resolveResponseValue($room->mobile_preview_image);
                array_push($result["items"], array(
                    "id" => $room->id,
                    "title" => $room->title,
                    "code" => $room->code,
                    "price" => $room->price,
                    "previewImage" => array(
                        "webp" => array(
                            "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImage->path . $mobileImage->webp_name,
                            "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImage->path . $tabletImage->webp_name,
                            "desktop" => "https://admin.city-inn.com.ua/storage/" . $image->path . $image->webp_name,
                        ),
                        "jpg" => array(
                            "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImage->path . $mobileImage->file_name,
                            "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImage->path . $tabletImage->file_name,
                            "desktop" => "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name,
                        )
                    ),
                    "book" => array(
                        "title" => "BOOK NOW",
                        "link" => $room->book_link
                    ),
                    "more" => array(
                        "title" => "ДІЗНАТИСЬ БІЛЬШЕ",
                        "link" => "/rooms/" . $room->code
                    ),
                    "services" => $features_data
                ));

            }


            return response()->json([
                'status' => 'success',
                'content' => $result
            ]);
        }
        else
            return response()->json([
                'status' => 'failure',
                "error"  => "Page data not found"
            ]);
    }


    public function show($code){
        $room = Room::where("code",$code)->where("active",1)->first();

        if($room){
            $imageObject = new MediaField("");
            $bottomBlock = Page::where("section_name","smart")->first();


            $imageHeader = $imageObject->resolveResponseValue($bottomBlock->head_image);
            $tabletImageHeader = $imageObject->resolveResponseValue($bottomBlock->tablet_head_image);
            $mobileImageHeader = $imageObject->resolveResponseValue($bottomBlock->mobile_head_image);

            $result = array(
                "language"  => App::getLocale(),
                "title"       => $room->title,
                "seoTitle" => $room->seo_title,
                "seoDescription" => $room->seo_description,
                "template"  => "standart",
                "image" => array(
                    "webp" => array(
                        "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImageHeader->path . $mobileImageHeader->webp_name,
                        "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImageHeader->path . $tabletImageHeader->webp_name,
                        "desktop" => "https://admin.city-inn.com.ua/storage/" . $imageHeader->path . $imageHeader->webp_name,
                    ),
                    "jpg" => array(
                        "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImageHeader->path . $mobileImageHeader->file_name,
                        "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImageHeader->path . $tabletImageHeader->file_name,
                        "desktop" => "https://admin.city-inn.com.ua/storage/" . $imageHeader->path . $imageHeader->file_name,
                    )
                ),
                "id" => $room->id,
                "sections" => array(),
            );


            // Перший розділ
            $image = $imageObject->resolveResponseValue($room->preview_image);
            $tabletImage = $imageObject->resolveResponseValue($room->tablet_preview_image);
            $mobileImage = $imageObject->resolveResponseValue($room->mobile_preview_image);

            $main_features = $room->main_features()->get();
            $main_features_data = array();
            foreach ($main_features as $feature){
                $image = $imageObject->resolveResponseValue($feature->icon);
                array_push($main_features_data,array(
                    "title" =>  $feature->title,
                    "icon"  =>  "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name
                ));
            }


            array_push($result["sections"], array(
                "description" => $room->description,
                "image" => array(
                    "webp" => array(
                        "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImage->path . $mobileImage->webp_name,
                        "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImage->path . $tabletImage->webp_name,
                        "desktop" => "https://admin.city-inn.com.ua/storage/" . $image->path . $image->webp_name,
                    ),
                    "jpg" => array(
                        "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImage->path . $mobileImage->file_name,
                        "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImage->path . $tabletImage->file_name,
                        "desktop" => "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name,
                    )
                ),
                "button" => array(
                    "text" => trans("controllers.RoomBuyButton"),
                    "link" => $room->book_link
                ),
                "priceNumber" => $room->price,
                "priceText" =>  trans("controllers.RoomPrePrice"),
                "services" => $main_features_data
            ));





            //Другий розділ
            $features = $room->features()->get();
            $features_data = array();
            foreach ($features as $feature){
                $image = $imageObject->resolveResponseValue($feature->icon);
                array_push($features_data,array(
                    "title" =>  $feature->title,
                    "icon"  =>  "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name
                ));
            }

            array_push($result["sections"], array(
                "services" => $features_data
            ));



            //Третій розділ
            $images = array();
            $imageIds = explode(",", $room->images);
            $mobileImageIds = explode(",", $room->mobile_images);
            $tabletImageIds = explode(",", $room->tablet_images);
            for ($i=0;$i<count($imageIds);$i++) {
                $image = $imageObject->resolveResponseValue($imageIds[$i]);
                $tabletImage = $imageObject->resolveResponseValue($tabletImageIds[$i]);
                $mobileImage = $imageObject->resolveResponseValue($mobileImageIds[$i]);
                if($image)
                    array_push($images, array(
                        "webp" => array(
                            "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImage->path . $mobileImage->webp_name,
                            "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImage->path . $tabletImage->webp_name,
                            "desktop" => "https://admin.city-inn.com.ua/storage/" . $image->path . $image->webp_name,
                        ),
                        "jpg" => array(
                            "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImage->path . $mobileImage->file_name,
                            "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImage->path . $tabletImage->file_name,
                            "desktop" => "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name,
                        )
                    ));
            }

            array_push($result["sections"], array(
                "images" => $images
            ));



            //Четвертий розділ
            $included_features = $room->cost_include()->get();
            $included_features_data = array();
            foreach ($included_features as $feature){
                $image = $imageObject->resolveResponseValue($feature->icon);
                array_push($included_features_data,array(
                    "title" =>  $feature->title,
                    "icon"  =>  "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name
                ));
            }

            $imageBottom = $imageObject->resolveResponseValue($bottomBlock->section_image);
            $tabletImageBottom = $imageObject->resolveResponseValue($bottomBlock->tablet_section_image);
            $mobileImageBottom = $imageObject->resolveResponseValue($bottomBlock->mobile_section_image);

            array_push($result["sections"], array(
                "subTitle" => trans("controllers.RoomServicesInclude"),
                "services" => $included_features_data,
                "title"    => $bottomBlock->subtitle,
                "image"    => array(
                    "webp" => array(
                        "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImageBottom->path . $mobileImageBottom->webp_name,
                        "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImageBottom->path . $tabletImageBottom->webp_name,
                        "desktop" => "https://admin.city-inn.com.ua/storage/" . $imageBottom->path . $imageBottom->webp_name,
                    ),
                    "jpg" => array(
                        "mobile" => "https://admin.city-inn.com.ua/storage/" . $mobileImageBottom->path . $mobileImageBottom->file_name,
                        "tablet" => "https://admin.city-inn.com.ua/storage/" . $tabletImageBottom->path . $tabletImageBottom->file_name,
                        "desktop" => "https://admin.city-inn.com.ua/storage/" . $imageBottom->path . $imageBottom->file_name,
                    )
                )
            ));

            return response()->json([
                'status' => 'success',
                'content' => $result
            ]);
        }
        else
            return response()->json([
                'status' => 'failure',
                "error"  => "Page data not found"
            ]);
    }
}
