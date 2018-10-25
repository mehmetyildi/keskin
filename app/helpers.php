<?php

use App\Models\Cms\User\Invitee;
use App\Models\Cms\Inbox\InboxMail;
use App\Models\Cms\Inbox\ContactForm;
use Carbon\Carbon;
use App\Models\Cms\Loginlog;
use App\Models\ProductCatalog;
use App\Models\ProductImage;

/* Get any excat moment */
function todayWithFormat($format){
    return Carbon::now()->format($format);
}

/* Get any excat moment */
function previousLogin(){
    $log = Loginlog::where('user_id', auth()->user()->id)->orderBy('created_at', 'DESC')->skip(1)->take(1)->first();
    if($log){
        return $log->created_at->format('d/m/Y @ h:i');
    }
    return " bu sizin ilk oturumunuz.";
}

/* Convert a "date" column to d-m-y format */
function convertDate($value){
    return Carbon::parse($value)->format('d/m/Y');
}

function checkPermissionFor($permission){
    if(!auth()->user()->can($permission) && !auth()->user()->can('do_all')){
        abort('403');
    }
}

function matchesWithInvitee($token){
	$invitee = Invitee::where('token', $token)->first();
	if($invitee){
		return true;
	}
	return false;
}

function composeMailBody(...$segments){
	$body = "";
	foreach($segments as $segment){
		if(is_array($segment)){
            foreach($segment as $seg => $value){
    			$body .= $seg . ': ' . $value . '<br/><br/>';
            }
		}else{
			$body .= $segment . '<br/>';
		}
	}
	return $body;
}

function unreadMailCount(){
    return InboxMail::where('isTrash', false)
    					->where('isSent', false)
    					->where('isRead', false)
    					->where('isDraft', false)->get()->count();
}

function latestMails(){
    return InboxMail::where('isTrash', false)
    					->where('isSent', false)
    					->where('isDraft', false)->orderBy('created_at', 'DESC')->take(3)->get();
}

function draftMailCount(){
    return InboxMail::where('isTrash', false)
    					->where('isSent', false)
    					->where('isDraft', true)->get()->count();
}

function inboxLabels(){
	return ContactForm::all();
}

function isNotImage($mime){
	if($mime == 'image/jpeg'){
        return false;
    }
    elseif ($mime == 'image/png'){
        return false;
    }
    return true;
}

function getImageExtension($mime){
	if($mime == 'image/jpeg'){
        $extension = '.jpg';
    }
    elseif ($mime == 'image/png'){
        $extension = '.png';
    }
    return $extension;
}

function pivotToString($collection, $column){
    $result = "";
    foreach($collection as $item){
        $result .= $item->$column . " / ";
    }
    return mb_substr($result, 0, -3);
}

function pivotToMix($collection, $column, $prefix){
    $result = "";
    foreach($collection as $item){
        $result .= $prefix . $item->$column . " ";
    }
    return mb_substr($result, 0, -1);
}

function pivotToLink($collection, $column){
    $result = "";
    foreach($collection as $item){
        $result .= '<a href="'.url(config('app.locale').'/hizmetlerimiz/'.$item->url).'">'.$item->$column . "</a> / ";
    }
    return mb_substr($result, 0, -3);
}

function getTagString($collection){
	$string = "";
	foreach($collection as $element){
		$string .= $element->title_tr . " / ";
	}
	return $string;
}

function sameLinkFor($locale){
    return LaravelLocalization::getLocalizedURL($locale);
}

function catalogOf($key){
    return ProductCatalog::where('key', $key)->first();
}

function imagesOf($key){
    return ProductImage::where('key', $key)->where('publish', true)->orderBy('position', 'ASC')->get();
}