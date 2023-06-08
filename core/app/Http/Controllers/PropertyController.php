<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\BookedProperty;
use App\Models\BookedRoom;
use App\Models\Location;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Review;
use App\Models\Room;
use App\Models\RoomCategory;
use Carbon\Carbon;

use Illuminate\Http\Request;

class PropertyController extends Controller
{
    protected $checkInDate;
    protected $checkOutDate;

    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function propertySearch(Request $request){

        if($request->date){
            $date = explode(' - ', $request->date);

            $request->merge([
                'check_in_date' => $date[0],
                'check_out_date' => @$date[1],
            ]);

            $request->validate([
                'check_in_date' => 'required|date_format:m/d/Y|after:yesterday',
                'check_out_date' => 'required|date_format:m/d/Y|after:check_in_date',
            ]);

            $this->checkInDate = Carbon::parse($request->check_in_date);
            $this->checkOutDate = Carbon::parse($request->check_out_date);
        }

        session()->put('search-data', $request->all());

        $pageTitle      = 'Search Property';
        $emptyMessage = 'No property found';
        $locationId     = $request->location;
        $locations      = Location::where('status', 1)->get();
        $propertyTypes  = PropertyType::where('status', 1)->get();
        $amenities      = Amenity::with('roomCategories')->where('status', 1)->get();

        $properties = Property::where('status',1);

        if($locationId){
            $properties = $properties->where('location_id', $locationId);
        }

        if($request->propertyType){
            $properties = $properties->where('property_type_id', $request->propertyType);
        }

        $stars = clone $properties;
        $stars = $stars->groupBy('star')->select('star')->selectRaw('count(*) as total')->get();

        if ($request->date) {
            $properties = $properties->with(['location','rooms'=>function($room){
                    $room->where('status',1);
                }, 'bookedRooms'=>function($bookedRooms){
                $bookedRooms->where(function($q){
                    $q->where(function($qq){
                        $qq->where('date_from','<=',$this->checkInDate)->where('date_to','>',$this->checkInDate);
                    })->orWhere(function($qqq){
                        $qqq->where('date_from','<',$this->checkOutDate)->where('date_to','>=',$this->checkOutDate);
                    });
                });
            }]);
        }else{
            $properties = $properties->with(['location','rooms'=>function($room){
                    $room->where('status',1);
                }, 'bookedRooms'=>function($bookedRooms){
                $bookedRooms->where(function($q){
                    $q->where(function($qq){
                        $qq->where('date_from','>',now())->where('date_to','>',now());
                    });
                });
            }]);
        }

        $properties = $properties->whereHas('location', function($location){
            $location->where('status', 1);
        })
        ->whereHas('rooms', function($room){
            $room->where('status', 1);
        })
        ->paginate(getPaginate(15));


        return view($this->activeTemplate.'property.search', compact('pageTitle', 'emptyMessage', 'locations', 'propertyTypes', 'amenities', 'stars', 'properties', 'request'));
    }


    public function propertySearchFilter(Request $request){
        $emptyMessage = 'No properties found';
        $searchData = $request->searchData;

        $properties = Property::where('status', 1);

        if ($searchData['location']) {
            $properties = $properties->where('location_id', $searchData['location']);
        }

        if ($request->propertyType) {
            $properties = $properties->where('property_type_id', $request->propertyType);
        }

        if ($request->starLevels) {
            $properties = $properties->whereIn('star', $request->starLevels);
        }

        if ($request->amenities) {
            $properties = $properties->whereHas('roomCategories.amenities', function($amenities) use($request){
                $amenities->whereIn('amenity_id', $request->amenities);
            });
        }

        if ($request->minPrice) {
            $properties = $properties->whereHas('rooms', function($room) use($request){
                $room->where('price', '>=', $request->minPrice);
            });
        }

        if ($request->maxPrice) {
            $properties = $properties->whereHas('rooms', function($room) use($request){
                $room->where('price', '<=', $request->maxPrice);
            });
        }

        if($request->searchData['date']){
            $date = explode(' - ', $request->searchData['date']);
            $this->checkInDate = Carbon::parse($date[0]);
            $this->checkOutDate = Carbon::parse(@$date[1]);

            $properties = $properties->with(['location','rooms'=>function($room){
                    $room->where('status',1);
                }, 'bookedRooms'=>function($bookedRooms){
                $bookedRooms->where(function($q){
                    $q->where(function($qq){
                        $qq->where('date_from','<=',$this->checkInDate)->where('date_to','>',$this->checkInDate);
                    })->orWhere(function($qqq){
                        $qqq->where('date_from','<=',$this->checkOutDate)->where('date_to','>=',$this->checkOutDate);
                    });
                });
            }]);

        }else{
            $properties = $properties->with(['location','rooms', 'bookedRooms','roomCategories.amenities']);
        }

        $properties = $properties->whereHas('rooms', function($room){
                                        $room->where('status', 1);
                                   })
                                   ->paginate(getPaginate(15));

        return view($this->activeTemplate.'property.search_filter', compact('emptyMessage', 'properties', 'searchData'));

    }

    public function propertyDetail($id, $slug){
        $pageTitle = 'Property Details';
        $property = Property::where('id', $id)
        ->with(['rooms', 'roomCategories.amenities', 'reviews.user'=>function($review){
            $review->limit(1);
        }])
        ->firstOrFail();

        $property->reviews()->paginate(getPaginate(1));

        $lowestRoomPrice = 0;

        if(count($property->rooms)){
            $lowestRoomPrice = $property->rooms[0]->price;
            foreach ($property->rooms as $room) {
                if($lowestRoomPrice > $room->price){
                    $lowestRoomPrice = $room->price;
                }
            }
        }

        for($i=1; $i<=5; $i++){
            $reviewCount[$i] = $property->reviews->where('rating', $i)->count();
        }
        return view($this->activeTemplate.'property.property_details', compact('pageTitle', 'property', 'lowestRoomPrice', 'reviewCount'));
    }

    public function roomsByCategory(Request $request){
        $pageTitle = 'Property Details';
        $property = Property::with('rooms', 'roomCategories.amenities')->findOrFail($request->propertyId);

        if($request->date){
            $date = explode(' - ', $request->date);

            $request->merge([
                'check_in_date' => $date[0],
                'check_out_date' => @$date[1],
            ]);

            $request->validate([
                'check_in_date' => 'required|date_format:m/d/Y|after:yesterday',
                'check_out_date' => 'required|date_format:m/d/Y|after:check_in_date',
            ]);

            session()->put('search-data', $request->all());
        }

        $searchData = session()->get('search-data');

        if (!$searchData || ($searchData && $searchData['date'] == null))  {
            $roomCategories = RoomCategory::where('property_id', $request->propertyId)->with('amenities')->get();
            return view($this->activeTemplate.'property.property_category_rooms',  compact('pageTitle', 'property', 'roomCategories', 'request'));
        }



        $this->checkInDate = Carbon::parse($searchData['check_in_date']);
        $this->checkOutDate = Carbon::parse($searchData['check_out_date']);

        $roomCategories = RoomCategory::where('property_id', $request->propertyId)
                                       ->with(['amenities', 'rooms'=>function($room){
                                           $room->where('status',1);
                                       }, 'bookedRooms'=>function($bookedRooms){
                                            $bookedRooms->where(function($q){
                                                $q->where(function($qq){
                                                    $qq->where('date_from','<=',$this->checkInDate)->where('date_to','>',$this->checkInDate);
                                                })->orWhere(function($qqq){
                                                    $qqq->where('date_from','<=',$this->checkOutDate)->where('date_to','>=',$this->checkOutDate);
                                                });
                                            });
                                        }])->get();


        return view($this->activeTemplate.'property.property_category_rooms',  compact('pageTitle', 'property', 'roomCategories', 'request'));
    }

    public function bookingProcess(Request $request)
    {
        $request->validate([
            'room_list' => 'required'
        ],[
            'room_list.required' => 'Please select minimum one room.'
        ]);

        $totalPrice = 0;
        $roomList = explode(',', $request->room_list);

        $date = explode(' - ', $request->date);
        $request->merge([
            'check_in_date' => $date[0],
            'check_out_date' => @$date[1],
        ]);
        $request->validate([
            'check_in_date' => 'required|date_format:m/d/Y|after:yesterday',
            'check_out_date' => 'required|date_format:m/d/Y|after:check_in_date',
        ]);

        $checkInDate = Carbon::parse($request->check_in_date);
        $checkOutDate = Carbon::parse($request->check_out_date);

        $totalDays = $checkInDate->diffInDays($checkOutDate);

        if($checkInDate == $checkOutDate){
            $notify[] = ['error', 'Check in and Check out date should not be same !'];
            return back()->withNotify($notify);
        }

        $rooms = Room::where('status',1)->whereIn('id',$roomList)->with(['bookedRooms'=>function($bookedRooms) use ($checkInDate,$checkOutDate){
            $bookedRooms->where(function($q) use ($checkInDate,$checkOutDate){
                $q->where(function($qq) use ($checkInDate,$checkOutDate){
                    $qq->where('date_from','<=',$checkInDate)->where('date_to','>',$checkInDate);
                })->orWhere(function($qqq) use ($checkInDate,$checkOutDate){
                    $qqq->where('date_from','<=',$checkOutDate)->where('date_to','>=',$checkOutDate);
                });
            });
        }])->get();

        foreach ($rooms as $room) {
            if($room->bookedRooms->count() > 0){
                $notify[] = ['error','Some rooms has already booked'];
                return back()->withNotify($notify);
            }
        }

        if ($rooms->count() <= 0) {
            $notify[] = ['error','There is no room found'];
            return back()->withNotify($notify);
        }
        $myRooms = clone $rooms;

        $totalPrice = $rooms->sum('price');
        $property = $rooms->first()->property;

        $discount = $property->discount;
        if ($discount != 0) {
            $totalPrice -= ($totalPrice * $discount / 100);
        }
        $totalPrice = $totalPrice * $totalDays;

        $bookedProperty = new BookedProperty();
        $bookedProperty->property_id = $property->id;
        $bookedProperty->user_id = auth()->id();
        $bookedProperty->total_price = $totalPrice;
        $bookedProperty->date_from = $checkInDate;
        $bookedProperty->date_to = $checkOutDate;
        $bookedProperty->save();

        foreach ($myRooms as $room) {
            $bookedRoom = new BookedRoom();
            $bookedRoom->booked_property_id = $bookedProperty->id;
            $bookedRoom->property_id = $property->id;
            $bookedRoom->room_category_id = $room->roomCategory->id;
            $bookedRoom->room_id = $room->id;
            $bookedRoom->price = $discount == 0 ?  $room->price*$totalDays : ($room->price * (100-$discount)/100)*$totalDays;
            $bookedRoom->date_from = $checkInDate;
            $bookedRoom->date_to = $checkOutDate;
            $bookedRoom->save();
        }

        session()->put('checkout_data',[
            'totalPrice'=>$totalPrice,
            'booked_property'=>$bookedProperty,
        ]);


        return redirect()->route('user.deposit');

    }

    public function reviewLoad(Request $request)
    {
        $page = $request->page;
        $reviews = Review::where('property_id', $request->propertyId)->with('user')->orderBy('id', 'DESC')->skip($page)->take($page)->get();
        return view($this->activeTemplate.'property.review_load',  compact('reviews'));
    }



}
