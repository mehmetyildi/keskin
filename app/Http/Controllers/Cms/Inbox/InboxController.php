<?php

namespace App\Http\Controllers\Cms\Inbox;

use Illuminate\Http\Request;
use App\Http\Controllers\Cms\BaseController;
use App\Models\Cms\Inbox\InboxMail;
use App\Models\Cms\Inbox\ContactForm;
use App\Models\Cms\Inbox\FormCategory;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\SiteMail;

class InboxController extends BaseController
{
    /**
     * InboxController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the Inbox
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        checkPermissionFor('view_inbox');
        $mails = InboxMail::where('isTrash', false)->where('isSent', false)->where('isDraft', false)->orderBy('created_at', 'DESC')->paginate(10);
        $inboxName = "Gelen Kutusu (".$mails->where('isRead', false)->count() .")";
        return view('cms.inbox.index', compact('mails', 'inboxName'));
    }

    /**
     * Show the Sent Mails
     *
     * @return \Illuminate\Http\Response
     */
    public function sent()
    {
        checkPermissionFor('compose_mail');
        $mails = InboxMail::where('isTrash', false)->where('isSent', true)->where('isDraft', false)->orderBy('created_at', 'DESC')->paginate(10);
        $inboxName = "Gönderilenler";
        return view('cms.inbox.index', compact('mails', 'inboxName'));
    }

    /**
     * Show the Important Mails
     *
     * @return \Illuminate\Http\Response
     */
    public function important()
    {
        checkPermissionFor('view_inbox');
        $mails = InboxMail::where('isTrash', false)->where('isSent', false)->where('isImportant', true)->where('isDraft', false)->orderBy('created_at', 'DESC')->paginate(10);
        $inboxName = "Önemli";
        return view('cms.inbox.index', compact('mails', 'inboxName'));
    }

    /**
     * Show the Draft Mails
     *
     * @return \Illuminate\Http\Response
     */
    public function drafts()
    {
        checkPermissionFor('compose_mail');
        $mails = InboxMail::where('isTrash', false)->where('isSent', false)->where('isDraft', true)->orderBy('created_at', 'DESC')->paginate(10);
        $inboxName = "Taslaklar";
        return view('cms.inbox.index', compact('mails', 'inboxName'));
    }

    /**
     * Show the Trash
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        checkPermissionFor('view_inbox');
        $mails = InboxMail::where('isTrash', true)->orderBy('created_at', 'DESC')->paginate(10);
        $inboxName = "Çöp Kutusu";
        $trashFolder = "";
        return view('cms.inbox.index', compact('mails', 'inboxName', 'trashFolder'));
    }

    /**
     * Show the Inbox by Form
     *
     * @return \Illuminate\Http\Response
     */
    public function form(ContactForm $form)
    {
        checkPermissionFor('view_inbox');
        $mails = InboxMail::where('isTrash', false)->where('isSent', false)->where('isDraft', false)->where('contact_form_id', $form->id)->orderBy('created_at', 'DESC')->paginate(10);
        $inboxName = $form->title ." (".$mails->where('isRead', false)->count() .")";
        return view('cms.inbox.index', compact('mails', 'inboxName'));
    }

    /**
     * Show the Inbox by Category
     *
     * @return \Illuminate\Http\Response
     */
    public function category(FormCategory $category)
    {
        checkPermissionFor('view_inbox');
        $mails = InboxMail::where('isTrash', false)->where('isSent', false)->where('isDraft', false)->where('form_category_id', $category->id)->orderBy('created_at', 'DESC')->paginate(10);
        $inboxName = $category->title_tr . " (".$mails->where('isRead', false)->count() .")";
        return view('cms.inbox.index', compact('mails', 'inboxName'));
    }

    /**
     * Show a single mail detail
     *
     * @return \Illuminate\Http\Response
     */
    public function detail(InboxMail $mail)
    {
        checkPermissionFor('view_inbox');
        $mail->isRead = true;
        $mail->save();
        return view('cms.inbox.detail', compact('mail'));
    }

    /**
     * Edit a mail draft
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(InboxMail $mail)
    {
        checkPermissionFor('compose_mail');
        return view('cms.inbox.edit', compact('mail'));
    }

    /**
     * Compose new mail
     *
     * @return \Illuminate\Http\Response
     */
    public function compose()
    {
        checkPermissionFor('compose_mail');
        return view('cms.inbox.compose');
    }

    /**
     * Show reply page
     *
     * @return \Illuminate\Http\Response
     */
    public function reply(InboxMail $mail)
    {
        checkPermissionFor('compose_mail');
        return view('cms.inbox.reply', compact('mail'));
    }

    /**
     * Show search results
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        checkPermissionFor('view_inbox');
        $mails = InboxMail::where('subject', 'LIKE', '%'.$request->subject.'%')->where('isTrash', false)->orderBy('created_at', 'DESC')->paginate(10);
        $inboxName = "Arama Sonuçları: '".$request->subject."'";
        return view('cms.inbox.index', compact('mails', 'inboxName'));
    }


    /**
     * Send mail
     *
     * @return \Illuminate\Http\Response
     */
    public function send(Request $request)
    {
        checkPermissionFor('compose_mail');
        Mail::to($request->to)->send(new SiteMail($request->from, $request->subject, $request->body));
        InboxMail::create([
            'from' => $request->from,
            'to' => $request->to,
            'subject' => $request->subject,
            'body' => composeMailBody($request->body),
            'isSent' => true,
            'isRead' => true
        ]);
        session()->flash('success', 'Mesaj gönderildi');
        return redirect()->route('cms.inbox.index');
    }

    /**
     * Save a composed mail as a draft
     *
     * @return \Illuminate\Http\Response
     */
    public function saveDraft(Request $request)
    {
        checkPermissionFor('compose_mail');
        InboxMail::create([
            'from' => $request->from,
            'to' => ($request->to) ?: null,
            'subject' => ($request->subject) ?: null,
            'body' => composeMailBody($request->body),
            'isDraft' => true,
            'isRead' => true
        ]);
        session()->flash('success', 'Taslak kaydedildi');
        return redirect()->route('cms.inbox.drafts');
    }

    /**
     * Update existing draft
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InboxMail $mail)
    {
        checkPermissionFor('compose_mail');
        $mail->update([
            'from' => $request->from,
            'to' => ($request->to) ?: null,
            'subject' => ($request->subject) ?: null,
            'body' => composeMailBody($request->body),
            'isDraft' => true,
            'isRead' => true
        ]);
        session()->flash('success', 'Taslak güncellendi');
        return redirect()->route('cms.inbox.drafts');
    }

    /**
     * Mark selected mails as important
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsImportant(Request $request)
    {
        checkPermissionFor('view_inbox');
        foreach ($request->selected_mails as $id) {
            $mail = InboxMail::find($id);
            $mail->isImportant = true;
            $mail->save();
        }
        session()->flash('success', 'Seçilen mesajlar önemli olarak işaretlendi');
        return redirect()->route('cms.inbox.index');
    }

    /**
     * Mark selected mails as read
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(Request $request)
    {
        checkPermissionFor('view_inbox');
        foreach ($request->selected_mails as $id) {
            $mail = InboxMail::find($id);
            $mail->isRead = true;
            $mail->save();
        }
        session()->flash('success', 'Seçilen mesajlar okundu olarak işaretlendi');
        return redirect()->route('cms.inbox.index');
    }

    /**
     * Move selected mails as to trash
     *
     * @return \Illuminate\Http\Response
     */
    public function markAsTrash(Request $request)
    {
        checkPermissionFor('view_inbox');
        foreach ($request->selected_mails as $id) {
            $mail = InboxMail::find($id);
            $mail->isTrash = true;
            $mail->save();
        }
        session()->flash('success', 'Seçilen mesajlar çöp kutusuna taşındı');
        return redirect()->route('cms.inbox.index');
    }

    /**
     * Move selected mail to trash
     *
     * @return \Illuminate\Http\Response
     */
    public function moveToTrash(Request $request, InboxMail $mail)
    {
        checkPermissionFor('view_inbox');
        $mail->isTrash = true;
        $mail->save();
        session()->flash('success', 'Mesaj silindi');
        return redirect()->route('cms.inbox.index');
    }
 
}