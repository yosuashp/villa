<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Location;
use App\Models\Owner;
use App\Models\Property;
use App\Models\PropertyType;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function properties(){
        $pageTitle = 'All Properties';
        $emptyMessage = 'No property found';
        $properties = Property::with('propertyType', 'location', 'rooms', 'roomCategories')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.property.index', compact('pageTitle', 'emptyMessage', 'properties'));
    }

    public function create(){
        $pageTitle = 'Create New Property';
        $propertyTypes = PropertyType::where('status', 1)->get();
        $locations = Location::where('status', 1)->get();
        $amenities = Amenity::where('status', 1)->get();

        return view('admin.property.create', compact('pageTitle', 'propertyTypes', 'locations', 'amenities'));
    }

    public function edit($id){
        $pageTitle = 'Update Property';
        $property = Property::findOrFail($id);
        $propertyTypes = PropertyType::where('status', 1)->get();
        $locations = Location::where('status', 1)->get();
        $amenities = Amenity::where('status', 1)->get();

        return view('admin.property.edit', compact('pageTitle', 'property', 'propertyTypes', 'locations', 'amenities'));

    }

    public function saveProperty(Request $request, $id=0){
   
        $request->validate([
            'name' => 'required',
            'image' => ['sometimes','image',new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'property_type' => 'required',
            'location' => 'required',
            'phone' => 'required',
            'phone_call_time' => 'required',
            'star' => 'required|numeric|min:1',
            'owner' => 'sometimes|exists:owners,username',
            'extra_features' => 'sometimes|array',
            'amenity' => 'sometimes|array',
            'amenity.*' => 'required',
            'images' => 'sometimes|array',
            'images.*'=>[ 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'change_images' => 'sometimes|array',
            'change_images.*'=>[ 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            ]);

            $property = new Property();
            $status = 1;
            $oldImage = null;
            $notification = 'Property added successfully';
            $filename = '';
            $multipleImages = [];
        
            $path = imagePath()['property']['path'];
            $size = imagePath()['property']['size'];

            if($id){
                $property = Property::findOrFail($id);
                $property->top_reviewed = $request->top_reviewed ? 1 : 0;
                $status = $request->status ? 1 : 0;
                $oldImage = $property->image;
                $notification = 'Property updated successfully';
                $filename = $request->hasFile('image') ? '' : $property->image;
                $multipleImages = $property->images;
                if($request->old_images){
                    $oldImages = explode(',', $request->old_images);
                    $multipleImages = array_values(array_intersect($multipleImages, $oldImages));
                }

                if ($request->hasFile('change_images')) {
                    foreach($request->change_images as $key => $change_image){
                        try {
                            $filename = uploadImage($change_image, $path, $size);
                            array_splice($multipleImages, $key, 0, $filename);
                        } catch (\Exception $exp) {
                            $notify[] = ['error', 'Image could not be uploaded.'];
                            return back()->withNotify($notify);
                        }
                    }
                }
            }


            if ($request->hasFile('image')) {
                try {
                    $filename = uploadImage($request->image, $path, $size, $oldImage);
                } catch (\Exception $exp) {
                    $notify[] = ['error', 'Image could not be uploaded.'];
                    return back()->withNotify($notify);
                }
            }

            if ($request->hasFile('images')) {
                for($i=0; $i < count($request->images); $i++){
                    try {
                        $filename = uploadImage($request->images[$i], $path, $size);
                        array_push($multipleImages, $filename);
                    } catch (\Exception $exp) {
                        $notify[] = ['error', 'Image could not be uploaded.'];
                        return back()->withNotify($notify);
                    }
                }
            }

            $owner = Owner::where('username', $request->owner)->first();

            $property->name = $request->name;
            $property->property_type_id = $request->property_type;
            $property->owner_id =  $owner ? $owner->id : $property->owner_id;
            $property->location_id = $request->location;
            $property->phone = $request->phone;
            $property->phone_call_time = $request->phone_call_time;
            $property->discount = $request->discount;
            $property->map_url = $request->map_url;
            $property->description = $request->description;
            $property->image = $filename;
            $property->images = $multipleImages;
            $property->star = $request->star;
            $property->extra_features = $request->extra_features;
            $property->status = $status;
            $property->save();
            $notify[] = ['success', $notification];
            return back()->withNotify($notify)->withInput();
    }

}
