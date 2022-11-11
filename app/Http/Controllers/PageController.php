<?php

namespace App\Http\Controllers;

use App\Models\ConferenceService;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\SocialNetwork;
use App\Models\ContactItem;
use App\Models\MapPin;
use App\Models\Address;
use App\Models\Footer;
use App\Models\MainMenu;
use App;
use OptimistDigital\MediaField\MediaField;
use function Spatie\Ignition\ErrorPage\title;


class PageController extends Controller
{

    public function index()
    {
        $seoBlock = Page::where("section_name","home")->first();
        if ($seoBlock) {
            $imageObject = new MediaField("");

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);

            $result = array(
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "template" => "home",
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
                        "desktop" =>$_SERVER["APP_URL"]. "/storage/" . $image->path . $image->file_name,
                    )
                )
            );



            $result["sections"] = array();

            $sections = Page::where("show_on_main", "1")->get()->sortBy("sort");

            foreach ($sections as $section) {
                $sectionResult = array(
                    "id" => $section->id,
                    "sectionName" => $section->section_name,
                    "title" => $section->section_title,
                    "contentTop" => $section->header_one,
                    "contentBottom" => $section->header_two
                );
                if ($section->reserve_text)
                    $sectionResult["book"] = array(
                        "title" => $section->reserve_text,
                        "link" => $section->reserve_link
                    );

                if ($section->more_text)
                    $sectionResult["more"] = array(
                        "title" => $section->more_text,
                        "link" => $section->more_link
                    );

                if ($section->work_start && $section->work_end)
                    $sectionResult["worktime"] = mb_strimwidth($section->work_start, 0, 5) . " до " . mb_strimwidth($section->work_end, 0, 5);

                if ($section->section_image) {
                    $image = $imageObject->resolveResponseValue($section->section_image);
                    $tabletImage = $imageObject->resolveResponseValue($section->tablet_section_image);
                    $mobileImage = $imageObject->resolveResponseValue($section->mobile_section_image);
                    $sectionResult["image"] = array(
                        "webp" => array(
                            "mobile"  => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->webp_name,
                            "tablet"  => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->webp_name,
                            "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->webp_name,
                        ),
                        "jpg" => array(
                            "mobile"  => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->file_name,
                            "tablet"  => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->file_name,
                            "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->file_name,
                        )
                    );
                }
                array_push($result["sections"], $sectionResult);
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



    public function footer(){
        $footerObject = new Footer();
        $result = $footerObject->show();
        return response()->json([
            'status' => 'success',
            'content' => $result
        ]);
    }

    public function header(){
        $header = Page::where("section_name","home")->first();

        if ($header) {
            $map = MapPin::where("is_center",1)->first();
            $call_us = ContactItem::where("call_us",1)->first();
            $imageObject = new MediaField("");


            $result = array(
                "language"  => App::getLocale(),
                "book"      => array(
                    "title" => $header->reserve_text,
                    "link"  => $header->reserve_link
                ),
                "offer" => array(
                    "title" => $header->more_text,
                    "link" => $header->more_link
                ),
                "address" => array(
                    "icon" => "icon-map-pin",
                    "link" => $map->link
                ),
            );
            if($call_us){
                $result["call"] = array(
                    "text" => 'Call us',
                    "phone" => $call_us->title,
                    "link" => $call_us->link,
                );
            }

            $socials = SocialNetwork::where("active", "1")->get()->sortBy("sort");
            $result["social"] = array();
            foreach ($socials as $social){
                array_push($result["social"], array(
                    "icon" => $social->svg,
                    "link" => $social->link
                ));
            }


            $defaultMenuItem = MainMenu::where("is_default",1)->first();
            $image = $imageObject->resolveResponseValue($defaultMenuItem->background_image);
            $tabletImage = $imageObject->resolveResponseValue($defaultMenuItem->tablet_background_image);
            $mobileImage = $imageObject->resolveResponseValue($defaultMenuItem->mobile_background_image);

            $result["menu"] = array(array(
                "title" => $defaultMenuItem->title,
                "image" => array(
                    "webp" => array(
                        "mobile" => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->webp_name,
                        "tablet" => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->webp_name,
                        "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->webp_name,
                    ),
                    "jpg" => array(
                        "mobile"  => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->file_name,
                        "tablet"  => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->file_name,
                        "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->file_name,
                    )
                ))
            );

            $menuItems = MainMenu::where("is_default",0)->get();

            foreach ($menuItems as $item){
                $image = $imageObject->resolveResponseValue($item->background_image);
                $tabletImage = $imageObject->resolveResponseValue($item->tablet_background_image);
                $mobileImage = $imageObject->resolveResponseValue($item->mobile_background_image);
                array_push($result["menu"], array(
                    "title" => $item->title,
                    "link"  => is_null($item->link) ? "#" : $item->link,
                    "image" => array(
                        "webp" => array(
                            "mobile"  => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->webp_name,
                            "tablet"  => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->webp_name,
                            "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->webp_name,
                        ),
                        "jpg" => array(
                            "mobile"  => $_SERVER["APP_URL"]."/storage/" . $mobileImage->path . $mobileImage->file_name,
                            "tablet"  => $_SERVER["APP_URL"]."/storage/" . $tabletImage->path . $tabletImage->file_name,
                            "desktop" => $_SERVER["APP_URL"]."/storage/" . $image->path . $image->file_name,
                        )
                    )
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

    public function sitemap(){
        $result["links"] = array(
            "https://city-inn.com.ua/",
            "https://city-inn.com.ua/restaurant-sviatoslav/",
            "https://city-inn.com.ua/lobby-bar/",
            "https://city-inn.com.ua/about/",
            "https://city-inn.com.ua/starfit/",
            "https://city-inn.com.ua/smart-offer/",
            "https://city-inn.com.ua/group-request/",
            "https://city-inn.com.ua/rooms/",
            "https://city-inn.com.ua/conference-service/",
        );

        $rooms = Room::where("active", 1)->get();
        foreach ($rooms as $room)
            array_push($result["links"], "https://city-inn.com.ua/rooms/".$room->code);

        $conferenceServices = ConferenceService::where("active", 1)->get();
        foreach ($conferenceServices as $service)
            array_push($result["links"], "https://city-inn.com.ua/conference-service/".$service->code);

        return response()->json([
            'status' => 'success',
            'content' => $result
        ]);

    }
}
