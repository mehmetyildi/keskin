<?php

namespace App\Http\Controllers\Cms\FileManager;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Cms\FileManager\FileManagerFile;
use App\Models\Cms\FileManager\FileManagerCategory;
use App\Models\Cms\SearchIndex;
use View;
use File;

class FileManagerController extends BaseController
{
    /**
     * FileManagerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the listing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        checkPermissionFor('edit_content');
        $folders = FileManagerCategory::all();
        $records = FileManagerFile::orderBy('created_at', 'DESC')->take(15)->get();
        return view('cms.file-manager.index', compact('records', 'folders'));
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(FileManagerCategory $folder)
    {
        checkPermissionFor('edit_content');
        $records = FileManagerFile::where('file_manager_category_id', $folder->id)->orderBy('created_at', 'DESC')->get();
        $folders = FileManagerCategory::all();
        return view('cms.file-manager.detail', compact('folders', 'folder', 'records'));
    }

    

    /**
     * Store new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        checkPermissionFor('create_content');
        $this->validate($request, FileManagerFile::$rules);
        $record = new FileManagerFile;
        $record->file_manager_category_id = $request->file_manager_category_id;
        $record->title = $request->title;
        $file = $request->file('file_path');
        $extension = $file->getClientOriginalExtension();
        $filename = time(). '_' . $request->title;
        $filename = str_replace(parent::$turkish, parent::$english, $filename);
        $filename = parent::seo_friendly_url($filename).'.'.$extension;
        $file->move(public_path('storage/file-manager/'), $filename);
        $record->file_path = $filename;
        $record->save();
        
        session()->flash('success', 'Yeni dosya yüklendi.');
        return redirect()->back();
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(PageModel $record)
    {
        checkPermissionFor('edit_content');
        return view('cms.'.$this->pageUrl.'.edit', compact('record'));
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
    public function delete(FileManagerFile $file)
    {
        checkPermissionFor('delete_content');
        if(!$file){
            session()->flash('danger', 'Böyle bir kayıt yok.');
            return redirect()->back();
        }
        File::delete(public_path('storage/file-manager/'.$file->file_path));
        $file->delete();
        session()->flash('success', 'Dosya silindi.');
        return redirect()->back();
        
    }

}