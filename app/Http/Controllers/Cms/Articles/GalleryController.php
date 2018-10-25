<?php

namespace App\Http\Controllers\Cms\Articles;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Articles\Article as ParentModel;
use App\Models\Articles\ArticleImage as PageModel;
use View;
use File;

class GalleryController extends BaseController
{
    /**
     * GalleryController constructor.
     * @param PageModel $model
     */
    public function __construct(PageModel $model)
    {
        $this->middleware('auth');
        $this->pageUrl = 'articles';
        $this->pageName = 'Haberler';
        $this->pageItem = 'Haber Görseli';
        $this->urlColumn = 'title_tr';
        $this->parentKey = 'article_id';
        $this->hasUrl = true;
        $this->hasPublish = true;
        $this->model = $model;
        $this->fields = $model::$fields;
        $this->imageFields = $model::$imageFields;
        $this->docFields = $model::$docFields;
        $this->dateFields = $model::$dateFields;
        View::share(array(
            'pageUrl' => $this->pageUrl,
            'pageName' => $this->pageName,
            'pageItem' => $this->pageItem,
        ));
    }

    /**
     * Show the listing page.
     * @param ParentModel $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ParentModel $record)
    {
        checkPermissionFor('edit_content');
        return view('cms.'.$this->pageUrl.'.gallery.index', compact('record'));
    }

    /**
     * Reorder records
     */
    public function sortRecords(){
        checkPermissionFor('edit_content');
        parent::handleSort($this->model);
    }

    /**
     * Store new record.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        checkPermissionFor('edit_content');
        $parent = ParentModel::findOrFail($request->{$this->parentKey});
        $record = new PageModel;
        if($this->hasPublish){
            (($request->publish) ? $record->publish = true : $record->publish = false);
        }
        /** Regular Inputs **/
        foreach($this->fields as $field){
            $record->$field = $request->get($field);
        }
        /** Image Inputs **/
        if($this->imageFields){
            foreach($this->imageFields as $imageField){
                parent::handleGalleryImage(
                    $record,
                    $imageField['naming'],
                    $imageField['diff'],
                    $request->get($imageField['name']),
                    $imageField['name'],
                    $imageField['width'],
                    $imageField['height'],
                    round($request->get($imageField['name'].'_w')), round($request->get($imageField['name'].'_h')), round($request->get($imageField['name'].'_x')), round($request->get($imageField['name'].'_y'))
                );
            }
        }

        $record->save();
        session()->flash('success', 'Yeni '.$this->pageItem.' oluşturuldu.');
        return redirect()->route('cms.'.$this->pageUrl.'.gallery', ['record' => $parent->id]);
    }

    /**
     * Edit existing record.
     * @param PageModel $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(PageModel $record)
    {
        checkPermissionFor('edit_content');
        return view('cms.'.$this->pageUrl.'.gallery.edit', compact('record'));
    }

    /**
     * Update existing record.
     * @param Request $request
     * @param PageModel $record
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, PageModel $record)
    {
        checkPermissionFor('edit_content');
        $this->validate($request, PageModel::$updaterules);
        if($this->hasPublish){
            (($request->publish) ? $record->publish = true : $record->publish = false);
        }

        /** Regular Inputs **/
        foreach($this->fields as $field){
            $record->$field = $request->get($field);
        }

        /** Image Inputs **/
        if($this->imageFields){
            foreach($this->imageFields as $imageField){
                parent::handleGalleryImage(
                    $record,
                    $imageField['naming'],
                    $imageField['diff'],
                    $request->get($imageField['name']),
                    $imageField['name'],
                    $imageField['width'],
                    $imageField['height'],
                    round($request->get($imageField['name'].'_w')), round($request->get($imageField['name'].'_h')), round($request->get($imageField['name'].'_x')), round($request->get($imageField['name'].'_y'))
                );
            }
        }
        $record->save();

        session()->flash('success', $this->pageItem.' güncellendi.');
        return redirect()->back();
    }

    /**
     * Delete existing record
     * @param PageModel $record
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PageModel $record)
    {
        checkPermissionFor('edit_content');
        $parent = ParentModel::findOrFail($record->{$this->parentKey});
        if(parent::handleGalleryImageDestroy($record, $this->model)){
            session()->flash('success', $this->pageItem.' silindi.');
        }else{
            session()->flash('danger', 'Böyle bir kayıt yok.');
        }
        return redirect()->route('cms.'.$this->pageUrl.'.gallery', ['record' => $parent->id]);

    }

}