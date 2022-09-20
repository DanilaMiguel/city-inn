<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\SmartOffer;
use Illuminate\Http\Request;
use App;
use OptimistDigital\MediaField\MediaField;

class SmartOfferController extends Controller
{
    public function index(){
        $seoBlock = Page::where("section_name","smart-offer")->first();
        if ($seoBlock) {
            $imageObject = new MediaField("");

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);
            $result = array(
                "title" => $seoBlock->title,
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "template" => "smart",
                "language"  => App::getLocale(),
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
            );

            if ($seoBlock->subtitle)
                $result["content"]['top']["subTitle"] = $seoBlock->subtitle;
            if ($seoBlock->work_start && $seoBlock->work_end)
                $result["content"]['bottom']["worktime"] = mb_strimwidth($seoBlock->work_start, 0, 5) . " до " . mb_strimwidth($seoBlock->work_end, 0, 5);
            if ($seoBlock->description)
                $result["content"]["top"]["description"] = $seoBlock->description;

            $sections = SmartOffer::where("active",1)->get()->sortBy("sort");

            $result["sections"] = array();
            foreach ($sections as $section){
                $sectionInfo = array(
                    "title" => $section->title
                );

                if($section->book_text)
                    $sectionInfo["book"] = array(
                        "text" => $section->book_text,
                        "link" => $section->book_link
                    );
                if($section->description)
                    $sectionInfo["description"] = $section->description;



                if($section->work_start && $section->work_end)
                    $sectionInfo["worktime"] = mb_strimwidth($section->work_start, 0, 5) . " до " . mb_strimwidth($section->work_end, 0, 5);

                $services = array();
                foreach ($section->services()->get() as $service){
                    $image = $imageObject->resolveResponseValue($service->icon);
                    array_push($services,array(
                        "title" =>  $service->title,
                        "icon"  =>  "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name
                    ));
                }

                if($services)
                    $sectionInfo["services"] = $services;

                $slides= array();
                foreach($section->slides()->get() as $slide){
                    $image = $imageObject->resolveResponseValue($slide->image);
                    $tabletImage = $imageObject->resolveResponseValue($slide->tablet_image);
                    $mobileImage = $imageObject->resolveResponseValue($slide->mobile_image);
                    $slideInfo = array();
                    $slideInfo["image"] = array(
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
                    );
                    if($slide->header)
                        $slideInfo["title"] = $slide->header;
                    if($slide->description)
                        $slideInfo["description"] = $slide->description;
                    if($slide->button_text)
                        $slideInfo["book"] = array(
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
                            "icon"  =>  "https://admin.city-inn.com.ua/storage/" . $image->path . $image->file_name
                        ));
                    }
                    if($services)
                        $slideInfo["services"] = $services;

                    array_push($slides,$slideInfo);
                }


                $image = $imageObject->resolveResponseValue($section->image);
                $tabletImage = $imageObject->resolveResponseValue($section->tablet_image);
                $mobileImage = $imageObject->resolveResponseValue($section->mobile_image);
                if($image)
                    $sectionInfo["image"] = array(
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
                    );

                if ($slides)
                    $sectionInfo["slides"] = $slides;


                array_push($result["sections"], $sectionInfo);
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
}
