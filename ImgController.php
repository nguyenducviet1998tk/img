<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;
use App\Img;
use App\User;

class ImgController extends Controller
{

    public function store(Request $request)
    {
        // Check ảnh
        
        $rule = ["hinhanh" => "required","hinhanh" => "required|image"];
        $messages = ["hinhanh.required" => "Hình ảnh không được để trống","hinhanh.image" => "Phải là hình ảnh",];
        $this->validate($request, $rule, $messages);
            
        // // end check ảnh

        // //info ảnh
        $description = date('d/m/Y H:i:s.uP');
        $folder = 'files/'.Auth::user()->id;
        File::makeDirectory($folder, 0777, true, true);
        $namefileold = $request['hinhanh']->getClientOriginalName();
        $extension = $request['hinhanh']->getClientOriginalExtension();
        $namefilenew = str_slug($description).'.'.$extension;
        $namefilethumbnail = str_slug($description).'_thumbnail'.'.'.$extension;
        $img = Image::make($request['hinhanh']);
        $img_thumbnail = Image::make($request['hinhanh'])->fit(300,240);
        $size = $img->filesize();
       
        // end info ảnh

        // điều kiện nén và lưu ảnh sever

        if($size >= 5000000) 
        {
            $qualty = 5;
        }
        else if($size >= 4000000) 
        {
            $qualty = 30;
        }
        else if($size >= 3000000) 
        {
            $qualty = 40;
        }
        else if($size >= 2000000) 
        {
            $qualty = 50;
        }
        else if($size >= 1000000) 
        {
            $qualty = 65;
        }
        else if($size < 1000000) 
        {
            $qualty = 89;
        }
        $img->save($folder.'/'.$namefilenew, $qualty);
        $img_thumbnail->save($folder.'/'.$namefilethumbnail, 60);

        // end điều kiện nén và lưu ảnh sever

        // lưu databse

        $img = new Img();
        $img->name = $namefilenew;
        $img->description = $request['description'];
        $img->images = $folder.'/'.$namefilenew;
        $img->thumbnail = $folder.'/'.$namefilethumbnail;
        $img->user_id = Auth::user()->id;
        $img->save();
        // end lưu databse
        return redirect()->action('ImgController@index');
    }

   
}
