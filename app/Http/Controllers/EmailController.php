<?php

namespace App\Http\Controllers;


use App\Mail\OfferMail;
use App\Mail\QuoteMail;
use App\Models\Cms\Inbox\FormCategory;
use Illuminate\Http\Request;
use App\Mail\ContactMail;
use App\Mail\ApplicationMail;
use App\Models\Cms\Inbox\ContactForm;
use App\Models\Cms\Inbox\InboxMail;
use App\Models\Cms\Inbox\InboxAttachment;
use Mail;

class EmailController extends Controller
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
     * Submit contact form
     *
     * @return \Illuminate\Http\Response
     */
    public function contact(Request $request)
    {
        $form = ContactForm::findOrFail($request->form_id);
        $category = FormCategory::findOrFail($request->department);
        Mail::to($category->to)->cc(($category->cc) ?: $category->to)->send(new ContactMail($request->name, $request->company, $request->email, $request->phone, $category->title_tr, $request->body));
        InboxMail::create([
            'contact_form_id' => $form->id,
            'form_category_id' => $category->id,
            'from' => $request->email,
            'to' => $category->to,
            'subject' => 'Web İletişim',
            'body' => composeMailBody(['Departman' => $category->title, 'Ad Soyad' => $request->name, 'Firma' => $request->company, 'Telefon' => $request->phone], $request->body)
        ]);
        session()->flash('success', 'Mesaj Gönderildi.');
        return redirect()->back();
    }

    /**
     * Submit contact form
     *
     * @return \Illuminate\Http\Response
     */
    public function quote(Request $request)
    {
        $form = ContactForm::findOrFail($request->form_id);
        Mail::to($form->to)->cc(($form->cc) ?: $form->to)->send(new QuoteMail($request->product, $request->name, $request->company, $request->email, $request->phone, $request->body));
        InboxMail::create([
            'contact_form_id' => $form->id,
            'from' => $request->email,
            'to' => $form->to,
            'subject' => 'Teklif Talebi',
            'body' => composeMailBody(['Ürün' => $request->product, 'Ad Soyad' => $request->name, 'Firma' => $request->company, 'Telefon' => $request->phone], $request->body)
        ]);
        session()->flash('success', 'Mesaj Gönderildi.');
        return redirect()->back();
    }

    /**
     * Submit human-resources form
     *
     * @return \Illuminate\Http\Response
     */
    public function job(Request $request)
    {
        $form = ContactForm::findOrFail($request->form_id);
 
        Mail::to($form->to)->cc(($form->cc) ?: $form->to)->send(new ApplicationMail($request->name, $request->email, $request->phone, $request->position, $request->file('resume'), $request->body));


        $inboxMail = InboxMail::create([
            'contact_form_id' => $form->id,
            'from' => $request->email,
            'to' => $form->to,
            'subject' => 'İş/Staj Başvurusu',
            'body' => composeMailBody(['Ad Soyad' => $request->name, 'Telefon' => $request->phone, 'Pozisyon' => $request->position], $request->body)
        ]);

        $file = $request->file('resume');
        $filename = 'cv_'.time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(self::$turkish, self::$english, $filename);
        $file->move(public_path('storage/'), $filename);

        InboxAttachment::create([
            'inbox_mail_id' => $inboxMail->id,
            'path' => $filename
        ]);

        session()->flash('success', 'Mesaj Gönderildi.');
        return redirect()->back();
    }

    /**
     * Submit human-resources form
     *
     * @return \Illuminate\Http\Response
     */
    public function offer(Request $request)
    {
        $form = ContactForm::findOrFail($request->form_id);

        Mail::to($form->to)->cc(($form->cc) ?: $form->to)->send(new OfferMail(
            $request->name,
            $request->company,
            $request->city,
            $request->phone,
            $request->email,
            $request->material_type,
            $request->thickness,
            $request->sizes,
            $request->weight,
            $request->file('offer_file'),
            $request->body));


        $inboxMail = InboxMail::create([
            'contact_form_id' => $form->id,
            'from' => $request->email,
            'to' => $form->to,
            'subject' => 'Teklif Talebi',
            'body' => composeMailBody([
                'Ad Soyad' => $request->name,
                'Firma' => $request->company,
                'Şehir' => $request->city,
                'Telefon' => $request->phone,
                'Malzeme Cinsi' => $request->material_type,
                'Malzeme Et Kalınlığı' => $request->thickness,
                'Malzeme Ölçüleri' => $request->sizes,
                'Toplam Ağırlık' => $request->weight,
                'Başvuru Tipi' => $request->type
            ], $request->body)
        ]);

        $file = $request->file('offer_file');
        $filename = 'file_'.time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(self::$turkish, self::$english, $filename);
        $file->move(public_path('storage/'), $filename);

        InboxAttachment::create([
            'inbox_mail_id' => $inboxMail->id,
            'path' => $filename
        ]);

        session()->flash('success', 'Mesaj Gönderildi.');
        return redirect()->back();
    }
}