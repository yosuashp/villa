<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function amenities(){
        $pageTitle = 'All Amenities';
        $emptyMessage = 'No amenity found';
        $amenities = Amenity::orderBy('id', 'DESC')->paginate(getPaginate());
        return view('admin.amenity.index', compact('pageTitle', 'emptyMessage', 'amenities'));
    }

    public function saveAmenity(Request $request, $id=0){
        $request->validate([
            'name' => 'required',
            'icon' => 'required'
        ]);

        $amenity = new Amenity();
        $status = 1;
        $notification = ' added successfully';

        if($id){
            $amenity = Amenity::findOrFail($id);
            $status = $request->status ? 1 : 0;
            $notification = ' updated successfully';
        }

        $amenity->name  = $request->name;
        $amenity->icon  = $request->icon;
        $amenity->status  = $status;
        $amenity->save();

        $notify[] = ['success', $request->name.$notification];
        return back()->withNotify($notify);

    }
}
