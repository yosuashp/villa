<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Property;
use App\Models\Room;
use App\Models\RoomCategory;
use Illuminate\Http\Request;

class RoomCategoryController extends Controller
{
    public function roomCategories(){
        $pageTitle = 'Room Categories';
        $emptyMessage = 'No category found';
        $roomCategories = RoomCategory::with('property', 'rooms', 'property.owner')
        ->orderBy('property_id', 'DESC')
        ->paginate(getPaginate());

        return view('admin.room_category.index', compact('pageTitle', 'emptyMessage', 'roomCategories'));
    }

    public function roomCategoriesByProperty($property, $id){
        $pageTitle = 'Room Categories';
        $emptyMessage = 'No category found';
        $roomCategories = RoomCategory::with('property', 'rooms')
        ->whereHas('property', function($property) use($id) {
            $property->where('id', $id);
        })
        ->paginate(getPaginate());

        return view('admin.room_category.index', compact('pageTitle', 'emptyMessage', 'roomCategories'));
    }

    public function create(){
        $pageTitle = 'Create Room Category';
        $properties = Property::select('id', 'name')->get();
        $amenities = Amenity::where('status', 1)->get();

        return view('admin.room_category.create', compact('pageTitle', 'properties', 'amenities'));
    }

    public function store(Request $request){
        $request->validate([
            'room_category' => 'required',
            'property' => 'required',
            'amenities' => 'array',
            'amenities.*' => 'gt:0|integer',
            'room_number' => 'sometimes|array',
            'room_number.*' => 'required',
            'adult' => 'sometimes|array',
            'adult.*' => 'required|min:1|integer',
            'child' => 'sometimes|array',
            'child.*' => 'required|min:0|integer',
            'price' => 'sometimes|array',
            'price.*' => 'required|numeric|gt:0'
        ]);

        $property = Property::findOrFail($request->property);

        $roomCategory = new RoomCategory();
        $roomCategory->name = $request->room_category;
        $roomCategory->property_id = $property->id;
        $roomCategory->save();

        $roomCategory->amenities()->sync($request->amenities);
        if($request->room_number){
            foreach ($request->room_number as $key => $roomNumber) {
                $room = new Room();
                $room->room_number = $roomNumber;
                $room->adult = $request->adult[$key];
                $room->child = $request->child[$key];
                $room->price = $request->price[$key];
                $room->property_id = $property->id;
                $room->owner_id = $property->owner_id;
                $room->room_category_id = $roomCategory->id;
                $room->save();
            } 
        }

        $notify[] = ['success', 'Category added successfully'];
        return back()->withNotify($notify);
    }

    public function edit($id){
        $pageTitle = 'Update Room Category';

        $roomCategory = RoomCategory::with('property')->findOrFail($id);
        $amenities = Amenity::where('status', 1)->get();

        return view('admin.room_category.edit', compact('pageTitle', 'amenities', 'roomCategory')); 
    }

    public function update(Request $request, $id){
        $request->validate([
            'room_category' => 'required',
            'amenities' => 'array',
            'amenities.*' => 'gt:0|integer',
            'old_room_number' => 'sometimes|array',
            'old_room_number.*' => 'required',
            'old_room_id' => 'sometimes|array',
            'old_room_id.*' => 'required',
            'old_adult' => 'sometimes|array',
            'old_adult.*' => 'required|min:1|integer',
            'old_child' => 'sometimes|array',
            'old_child.*' => 'required|min:0|integer',
            'old_price' => 'sometimes|array',
            'old_price.*' => 'required|numeric|gt:0',
            'room_number' => 'sometimes|array',
            'room_number.*' => 'required',
            'adult' => 'sometimes|array',
            'adult.*' => 'required|min:1|integer',
            'child' => 'sometimes|array',
            'child.*' => 'required|min:0|integer',
            'price' => 'sometimes|array',
            'price.*' => 'required|numeric|gt:0'
        ]);

      

        $roomCategory = RoomCategory::findOrFail($id);

        $roomCategory->name = $request->room_category;
        $roomCategory->save();

        $roomCategory->amenities()->sync($request->amenities);

        if($request->old_room_id){
            foreach ($request->old_room_id as $key => $roomId) {

                $room = Room::findOrFail($roomId);
                $status = 'status_'.$roomId;
                $room->room_number = $request->old_room_number[$key];
                $room->adult = $request->old_adult[$key];
                $room->child = $request->old_child[$key];
                $room->price = $request->old_price[$key];
                $room->status = $request->$status ? 1 : 0;
                $room->save();
            }
        }
      
        if($request->room_number){
            foreach ($request->room_number as $key => $roomNumber) {
                $room = new Room();
                $room->room_number = $roomNumber;
                $room->adult = $request->adult[$key];
                $room->child = $request->child[$key];
                $room->price = $request->price[$key];
                $room->property_id = $roomCategory->property_id;
                $room->owner_id = $roomCategory->property->owner_id;
                $room->room_category_id = $roomCategory->id;
                $room->save();
            } 
        }

        $notify[] = ['success', 'Category updated successfully'];
        return back()->withNotify($notify);

    }
}
