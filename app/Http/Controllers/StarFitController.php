<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\StarFit;
use Illuminate\Http\Request;
use App;
use OptimistDigital\MediaField\MediaField;

class StarFitController extends Controller
{
    public function index(){
        $seoBlock = Page::where("section_name","starfit")->first();
        if ($seoBlock) {
            $imageObject = new MediaField("");

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);
            $result = array(
                "title" => $seoBlock->title,
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "template" => "starfit",
                "language"  => App::getLocale(),
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
                ),
            );

            if ($seoBlock->subtitle)
                $result["content"]['top']["subTitle"] = $seoBlock->subtitle;
            if ($seoBlock->work_start && $seoBlock->work_end)
                $result["content"]['bottom']["worktime"] = mb_strimwidth($seoBlock->work_start, 0, 5) . " до " . mb_strimwidth($seoBlock->work_end, 0, 5);
            if ($seoBlock->description)
                $result["content"]["top"]["description"] = $seoBlock->description;

            $sections = StarFit::where("active",1)->get();
            $result["sections"] = array();

            foreach ($sections as $section){
                $sectionInfo = array(
                    "title" => $section->title
                );

                if($section->button_text)
                    $sectionInfo["rules"] = array(
                        "text" => $section->button_text,
                        "link" => $section->button_link
                    );
                if($section->text_top && $section->text_bottom) {
                    $sectionInfo["textTop"] = $section->text_top;
                    $sectionInfo["textBottom"] = $section->text_bottom;
                }
                elseif($section->text_top)
                    $sectionInfo["description"] = $section->text_top;



                if($section->work_start && $section->work_end)
                    $sectionInfo["worktime"] = mb_strimwidth($section->work_start, 0, 5) . " до " . mb_strimwidth($section->work_end, 0, 5);

                $services = array();
                foreach ($section->services()->get() as $service){
                    $image = $imageObject->resolveResponseValue($service->icon);
                    array_push($services,array(
                        "title" =>  $service->title,
                        "icon"  =>  "/storage/" . $image->path . $image->file_name
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
                            "mobile" => "/storage/" . $mobileImage->path . $mobileImage->webp_name,
                            "tablet" => "/storage/" . $tabletImage->path . $tabletImage->webp_name,
                            "desktop" => "/storage/" . $image->path . $image->webp_name,
                        ),
                        "jpg" => array(
                            "mobile" => "/storage/" . $mobileImage->path . $mobileImage->file_name,
                            "tablet" => "/storage/" . $tabletImage->path . $tabletImage->file_name,
                            "desktop" => "/storage/" . $image->path . $image->file_name,
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
                            "icon"  =>  "/storage/" . $image->path . $image->file_name
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
                                    "mobile" => "/storage/" . $mobileImage->path . $mobileImage->webp_name,
                                    "tablet" => "/storage/" . $tabletImage->path . $tabletImage->webp_name,
                                    "desktop" => "/storage/" . $image->path . $image->webp_name,
                                ),
                                "jpg" => array(
                                    "mobile" => "/storage/" . $mobileImage->path . $mobileImage->file_name,
                                    "tablet" => "/storage/" . $tabletImage->path . $tabletImage->file_name,
                                    "desktop" => "/storage/" . $image->path . $image->file_name,
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
