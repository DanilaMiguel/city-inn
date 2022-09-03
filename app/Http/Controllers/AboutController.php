<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\ContactItem;
use App\Models\Page;
use App\Nova\Icon;
use Illuminate\Http\Request;
use App;
use OptimistDigital\MediaField\MediaField;

class AboutController extends Controller
{
    public function index(){
        $seoBlock = Page::where("section_name","about")->first();
        if ($seoBlock) {
            $imageObject = new MediaField("");
            $call_us = ContactItem::where("call_us",1)->first();

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);
            $result = array(
                "title" => $seoBlock->title,
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "template" => "about",
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
                "content" => array(
                    "bottom" => array(
                        "book" => array(
                            "text" => 'Call us',
                            "link" => $call_us->link
                        )
                    ),
                    "top" => array(
                        "description" => $seoBlock->description,
                    )
                ),
                "sections" => array()
            );

            if ($seoBlock->subtitle)
                $result["content"]['top']["subTitle"] = $seoBlock->subtitle;
            if ($seoBlock->work_start && $seoBlock->work_end)
                $result["content"]['bottom']["worktime"] = mb_strimwidth($seoBlock->work_start, 0, 5) . " до " . mb_strimwidth($seoBlock->work_end, 0, 5);


            $sections = About::where("active",1)->get();

            foreach ($sections as $section){
                $sectionInfo = array(
                    "title" => $section->title
                );

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
                    if($slide->description && $slide->description_adder) {
                        $slideInfo["textTop"] = $slide->description;
                        $slideInfo["textBottom"] = $slide->description_adder;
                    }
                    elseif($slide->description)
                        $slideInfo["description"] = $slide->description;

                    if($slide->button_text)
                        $slideInfo["button"] = array(
                            "text" => $slide->button_text,
                            "link" => $slide->button_link
                        );

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

                $tabs = array();
                foreach($section->tabs()->get() as $tab){
                    array_push($tabs, array(
                        "text" => $tab->text
                    ));
                }

                if($tabs)
                    $sectionInfo["tabs"] = $tabs;

                if($section->text_top && $section->text_bottom) {
                    $sectionInfo["textTop"] = $section->text_top;
                    $sectionInfo["textBottom"] = $section->text_bottom;
                }
                elseif($section->text_top){
                    $sectionInfo["description"] = $section->text_top;
                }

                if($section->section_name)
                    $sectionInfo["sectionName"] = $section->section_name;

                if($section->button_text)
                    $sectionInfo["more"] = array(
                        "text" => $section->button_text,
                        "link" => $section->button_link
                    );

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
