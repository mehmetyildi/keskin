<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cms\SearchIndex;
use Image;
use File;

class BaseController extends Controller
{
    /**
     *
     * Turkish spesific letters
     * @var array
     */
    public static $turkish = array("ı", "ğ", "ü", "ş", "ö", "ç", "İ", "Ğ", "Ü", "Ş", "Ö", "Ç");

    /**
     *
     * English equivalents of letters in $turkish array
     * @var array
     */
    public static $english = array("i", "g", "u", "s", "o", "c", "i", "g", "u", "s", "o", "c");

    /**
     *
     * Turn given string into a readable URL
     * @param string $string
     * @return string
     */
    public static function seo_friendly_url($string){
        $turkish = array("ı", "ğ", "ü", "ş", "ö", "ç", "İ", "Ğ", "Ü", "Ş", "Ö", "Ç");
        $english = array("i", "g", "u", "s", "o", "c", "i", "g", "u", "s", "o", "c");
        $string = str_replace($turkish, $english, $string);
        $string = str_replace(array('[\', \']'), '', $string);
        $string = preg_replace('/\[.*\]/U', '', $string);
        $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
        $string = htmlentities($string, ENT_COMPAT, 'utf-8');
        $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
        $string = str_replace(["acute","uml","circ","grave","ring","cedil","slash","tilde","caron","quot","rsquo"], ["","","","","","","","","","","",""], $string);
        $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
        return strtolower(trim($string, '-'));
    }

    /**
     *
     * Turn given string into a readable URL
     * @param Illuminate\Support\Collection $record
     * @param file $input
     * @param string $column
     * @return mixed
     */
    public function handleDateInput($record, $input, $column){
        if($input == null){
            $record->$column = null;
            return;
        }
        $day = substr($input, 0,2);
        $month = substr($input, 3,2);
        $year = substr($input, 6,4);
        $time = strtotime($month . '/'.$day.'/'.$year);
        $record->$column = date('Y-m-d', $time);
    }

    /**
     * Attach image to a record after crop and save filename to DB
     * @param $record
     * @param $urlColumn
     * @param $diff
     * @param $imageFile
     * @param $column
     * @param $width
     * @param $height
     * @param $w
     * @param $h
     * @param $x
     * @param $y
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function handleImageCropUpload($record,$urlColumn,$diff,$imageFile,$column,$width,$height,$w,$h,$x,$y){
        if(!$imageFile){
            return;
        }
        if($record->$column){
            File::delete(public_path('storage/'.$record->$column));
        }
        $keyString = self::seo_friendly_url($record->$urlColumn);
        $filename = $keyString.'_'.$diff.'_'.time();
        $image = Image::make($imageFile);
        if(isNotImage($image->mime())){
            session()->flash('danger', 'You can only upload .png or .jpg files');
            return redirect()->back();
        }
        $finalName = $filename.getImageExtension($image->mime());
        $image->crop($w, $h, $x, $y)->resize($width,$height)->save(public_path('storage/'.$finalName));
        $record->$column = $finalName;
    }


    /**
     * Attach file to a record and save filename to DB
     * @param $record
     * @param $urlColumn
     * @param $docFile
     * @param $column
     */
    public function handleFileUpload($record,$urlColumn,$docFile,$column){
        if(!$docFile){
            return;
        }
        if($record->$column){
            File::delete(public_path('storage/'.$record->$column));
        }
        $keyString = self::seo_friendly_url($record->$urlColumn);
        $filename = $keyString.'_'.$column.'_'.time() . '.' . $docFile->getClientOriginalExtension();
        $filename = str_replace(self::$turkish, self::$english, $filename);
        $docFile->move(public_path('storage/'), $filename);
        $record->$column = $filename;

    }

    /**
     * @param $record
     * @param $urlColumn
     * @param $diff
     * @param $imageFile
     * @param $column
     * @param $width
     * @param $height
     * @param $w
     * @param $h
     * @param $x
     * @param $y
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function handleGalleryImage($record,$urlColumn,$diff,$imageFile,$column,$width,$height,$w,$h,$x,$y){
        if(!$imageFile){
            return;
        }
        if($record->$column){
            File::delete(public_path('storage/uncut_'.$record->$column));
            File::delete(public_path('storage/'.$record->$column));
        }
        $keyString = self::seo_friendly_url($record->$urlColumn);
        $filename = $keyString.'_'.$diff.'_'.time();
        $image = Image::make($imageFile);
        if(isNotImage($image->mime())){
            session()->flash('danger', 'You can only upload .png or .jpg files');
            return redirect()->back();
        }
        $finalName = $filename.getImageExtension($image->mime());
        $image->save(public_path('storage/uncut_'.$finalName));
        $image->crop($w, $h, $x, $y)->resize($width,$height)->save(public_path('storage/'.$finalName));
        $record->$column = $finalName;
    }

    /**
     *
     * Delete a single gallery image
     * @param Illuminate\Database\Eloquent\Model $record
     * @param Illuminate\Database\Eloquent\Model $model
     * @return mixed
     */
    public function handleGalleryImageDestroy($record, $model){
        if($record){
            if(count($model::$imageFieldNames)){
                foreach($model::$imageFieldNames as $imageField){
                    File::delete(public_path('storage/uncut_'.$record->$imageField));
                    File::delete(public_path('storage/'.$record->$imageField));
                }
            }
            $record->delete();
            return true;
        }

        return false;
    }

    /**
     *
     * Delete a single gallery image
     * @param Illuminate\Database\Eloquent\Model $model
     * @param Illuminate\Database\Eloquent\Model $record
     * @return mixed
     */
    public function handleFileDestroy($record, $model){
        if($record){
            if(count($model::$imageFieldNames)){
                foreach($model::$imageFieldNames as $imageField){
                    File::delete(public_path('storage/'.$record->$imageField));
                }
            }
            $record->delete();
            return true;
        }

        return false;
    }


    /**
     *
     * Sort items
     * @param Illuminate\Database\Eloquent\Model $model
     * @return string
     */
    public function handleSort($model){
        $dataIds = json_decode(stripslashes($_POST['ids']));

        for($i=0; $i<count($dataIds); $i++){
            $record = $model->find($dataIds[$i]);
            $record->position = $i + 1;
            $record->save();
        }
        return 'Items sorted';
    }

    /**
     *
     * Delete a record along with the attached files and images.
     * @param Illuminate\Database\Eloquent\Model $model
     * @param Illuminate\Support\Collection $record
     * @param boolean $gallery
     * @return boolean
     */
    public function handleDestroy($model, $record, $urlColumn, $gallery = true, $materials = false){
        if($gallery){
            if($record->images){
                foreach($record->images as $image) {
                    File::delete(public_path('storage/'.$image->main_image));
                    $image->delete();
                }
            }
        }
        if($materials){
            if($record->materials){
                foreach($record->materials as $material) {
                    File::delete(public_path('storage/'.$material->main_file));
                    $material->delete();
                }
            }
        }
        if($record){
            if(count($model::$imageFieldNames)){
                foreach($model::$imageFieldNames as $imageField){
                    File::delete(public_path('storage/'.$record->$imageField));
                }
            }
            if(count($model::$docFields)){
                foreach($model::$docFields as $docField){
                    File::delete(public_path('storage/'.$record->$docField));
                }
            }
            $record->delete();
            if($record->$urlColumn){
                SearchIndex::where('keyword', $record->$urlColumn)->first()->delete();
            }
            return true;
        }

        return false;
    }

}
