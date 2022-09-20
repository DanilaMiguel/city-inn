<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\MapPin;
use App\Models\Page;
use App\Models\Contact;
use Illuminate\Http\Request;
use App;

class ContactController extends Controller
{
    public function index(){
        $map = MapPin::where("is_center",1)->first();
        $addresses = Address::where("active",1)->get();
        $addressItems = array();
        foreach ($addresses as $address){
            array_push($addressItems,array(
                "text" => $address->text,
                "link" => is_null($address->link) ? "" : $address->link
            ));
        }


        $contacts = Contact::where("active",1)->get()->sortBy("sort");
        $contactBlock = Page::where("section_name","contacts")->first();

        if($contactBlock) {

            $result = array(
                "title" => $contactBlock->title,
                "language"  => App::getLocale(),
                "map" => array(
                    "key" => $map->map_key,
                    "center" => array(
                        "lat" => $map->latitude,
                        "lng" => $map->longitude
                    ),
                    "zoom" => $map->zoom
                ),
                "columns" => array(),
                "book" => array(
                    "title" => $contactBlock->reserve_text,
                    "link" => $contactBlock->reserve_link
                )
            );


            foreach ($contacts as $contact) {
                $contactItems = $contact->items()->get();
                $contactInfo = array();
                foreach ($contactItems as $item) {
                    array_push($contactInfo, array(
                        "text" => $item->title,
                        "link" => is_null($item->link) ? "" : $item->link
                    ));
                }
                array_push($result["columns"], array(
                    "title" => $contact->title,
                    "items" => $contactInfo
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

}
