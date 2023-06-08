<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function locations(){
        $pageTitle = 'All Locations';
        $emptyMessage = 'No location found';
        $locations = Location::with('properties')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.location.index', compact('pageTitle', 'emptyMessage', 'locations'));
    }

    public function saveLocation(Request $request, $id=0){
        $request->validate([
            'name' => 'required',
            'average_price'=> 'required|numeric|gt:0',
            'image' => [
                'nullable',
                'image',
                new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            ]);

        $location = new Location();
        $location->status = 1;
        $notification = ' added successfully';
        if($id){
            $location = Location::findOrFail($id);
            $location->status = $request->status ? 1 : 0;
            $notification = ' updated successfully';
        }
        $filename = $location->image;

        $path = imagePath()['location']['path'];
        $size = imagePath()['location']['size'];
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size, $location->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $location->name  = $request->name;
        $location->average_price  = $request->average_price;
        $location->image = $filename;
        $location->save();
        $notify[] = ['success', $request->name.$notification];
        return back()->withNotify($notify);

    }
}
