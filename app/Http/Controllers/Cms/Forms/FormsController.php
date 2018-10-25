<?php

namespace App\Http\Controllers\Cms\Forms;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Cms\Inbox\ContactForm;

class FormsController extends BaseController
{
    /**
     * FormsController constructor.
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
        checkPermissionFor('view_forms');
        $forms = ContactForm::all();
        return view('cms.forms.index', compact('forms'));
    }

    /**
     * Show the form for creating new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        checkPermissionFor('create_form');
        return view('cms.forms.create');
    }

    /**
     * Store new record.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        checkPermissionFor('create_form');
        $this->validate($request, ContactForm::$rules);
        ContactForm::create($request->all());
        session()->flash('success', 'Yeni Form oluşturuldu.');
        return redirect()->route('cms.forms.index');
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ContactForm $form)
    {
        checkPermissionFor('edit_form');
        return view('cms.forms.edit', compact('form'));
    }

    /**
     * Edit existing record.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ContactForm $form)
    {
        checkPermissionFor('edit_form');
        $this->validate($request, ContactForm::$updaterules);
        $form->update($request->all());
        session()->flash('success', 'Form güncellendi.');
        return redirect()->back();
    }

    /**
     * Delete existing record
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(ContactForm $form)
    {
        checkPermissionFor('delete_form');
        foreach($form->categories as $category){
            $category->delete();
        }
        $form->delete();
        session()->flash('success', 'Form silindi.');
        return redirect()->route('cms.forms.index');
    }
}