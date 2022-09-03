<?php

namespace App\Http\Controllers;

use App\Models\Conference;
use App\Models\ConferenceService;
use App\Models\Page;
use Illuminate\Http\Request;
use App;
use OptimistDigital\MediaField\MediaField;

class ConferenceController extends Controller
{
    public function index(){
        $seoBlock = Page::where("section_name","conference")->first();
        if ($seoBlock) {
            $imageObject = new MediaField("");

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);
            $result = array(
                "title" => $seoBlock->title,
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "template" => "conference-service",
                "language"  => App::getLocale(),
                "image" => array(
                    "webp" => array(
                        "mobile" => "/storage/" . $image->path . $image->webp_name,
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

            $sections = Conference::where("active",1)->get()->sortBy("sort");
            $result["sections"] = array();

            foreach ($sections as $section){
                $sectionInfo = array(
                    "title" => $section->title
                );

                if ($section->is_conference_services){
                    $items = ConferenceService::where("active",1)->get();

                    $services = Array();
                    foreach ($items as $item){
                        $image = $imageObject->resolveResponseValue($item->preview_image);
                        $tabletImage = $imageObject->resolveResponseValue($item->tablet_preview_image);
                        $mobileImage = $imageObject->resolveResponseValue($item->mobile_preview_image);
                        array_push($services, array(
                            "title" => $item->section_title,
                            "description" => $item->section_description,
                            "button" => array(
                                "text" => "VIEW MORE",
                                "link" => "/conference-service/".$item->code."/"
                            ),
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
                        ));
                    }

                    $sectionInfo["slides"] = $services;
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


    public function show($code){
        $service = ConferenceService::where("code",$code)->where("active",1)->first();

        if($service){
            $imageObject = new MediaField("");
            $image = $imageObject->resolveResponseValue($service->head_image);
            $tabletImage = $imageObject->resolveResponseValue($service->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($service->mobile_head_image);
            $result = array(
                "title" => $service->title,
                "seoTitle" => $service->seo_title,
                "seoDescription" => $service->seo_description,
                "template" => "conference",
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
                "sections" => array()
            );


            // Получение сервисов данного сервиса
            $services = array();
            foreach ($service->icons()->get() as $icon){
                $image = $imageObject->resolveResponseValue($icon->icon);
                array_push($services,array(
                    "title" =>  $icon->title,
                    "icon"  =>  "/storage/" . $image->path . $image->file_name
                ));
            }
            $image = $imageObject->resolveResponseValue($service->preview_image);
            $tabletImage = $imageObject->resolveResponseValue($service->tablet_preview_image);
            $mobileImage = $imageObject->resolveResponseValue($service->mobile_preview_image);

            array_push($result["sections"], array(
                "description" => $service->description,
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
                "services" => $services,
                "button" => array(
                    "text" => $service->button_text,
                    "link" => $service->button_link
                )
            ));



            // Получение рассадок
            $sittings = array();
            foreach ($service->sittings()->get() as $sitting){

                $icons = array();
                foreach ($sitting->icons()->get() as $icon){
                    $image = $imageObject->resolveResponseValue($icon->icon);
                    array_push($icons,array(
                        "title" =>  $icon->title,
                        "icon"  =>  "/storage/" . $image->path . $image->file_name
                    ));
                }

                $image = $imageObject->resolveResponseValue($sitting->image);
                $tabletImage = $imageObject->resolveResponseValue($sitting->tablet_image);
                $mobileImage = $imageObject->resolveResponseValue($sitting->mobile_image);
                $svg = $imageObject->resolveResponseValue($sitting->main_svg);

                array_push($sittings, array(
                    "title" => $sitting->title,
                    "SVG"   => "/storage/" . $svg->path . $svg->file_name,
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
                    "button" => array(
                        "text" => $sitting->button_text,
                        "link" => $sitting->button_link
                    ),
                    "services" => $icons
                ));
            }
            array_push($result["sections"],array(
                "title" => trans("controllers.ConferenceServiceSitting"),
                "slides"=> $sittings
            ));


            // Получение ценовой политики
            $offers = array();
            foreach ($service->offers()->get() as $offer){

                $icons = array();
                foreach ($offer->icons()->get() as $icon){
                    $image = $imageObject->resolveResponseValue($icon->icon);
                    array_push($icons,array(
                        "title" =>  $icon->title,
                        "icon"  =>  "/storage/" . $image->path . $image->file_name
                    ));
                }

                $image = $imageObject->resolveResponseValue($offer->image);
                $tabletImage = $imageObject->resolveResponseValue($offer->tablet_image);
                $mobileImage = $imageObject->resolveResponseValue($offer->mobile_image);

                array_push($offers, array(
                    "title" => $offer->title,
                    "description"   => $offer->description,
                    "prePrice" => ($offer->pre_price) ? $offer->pre_price : "",
                    "priceFor" => ($offer->price_for) ? $offer->price_for : "",
                    "price"    => ($offer->price) ? $offer->price : "FREE",
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
                    "button" => array(
                        "text" => $offer->button_text,
                        "link" => $offer->button_link
                    ),
                    "services" => $icons
                ));
            }
            array_push($result["sections"],array(
                "title" => trans("controllers.ConferenceServicePricePolicy"),
                "slides"=> $offers
            ));


            // Получение блока "Харчування"
            $foods = array();
            foreach ($service->food()->get() as $food){

                $image = $imageObject->resolveResponseValue($food->image);
                $tabletImage = $imageObject->resolveResponseValue($food->tablet_image);
                $mobileImage = $imageObject->resolveResponseValue($food->mobile_image);

                array_push($foods, array(
                    "title" => $food->title,
                    "description"   => $food->description,
                    "prePrice" => ($food->pre_price) ? $food->pre_price : "",
                    "priceFor" => ($food->price_for) ? $food->price_for : "",
                    "price"    => ($food->price) ? $food->price : "FREE",
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
                    "button" => array(
                        "text" => $food->button_text,
                        "link" => $food->button_link
                    ),
                ));
            }
            array_push($result["sections"],array(
                "title" => trans("controllers.ConferenceServiceFood"),
                "slides"=> $foods
            ));


            // Получения картинок для блока "Почему ми?"
            $why_images = array();
            $whyImagesIds = explode(",", $service->why_images);
            $tabletWhyImagesIds = explode(",", $service->tablet_why_images);
            $mobileWhyImagesIds = explode(",", $service->mobile_why_images);
            for ( $i=0;$i<count($whyImagesIds);$i++) {
                $image = $imageObject->resolveResponseValue($whyImagesIds[$i]);
                $tabletImage = $imageObject->resolveResponseValue($tabletWhyImagesIds[$i]);
                $mobileImage = $imageObject->resolveResponseValue($mobileWhyImagesIds[$i]);
                array_push($why_images, array(
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

            // Получение табов для блока "Почему ми?"
            $tabs = array();
            foreach($service->tabs()->get() as $tab){
                array_push($tabs, array(
                    "text" => $tab->text
                ));
            }

            array_push($result["sections"],array(
                "title" => $service->why_title,
                "images"=> $why_images,
                "tabs"  => $tabs
            ));

            //Получение картинки блока "Паркинг"
            $image = $imageObject->resolveResponseValue($service->park_image);
            $tabletImage = $imageObject->resolveResponseValue($service->tablet_park_image);
            $mobileImage = $imageObject->resolveResponseValue($service->mobile_park_image);


            array_push($result["sections"],array(
                "title" => $service->park_title,
                "description" => $service->park_description,
                "image"=> array(
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
            ));

            $page = new Page();
            $team = array(
                "title" => trans('controllers.ConferenceServiceTeamTitle'),
                "subTitle" => trans('controllers.ConferenceServiceTeamSubTitle'),
                "slides" => $page->team()
            );
            $stats = array(
                "title" => trans("controllers.ConferenceServiceItemExp"),
                "items" => $page->stats()
            );

            array_push($result["sections"], $stats);
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
