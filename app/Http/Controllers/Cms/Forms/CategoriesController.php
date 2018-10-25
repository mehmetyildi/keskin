<?php

namespace App\Http\Controllers\Cms\Forms;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Cms\Inbox\ContactForm;
use App\Models\Cms\Inbox\FormCategory;

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
     * Show the form for creating new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, ContactForm $form)
    {
        checkPermissionFor('create_form_category');
        return view('cms.forms.categories.create', compact('form'));
    }

    /**
     * Store new category.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        checkPermissionFor('create_form_category');
        $this->validate($request, FormCategory::$rules);
        FormCategory::create($request->all());
        session()->flash('success', 'Yeni kategori oluşturuldu.');
        return redirect()->route('cms.forms.edit', ['form' => $request->contact_form_id]);
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(FormCategory $category)
    {
        checkPermissionFor('edit_form_category');
        return view('cms.forms.categories.edit', compact('category'));
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormCategory $category)
    {
        checkPermissionFor('edit_form_category');
        $this->validate($request, FormCategory::$rules);
        $category->update($request->all());
        session()->flash('success', 'Form kategorisi güncellendi.');
        return redirect()->back();
    }

    /**
     * Delete existing record
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(FormCategory $category)
    {
        $form = $category->form;
        checkPermissionFor('delete_form_category');
        $category->delete();
        session()->flash('success', 'Form kategorisi silindi.');
        return redirect()->route('cms.forms.edit', $form->id);
    }
}