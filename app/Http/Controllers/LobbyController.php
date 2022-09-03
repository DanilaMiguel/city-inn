<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lobby;
use App\Models\Page;
use App;
use OptimistDigital\MediaField\MediaField;

class LobbyController extends Controller
{
    public function index(){
        $seoBlock = Page::where("section_name","lobby")->first();
        if ($seoBlock) {
            $imageObject = new MediaField("");

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);
            $result = array(
                "title" => $seoBlock->title,
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "template" => "lobby",
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
                            "text" => $seoBlock->reserve_text,
                            "link" => $seoBlock->reserve_link
                        ),
                    ),
                    "top"    => array(
                        "description" => $seoBlock->description,
                    )
                ),
                "sections" => array()
            );

            if($seoBlock->subtitle)
                $result["content"]['top']["subTitle"] = $seoBlock->subtitle;
            if($seoBlock->work_start && $seoBlock->work_end)
                $result["content"]['bottom']["worktime"] = mb_strimwidth($seoBlock->work_start, 0, 5) . " до " . mb_strimwidth($seoBlock->work_end, 0, 5);


            $sections = Lobby::where("active",1)->get();
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
                    if($slide->description)
                        $slideInfo["text"] = $slide->description;
                    if($slide->button_text)
                        $slideInfo["button"] = array(
                            "text" => $slide->button_text,
                            "link" => $slide->button_link
                        );

                    array_push($slides,$slideInfo);
                }

                if($section->description)
                    $sectionInfo["text"] = $section->description;

                if($section->menu_text)
                    $sectionInfo["more"] = array(
                        "text" => $section->menu_text,
                        "link" => $section->menu_link
                    );

                if($section->book_text)
                    $sectionInfo["book"] = array(
                        "text" => $section->book_text,
                        "link" => $section->book_link
                    );

                if (!$slides){
                    $image = $imageObject->resolveResponseValue($section->image);
                    $tabletImage = $imageObject->resolveResponseValue($section->image);
                    $mobileImage = $imageObject->resolveResponseValue($section->image);

                    $sectionInfo["image"] = array(
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
                }
                else{
                    $sectionInfo["slides"] = $slides;
                }

                array_push($result["sections"],$sectionInfo);
            }
            return response()->json([
                'status' => 'success',
                'content' => $result
            ]);
        }
        else{
            return response()->json([
                'status' => 'failure',
                "error"  => "Page data not found"
            ]);
        }
    }
}
