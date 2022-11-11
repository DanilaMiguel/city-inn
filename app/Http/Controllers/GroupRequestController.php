<?php

namespace App\Http\Controllers;

use App\Models\ConferenceService;
use App\Models\GroupRequest;
use App\Models\Page;
use App\Models\Room;
use Illuminate\Http\Request;
use App;
use OptimistDigital\MediaField\MediaField;

class GroupRequestController extends Controller
{
    public function index(){

        $seoBlock = Page::where("section_name","group")->first();
        if ($seoBlock) {
            $imageObject = new MediaField("");

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);
            $result = array(
                "title" => $seoBlock->title,
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "template" => "group",
                "language"  => App::getLocale(),
                "image" => array(
                    "webp" => array(
                        "mobile" => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->webp_name,
                        "tablet" => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->webp_name,
                        "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->webp_name,
                    ),
                    "jpg" => array(
                        "mobile" => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->file_name,
                        "tablet" => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->file_name,
                        "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->file_name,
                    )
                ),
            );

            if ($seoBlock->subtitle)
                $result["content"]['top']["subTitle"] = $seoBlock->subtitle;
            if ($seoBlock->work_start && $seoBlock->work_end)
                $result["content"]['bottom']["worktime"] = mb_strimwidth($seoBlock->work_start, 0, 5) . " до " . mb_strimwidth($seoBlock->work_end, 0, 5);
            if ($seoBlock->description)
                $result["content"]["top"]["description"] = $seoBlock->description;

            $sections = GroupRequest::where("active",1)->get();
            $result["sections"] = array();
            foreach ($sections as $section){
                $sectionInfo = array(
                    "title" => $section->title
                );

                if ($section->subtitle)
                    $sectionInfo["subTitle"] = $section->subtitle;

                if ($section->is_smart_number){

                    $sectionInfo["rooms"] = array();
                    $rooms = Room::where("active", 1)->get()->sortBy("sort");
                    foreach ($rooms as $room){


                        $features = $room->main_features()->get();
                        $features_data = array();
                        foreach ($features as $feature){
                            $image = $imageObject->resolveResponseValue($feature->icon);
                            array_push($features_data,array(
                                "title" =>  $feature->title,
                                "icon"  =>  $_SERVER["APP_URL"]."/storage/".$image->path.$image->file_name
                            ));
                        }

                        $image = $imageObject->resolveResponseValue($room->preview_image);
                        $tabletImage = $imageObject->resolveResponseValue($room->tablet_preview_image);
                        $mobileImage = $imageObject->resolveResponseValue($room->mobile_preview_image);
                        array_push($sectionInfo["rooms"],array(
                            "id"            =>  $room->id,
                            "title"         =>  $room->title,
                            "code"          =>  $room->code,
                            "price"         =>  $room->price,
                            "description"   => $room->description,
                            "previewImage" =>  array(
                                "webp"  => array(
                                    "mobile"  => $_SERVER["APP_URL"]."/storage/".$mobileImage->path.$mobileImage->webp_name,
                                    "tablet"  => $_SERVER["APP_URL"]."/storage/".$tabletImage->path.$tabletImage->webp_name,
                                    "desktop" => $_SERVER["APP_URL"]."/storage/".$image->path.$image->webp_name,
                                ),
                                "jpg"   => array(
                                    "mobile"  => $_SERVER["APP_URL"]."/storage/".$mobileImage->path.$mobileImage->file_name,
                                    "tablet"  => $_SERVER["APP_URL"]."/storage/".$tabletImage->path.$tabletImage->file_name,
                                    "desktop" => $_SERVER["APP_URL"]."/storage/".$image->path.$image->file_name,
                                )
                            ),
                            "more"     =>  array(
                                "title" => "ДІЗНАТИСЬ БІЛЬШЕ",
                                "link"  => "/rooms/".$room->code
                            ),
                            "services"      =>  $features_data
                        ));

                    }

                }
                else {

                    if ($section->button_text)
                        $sectionInfo["button"] = array(
                            "text" => $section->button_text,
                            "link" => $section->button_link
                        );
                    if ($section->description)
                        $sectionInfo["description"] = $section->description;


                    if ($section->work_start && $section->work_end)
                        $sectionInfo["worktime"] = mb_strimwidth($section->work_start, 0, 5) . " до " . mb_strimwidth($section->work_end, 0, 5);


                    $tabs = array();
                    foreach($section->tabs()->get() as $tab){
                        array_push($tabs, array(
                            "text" => $tab->text
                        ));
                    }

                    if($tabs)
                        $sectionInfo["tabs"] = $tabs;


                    $slides= array();
                    foreach($section->slides()->get() as $slide){
                        $image = $imageObject->resolveResponseValue($slide->image);
                        $tabletImage = $imageObject->resolveResponseValue($slide->tablet_image);
                        $mobileImage = $imageObject->resolveResponseValue($slide->mobile_image);
                        $slideInfo = array();
                        $slideInfo["image"] = array(
                            "webp" => array(
                                "mobile" => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->webp_name,
                                "tablet" => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->webp_name,
                                "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->webp_name,
                            ),
                            "jpg" => array(
                                "mobile" => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->file_name,
                                "tablet" => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->file_name,
                                "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->file_name,
                            )
                        );
                        if($slide->header)
                            $slideInfo["title"] = $slide->header;
                        if($slide->description)
                            $slideInfo["description"] = $slide->description;
                        if($slide->button_text)
                            $slideInfo["button"] = array(
                                "text" => $slide->button_text,
                                "link" => $slide->button_link
                            );

                        if($slide->work_start && $slide->work_end)
                            $slideInfo["worktime"] = mb_strimwidth($slide->work_start, 0, 5) . " до " . mb_strimwidth($slide->work_end, 0, 5);

                        $services = array();
                        foreach ($slide->icons()->get() as $service){
                            $image = $imageObject->resolveResponseValue($service->icon);
                            array_push($services,array(
                                "title" =>  $service->title,
                                "icon"  =>  $_SERVER["APP_URL"]."/storage/" . $image->path . $image->file_name
                            ));
                        }
                        if($services)
                            $slideInfo["services"] = $services;


                        array_push($slides,$slideInfo);
                    }

                    if (!$slides){
                        $images = array();
                        $imageIds = explode(",", $section->images);
                        $mobileImageIds = explode(",", $section->mobile_images);
                        $tabletImageIds = explode(",", $section->tablet_images);
                        for ($i=0;$i<count($imageIds);$i++) {
                            $image = $imageObject->resolveResponseValue($imageIds[$i]);
                            $tabletImage = $imageObject->resolveResponseValue($tabletImageIds[$i]);
                            $mobileImage = $imageObject->resolveResponseValue($mobileImageIds[$i]);
                            if($image)
                                array_push($images, array(
                                    "webp" => array(
                                        "mobile" => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->webp_name,
                                        "tablet" => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->webp_name,
                                        "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->webp_name,
                                    ),
                                    "jpg" => array(
                                        "mobile" => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->file_name,
                                        "tablet" => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->file_name,
                                        "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->file_name,
                                    )
                                ));
                        }

                        if(count($images) == 1)
                            $sectionInfo["image"] = $images[0];
                        else
                            $sectionInfo["images"] = $images;
                    }
                    else{
                        $sectionInfo["slides"] = $slides;
                    }
                }

                array_push($result["sections"], $sectionInfo);
            }

            $team = new Page();
            $team = array(
                "title" => trans('controllers.GroupRequestTeamTitle'),
                "subTitle" => trans('controllers.GroupRequestTeamSubTitle'),
                "slides" => $team->team()
            );

            array_push($result["sections"], $team);

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
