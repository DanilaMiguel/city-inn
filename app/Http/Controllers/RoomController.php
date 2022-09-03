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
                "language"  => App::getLocale(),
                "template"  => "rooms",
                "image" => array(
                    "webp" => array(
                        "mobile" => "/storage/" . $mobileImage->path . $mobileImage->webp_name,
                        "tablet" => "/storage/" . $tabletImage->path . $tabletImage->webp_name,
                        "desktop" => "/storage/" . $image->path . $image->webp_name,
                    ),
                    "jpg" => array(
                        "mobile" => "/storage/" . $mobileImage->path . $mobileImage->file_name,
                        "tablet" => "/storage/" . $tabletImage->path . $tabletImage->file_name,
                        "desktop" => "/storage/" . $image->path . $image->file_name,
                    )
                )
            );
        }
        if($seoBlock->subtitle)
            $result["content"]['top']["subTitle"] = $seoBlock->subtitle;
        if ($seoBlock->description)
            $result["content"]["top"]["description"] = $seoBlock->description;

        $result["items"] = array();
        $rooms = Room::where("active", 1)->get()->sortBy("sort");
        foreach ($rooms as $room){


            $features = $room->main_features()->get();
            $features_data = array();
            foreach ($features as $feature){
                $image = $imageObject->resolveResponseValue($feature->icon);
                array_push($features_data,array(
                    "title" =>  $feature->title,
                    "icon"  =>  "/storage/".$image->path.$image->file_name
                ));
            }

            $image = $imageObject->resolveResponseValue($room->preview_image);
            $tabletImage = $imageObject->resolveResponseValue($room->tablet_preview_image);
            $mobileImage = $imageObject->resolveResponseValue($room->mobile_preview_image);
            array_push($result["items"],array(
                "id"            =>  $room->id,
                "title"         =>  $room->title,
                "code"          =>  $room->code,
                "price"         =>  $room->price,
                "previewImage" =>  array(
                    "webp"  => array(
                        "mobile"  => "/storage/".$mobileImage->path.$mobileImage->webp_name,
                        "tablet"  => "/storage/".$tabletImage->path.$tabletImage->webp_name,
                        "desktop" => "/storage/".$image->path.$image->webp_name,
                    ),
                    "jpg"   => array(
                        "mobile"  => "/storage/".$mobileImage->path.$mobileImage->file_name,
                        "tablet"  => "/storage/".$tabletImage->path.$tabletImage->file_name,
                        "desktop" => "/storage/".$image->path.$image->file_name,
                    )
                ),
                "book"     =>  array(
                    "title" => "BOOK NOW",
                    "link"  => $room->book_link
                ),
                "more"     =>  array(
                    "title" => "ДІЗНАТИСЬ БІЛЬШЕ",
                    "link"  => "/rooms/".$room->code
                ),
                "services"      =>  $features_data
            ));

        }



        return response()->json([
            'status' => 'success',
            'content' => $result
        ]);
    }


    public function show($code){
        $room = Room::where("code",$code)->where("active",1)->first();

        if($room){
            $imageObject = new MediaField("");
            $bottomBlock = Page::where("section_name","smart")->first();


            $image = $imageObject->resolveResponseValue($room->preview_image);
            $imageHeader = $imageObject->resolveResponseValue($bottomBlock->head_image);
            $imageBottom = $imageObject->resolveResponseValue($bottomBlock->section_image);

            $result = array(
                "language"  => App::getLocale(),
                "title"       => $room->title,
                "seoTitle" => $room->seo_title,
                "seoDescription" => $room->seo_description,
                "template"  => "standart",
                "content" => array(
                    "top" => array(
                        "description" => $room->description
                    )
                ),
                "image" => array(
                    "webp" => array(
                        "mobile" => "/storage/" . $imageHeader->path . $imageHeader->webp_name,
                        "tablet" => "/storage/" . $imageHeader->path . $imageHeader->webp_name,
                        "desktop" => "/storage/" . $imageHeader->path . $imageHeader->webp_name,
                    ),
                    "jpg" => array(
                        "mobile" => "/storage/" . $imageHeader->path . $imageHeader->file_name,
                        "tablet" => "/storage/" . $imageHeader->path . $imageHeader->file_name,
                        "desktop" => "/storage/" . $imageHeader->path . $imageHeader->file_name,
                    )
                ),
                "roomInfo" => array(
                    "id"          => $room->id,
                    "title"       => $room->title,
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
                    "book" => array(
                        "title" => "BOOK NOW",
                        "link"  => $room->book_link
                    ),
                    "price" => $room->price
                ),
                "bottomBlock" => array(
                    "title" => $bottomBlock->header_two,
                    "image" => array(
                        "webp" => array(
                            "mobile" => "/storage/" . $imageBottom->path . $imageBottom->webp_name,
                            "tablet" => "/storage/" . $imageBottom->path . $imageBottom->webp_name,
                            "desktop" => "/storage/" . $imageBottom->path . $imageBottom->webp_name,
                        ),
                        "jpg" => array(
                            "mobile" => "/storage/" . $imageBottom->path . $imageBottom->file_name,
                            "tablet" => "/storage/" . $imageBottom->path . $imageBottom->file_name,
                            "desktop" => "/storage/" . $imageBottom->path . $imageBottom->file_name,
                        )
                    ),
                )
            );

            $images = array();
            foreach (explode(",", $room->images) as $image) {
                $image = $imageObject->resolveResponseValue($image);
                array_push($images, array(
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
                ));
            }


            $main_features = $room->main_features()->get();
            $main_features_data = array();
            foreach ($main_features as $feature){
                $image = $imageObject->resolveResponseValue($feature->icon);
                array_push($main_features_data,array(
                    "title" =>  $feature->title,
                    "icon"  =>  "/storage/" . $image->path . $image->file_name
                ));
            }


            $features = $room->features()->get();
            $features_data = array();
            foreach ($features as $feature){
                $image = $imageObject->resolveResponseValue($feature->icon);
                array_push($features_data,array(
                    "title" =>  $feature->title,
                    "icon"  =>  "/storage/" . $image->path . $image->file_name
                ));
            }

            $included_features = $room->cost_include()->get();
            $included_features_data = array(
                "items" => array(),
                "title" => "ВХОДИТЬ У ВАРТІСТЬ"
            );
            foreach ($included_features as $feature){
                $image = $imageObject->resolveResponseValue($feature->icon);
                array_push($included_features_data["items"],array(
                    "title" =>  $feature->title,
                    "icon"  =>  "/storage/" . $image->path . $image->file_name
                ));
            }

            $result["roomInfo"]["mainFeatures"] = $main_features_data;
            $result["roomInfo"]["allFeatures"] = $features_data;
            $result["roomInfo"]["includedFeatures"] = $included_features_data;
            $result["roomInfo"]["images"] = $images;



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
