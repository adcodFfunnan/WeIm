<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UploadImages extends Controller
{
    function index()
    {
    	return view('index');

    }

    function upload(Request $request)
    {
        $timeStart=microtime(true);
        

        $validator=Validator::make($request->all(),[
            'select_file.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000'
        ]);
        if ($validator->passes())
            {

                if($request->hasFile('select_file'))
                {
                    switch ($request->input('upload')) 
                    {
                        case 'UploadAsNew':                           /*User press UploadAsNew Button*/
                            $images=$request->file('select_file');
                            $createAccessLink=$this->generateRandomString();  /*Generate folder name which is acces key*/
                            foreach ($images as $image)
                            {
                                $image->store("weIm_base/".$createAccessLink);
                            }
                            $timeEnd=microtime(true);
                            $processTime=$timeEnd-$timeStart;
                            return back()->with('processingTime',$processTime)->with('links',$this->getImages($createAccessLink))->with('accessLink',$createAccessLink);
                        

                        case 'AddToExisting':                       /*User press AddToExisting Button*/
                            $images=$request->file('select_file');
                            if($request->input('accessLink')!="")        /*(in case user want to add on empty list) */
                            {
                                $images=$request->file('select_file');
                                $getAccessLink=$request->input('accessLink');
                                foreach ($images as $image)
                                {
                                    $image->store("weIm_base/".$getAccessLink);
                                }
                            $timeEnd=microtime(true);
                            $processTime=$timeEnd-$timeStart;
                            return back()->with('processingTime',$processTime)->with('links',$this->getImages($getAccessLink))->with('accessLink',$getAccessLink);
                            }                 
                    }   
                }     
            }
        return back()->with('validationFails',"true");					
    }

    function delete(Request $request)
    {
        Storage::delete($request->input('ImgForDel'));$getImagesPath=array();
        $getImagesPath=$this->getImages($request->input('accessLink'));
        return back()->with('links',$getImagesPath)->with("accessLink",$request->input('accessLink'));     
    }
    
    function accessWithLink(Request $request)
    {
        return back()->with('links',$this->getImages($request->input('accessLink')))->with('accessLink',$request->input('accessLink')); 
    }

    /*auxiliary methods*/
    function getImages($from_where)
    {
        $paths=array();
        $paths=Storage::files("weIm_base/".$from_where);
        return $paths;
    }

    function generateRandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters); $randomString = '';
        $i=0;
        while($i<10) 
        {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
        ++$i;
        }
        return $randomString;
    }    
}

