<?php

namespace App\Http\Controllers\Cms\FileManager;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Cms\FileManager\FileManagerCategory;
use App\Models\Cms\SearchIndex;
use View;
use File;

class CategoriesController extends BaseController
{
    /**
     * CategoriesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        checkPermissionFor('create_content');
        $this->validate($request, FileManagerCategory::$rules);
        FileManagerCategory::create($request->all());
        session()->flash('success', 'Yeni klasör oluşturuldu.');
        return redirect()->back();
    }

    

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PageModel $record)
    {
        checkPermissionFor('edit_content');
        $this->validate($request, PageModel::$updaterules);
        SearchIndex::where('keyword', $record->{$this->urlColumn})->first()->delete();
        if($this->hasPublish){
            (($request->publish) ? $record->publish = true : $record->publish = false);
        }
        if($this->hasUrl){
            $record->url = parent::seo_friendly_url($request->{$this->urlColumn});
        }
        /** Regular Inputs **/
        foreach($this->fields as $field){
            $record->$field = $request->get($field);
        }
        /** Date Inputs **/
        if($this->dateFields){
            foreach($this->dateFields as $dateField){
                parent::handleDateInput($record, $request->get($dateField), $dateField);
            }
        }
        /** File Inputs **/
        foreach($this->docFields as $docField){
            parent::handleFileUpload($record, $request->file($docField), $this->pageUrl, $docField);
        }

        /** Image Inputs **/
        if($this->imageFields){
            foreach($this->imageFields as $imageField){
                if(array_key_exists('crop', $imageField)){
                    parent::handleImageCropUpload(
                        $record, 
                        $request->get($imageField['name']), 
                        $this->pageUrl, 
                        $imageField['name'], 
                        $imageField['width'], 
                        $imageField['height'], 
                        round($request->get('w')), round($request->get('h')), round($request->get('x')), round($request->get('y'))
                    );
                }else{
                     parent::handleImageUpload(
                        $record, 
                        $request->get($imageField['name']), 
                        $imageField['width'], 
                        $imageField['height'], 
                        $this->pageUrl, 
                        $imageField['name']);
                }
            }
        }
        $record->save();
        SearchIndex::create([
            "keyword" => $record->{$this->urlColumn},
            "folder" => $this->pageUrl,
            "key" => $record->id
        ]);
        session()->flash('success', $this->pageItem.' güncellendi.');
        return redirect()->back();
    }

    /**
     * Delete existing record
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(PageModel $record)
    {
        checkPermissionFor('delete_content');
        if(parent::handleDestroy($this->model, $record, $this->urlColumn, true, true)){
            session()->flash('success', $this->pageItem.' silindi.');
        }else{
            session()->flash('danger', 'Böyle bir kayıt yok.');
        }
        return redirect()->route('cms.'.$this->pageUrl.'.index');
        
    }

}