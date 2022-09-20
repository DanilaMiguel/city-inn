<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Document;
use App\Models\DocumentItem;
use Illuminate\Http\Request;
use OptimistDigital\MediaField\MediaField;
use App;

class DocumentController extends Controller
{
    public function publicOffer(){
        $seoBlock = Page::where("section_name","public-offer")->first();
        if ($seoBlock) {
            $imageObject = new MediaField("");

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);
            $result = array(
                "title" => $seoBlock->title,
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "template" => "text-page",
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
                "content" => array(
                    "items" => array()
                )
            );

            $document = Document::where("doc_code", "public-offer")->first();

            foreach ($document->items()->get() as $item){
                $description = $item->description;
                $description = str_replace('<h1>', '<h3>', $description);
                $description = str_replace('</h1>', '</h3>', $description);
                $description = str_replace('<br>', '', $description);
                array_push($result["content"]["items"], array(
                    "title"   => $item->title,
                    "content" => $description
                ));
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

    public function privacyPolicy(){
        $seoBlock = Page::where("section_name","privacy-policy")->first();
        if ($seoBlock) {
            $imageObject = new MediaField("");

            $image = $imageObject->resolveResponseValue($seoBlock->head_image);
            $tabletImage = $imageObject->resolveResponseValue($seoBlock->tablet_head_image);
            $mobileImage = $imageObject->resolveResponseValue($seoBlock->mobile_head_image);
            $result = array(
                "title" => $seoBlock->title,
                "seoTitle" => $seoBlock->seo_title,
                "seoDescription" => $seoBlock->seo_description,
                "template" => "text-page",
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
                "content" => array(
                    "items" => array()
                )
            );

            $document = Document::where("doc_code", "privacy-policy")->first();

            foreach ($document->items()->get() as $item){
                $description = $item->description;
                $description = str_replace('<h1>', '<h3>', $description);
                $description = str_replace('</h1>', '</h3>', $description);
                $description = str_replace('<br>', '', $description);
                array_push($result["content"]["items"], array(
                    "title"   => $item->title,
                    "content" => $description
                ));
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
