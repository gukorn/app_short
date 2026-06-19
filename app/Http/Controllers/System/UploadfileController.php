<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\SyDocumentFile;
use App\Models\System\SyLogError;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class UploadfileController extends Controller
{

    // public static function link($data,$code = 'main'){
    //     $dataFile = AeDocumentFile::query()->where('table_id', $data->id)->where('table_name',$data->getTable())
    //     ->where('type_code', $code )
    //     ->first();
    //     if(!empty($dataFile))
    //         return actionURL('System\UploadfileController@display',[encodeI($dataFile->id),isset($dataFile)?$dataFile->file_save:null ]);
    //     else
    //         return asset('assets/image/null.jpg') ;
    // }




    public static function display($code, $file_name, $w = null)
    {
        $path = config('filesystems.' . $code . '.path') . '/' . $file_name;
        if (!File::exists($path)) {
            return asset('assets/image/null.jpg');
        }
        $type = File::mimeType($path);
        if (Str::is('image/*', $type) || Str::is('application/pdf', $type)) {
            $file = File::get($path);
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);
            return $response;
        } else { // ไม่ใช่รูปให้โหลดส่งที่เครื่อง
            return response()->download($path, $file_name);
        }
    }

    public static function displayByCode($code,  $w = null)
    {
        $dataFile = SyDocumentFile::query()->where('id', decodeI($code))
            ->first();
        if (empty($dataFile))
            return asset('assets/image/null.jpg');

        $path = config('filesystems.' . $dataFile->file_path_main . '.path') . '/' . $dataFile->file_path . '/' . $dataFile->file_name;
        if (!File::exists($path)) {
            return asset('assets/image/null.jpg');
        }
        // $type = File::mimeType($path);
        $type = $dataFile->file_type;
        if (Str::is('image/*', $type) || Str::is('application/pdf', $type)) {
            $file = File::get($path);
            // $response = Response::make($file, 200);
            // $response->header("Content-Type", $type);
            return Response::make($file, 200, [
                'Content-Type'        => $type,
                'Content-Disposition' => 'inline; filename="' . $dataFile->original_file_name . '"'
            ]);
        } else { // ไม่ใช่รูปให้โหลดส่งที่เครื่อง
            return response()->download($path, $dataFile->file_name);
        }
    }


    // public static function linkAndSize($data,$w=null,$code = 'main'){
    //     $dataFile = AeDocumentFile::query()->where('table_id', $data->id)->where('table_name',$data->getTable())
    //     ->where('table_code', $code )
    //     ->first();
    //     if(!empty($dataFile))
    //         return actionURL('System\UploadfileController@displayResize',[encodeI($dataFile->id),$w,isset($dataFile)?$dataFile->file_save:null]);
    //     else
    //         return asset('assets/image/null.jpg') ;
    // }

    public function displayResize($code, $file_name, $w = null)
    {
        $path = config('filesystems.' . $code . '.path') . '/' . $file_name;
        if (!File::exists($path)) {
            abort(404);
        }
        $type = File::mimeType($path);
        $manager = new ImageManager(new Driver());
        if (Str::is('image/*', $type) || Str::is('application/pdf', $type)) { // ถ้าเป็นรูปก็แสดงภาพ
            $img =  $manager->read($path);
            if (!empty($w) && empty($h)) {
                $img = $manager->read($path)->scale($w, null);
            } elseif (empty($w) && !empty($h)) {
                $img = $manager->read($path)->scale(null, $h);
            } else {
                $img = $manager->read($path)->scale(350, 200);
            }

            $response = Response::make($img->toPng());
            $response->header('Content-Type', 'image/png');
            return $response;
        } else { // ไม่ใช่รูปให้โหลดส่งที่เครื่อง
            return response()->download($path, $file_name);
        }
    }

    public function displayResizeByCode($code, $w = null, $h = null)
    {
        $dataFile = SyDocumentFile::query()->where('id', decodeI($code))
            ->first();
        if (empty($dataFile))
            abort(404);
        $path = config('filesystems.' . $dataFile->file_path_main . '.path') . '/' . $dataFile->file_path . '/' . $dataFile->file_name;
        if (!File::exists($path)) {
            abort(404);
        }
        $type = File::mimeType($path);
        $manager = new ImageManager(new Driver());
        if (Str::is('image/*', $type) || Str::is('application/pdf', $type)) { // ถ้าเป็นรูปก็แสดงภาพ
            $img =  $manager->read($path);
            if (!empty($w) && empty($h)) {
                $img = $manager->read($path)->scale($w, null);
            } elseif (empty($w) && !empty($h)) {
                $img = $manager->read($path)->scale(null, $h);
            } elseif (!empty($w) && !empty($h)) {
                $img = $manager->read($path)->scale($w, $h);
            } else {
                $img = $manager->read($path)->scale(350, 200);
            }

            $response = Response::make($img->toPng());
            $response->header('Content-Type', 'image/png');
            return $response;
        } else { // ไม่ใช่รูปให้โหลดส่งที่เครื่อง
            return response()->download($path, $dataFile->file_name);
        }
    }

    public static function upload($type_name, $data, $file)
    {
        $manager = new ImageManager(new Driver());
        $table_name = $data->getTable();
        $table_id = $data->id ?? 0;
        $path = config('filesystems.' . $type_name . '.path');
        $path_2 = date('Y/m');
        if (!file_exists($path . '/' . $path_2)) {
            mkdir($path . '/' . $path_2, 0775, true);
        }
        try {
            // if (Str::contains($image->encode()->mediaType(), ['jpg', 'jpeg', 'png', 'gif'])) {
            if (Str::contains(File::mimeType($file), ['jpg', 'jpeg', 'png', 'gif'])) {
                $image  =  $manager->read($file);
                $file_name = $table_id . '_' . str_shuffle(time()) . rand(1, 999) . '.webp';
                if ($image->width() > 1000) {
                    $image->scale(width: 1000);
                }
                if ($image->height() > 1000) {
                    $image->scale(height: 1000);
                }
                $encoded = $image->toWebp(80);
                $encoded->save($path . '/' . $path_2 . '/' . $file_name);
                $file_mediaType = $encoded->mediaType();
            } else {
                $file_name = $table_id . '_' . str_shuffle(time()) . rand(1, 999) . '.' . $file->getclientOriginalExtension();
                $file_mediaType = File::mimeType($file);
                // File::put($path . '/' . $path_2 . '/' . $file_name, $file);
                // $file->storeAs($type_name, $file_name, 'public');
                $content = file_get_contents($file->getRealPath());
                File::put($path . '/' . $path_2 . '/' . $file_name, $content);
            }

            $file_size =  filesize($path . '/' . $path_2 . '/' . $file_name);

            $fileUpload = new SyDocumentFile();
            $fileUpload->table_name = $table_name;
            $fileUpload->table_id =  $table_id;
            $fileUpload->original_file_name = $file->getClientOriginalName();
            $fileUpload->file_name = $file_name;
            $fileUpload->file_size_mb = $file_size / 1000000;
            $fileUpload->file_type = $file_mediaType;
            $fileUpload->file_path_main = $type_name;
            $fileUpload->file_path = $path_2;
            $fileUpload->save();

            return true;
        } catch (\Exception $e) {
            SyLogError::saveError($e);
            return false;
        }
    }

    public static function delete($code = null)
    {

        $dataFile = SyDocumentFile::query()->where('id', decodeI($code))->first();
        try {
            $file_o = config('filesystems.' . $dataFile->file_path_main . '.path') . '/' . $dataFile->file_path . '/' . $dataFile->file_name;
            if (is_file($file_o)) {
                unlink($file_o);
            }
            $dataFile->delete();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }



    // public static function uploadBase64( $data,$base64File,$code = 'main')
    // {
    //     $base64Image = explode(";base64,", $base64File);
    //     $explodeImage = explode("image/", $base64Image[0]);
    //     $imageName = $explodeImage[1];
    //     $file = base64_decode($base64Image[1]);

    //     $table_name = $data->getTable();
    //     $table_id = $data->id??0;
    //     $path = config('filesystems.file.path');

    //     $file_name = $table_id.'_'.str_shuffle(time()). '.' . $imageName;
    //     // ลบข้อมูลเก่าถ้ามี
    //     $data = AeDocumentFile::query()->where('table_id', $table_id)->where('table_name',$table_name)->where('table_code', $code )

    //     ->first();

    //     if(isset($data->file_save)){
    //         $file_o = $path.'/'.$data->file_save;
    //         if(is_file($file_o)){
    //             unlink($file_o);
    //         }
    //         $data->delete();
    //     }

    //     try{
    //         $fileUpload = new AeDocumentFile();
    //         $fileUpload->table_id = $table_id;
    //         $fileUpload->table_name = $table_name;
    //         if(isset($code))
    //             $fileUpload->table_code = $code;
    //         $fileUpload->file_name = 'Base64';
    //         $fileUpload->file_save = $file_name;
    //         $fileUpload->file_size_mb = strlen(base64_decode($base64File))/1000000;
    //         $fileUpload->file_type = $imageName;
    //         $fileUpload->save();
    //         File::put($path.'/'.$file_name, $file);
    //         // Storage::put($path.$file_name, $file);

    //         return true;
    //     }catch(\Exception $e){
    //         return false;
    //     }

    // }





}
