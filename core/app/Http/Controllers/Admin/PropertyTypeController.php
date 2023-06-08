<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function propertiesType(){
        $pageTitle = 'All properties';
        $emptyMessage = 'No property found';
        $propertyTypes = PropertyType::with('properties')->paginate(getPaginate());
        return view('admin.property_type.index', compact('pageTitle', 'emptyMessage', 'propertyTypes'));
    }

    public function savePropertyType(Request $request, $id=0){
        $request->validate([
            'name' => 'required',
            'image' => [
                'nullable',
                'image',
                new FileTypeValidate(['jpeg', 'jpg', 'png'])],
        ]);

        $propertyType = new PropertyType();
        $status = 1;
        $oldImage = null;
        $notification = ' added successfully';
        $filename = '';

        if($id){
            $propertyType = PropertyType::findOrFail($id);
            $status = $request->status ? 1 : 0;
            $oldImage = $propertyType->image;
            $notification = ' updated successfully';
            $filename = $request->hasFile('image') ? '' : $propertyType->image;
            $filename = $request->old_image ? $filename : '';
        }

        $path = imagePath()['property_type']['path'];
        $size = imagePath()['property_type']['size'];
        
        if ($request->hasFile('image')) {
            try {
                $filename = uploadImage($request->image, $path, $size, $oldImage);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }

        $propertyType->name  = $request->name;
        $propertyType->image = $filename;
        $propertyType->status = $status;
        $propertyType->save();

        $notify[] = ['success', $request->name.$notification];
        return back()->withNotify($notify);

    }
}
