<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Advertise;


class AdvertiseController  extends Controller
{
    public function advertiseListing(Request $request) {
        return view('admin.advertise.index');
    }
    
    public function addAdvertise() {
        return view('admin.advertise.add');
    }
    
    public function storeAdvertise(Request $request) {
        try{
            
            $validator = Validator::make($request->all(), [
                'language' => 'required',
                'title' => 'required',
                'desc' => 'required',
            ]);
            if($request->file('ads_file') !=  ''){
                $ads_file = $request->file('ads_file');
                $extension = $ads_file->getClientOriginalExtension();
                $validExt = array('gif','ief','jpeg','png','mp4','mov','svg');
                if(!in_array(strtolower($extension),$validExt)){
                    $validator->getMessageBag()->add('ads_file', 'Please upload valid file.');
                }
                
            }
            if($validator->fails()){
                return redirect('admin/advertise/add')
                            ->withErrors($validator)
                            ->withInput();
            }
//            $filename = basename($fileName);
//            $fileType = mime_content_type($path.'/'.$filename);
//            
//            $ads = Advertise();
//            $ads->title = $request->title;
//            $ads->description = $request->desc;
//            $ads->language_id = $request->language;
//            $ads->save();
//           echo "<pre>";print_R($request->all());exit;
       }catch(Exception $e){
            return Response::json(array('message'=>'Something is wrong.Please try again!','status'=>'error'));
        }
    }
}
