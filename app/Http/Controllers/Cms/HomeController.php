<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Models\Cms\Task;
use Analytics;
use Spatie\Analytics\Period;
use App\Models\Cms\Inbox\InboxMail;

class HomeController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::all();
        $mails = InboxMail::where('isTrash', false)->where('isSent', false)->where('isDraft', false)->orderBy('created_at', 'DESC')->take(10)->get();
        if(config('app.env') == 'local'){
        	return view('cms.home', compact('tasks', 'mails'));
        }else{
	        $totalVisitorsAndPageViews = Analytics::fetchTotalVisitorsAndPageViews(Period::days(60));
	        $topOs = Analytics::performQuery(Period::days(30), 'ga:pageviews', ['dimensions' => 'ga:operatingSystem', 'sort' => '-ga:pageviews']);
	        $topReferrers = Analytics::fetchTopReferrers(Period::days(30))->take(4);
	        $topBrowser = Analytics::fetchTopBrowsers(Period::days(30))->first();
	        $mostVisitedPage = Analytics::fetchMostVisitedPages(Period::days(30))->first();
	        $newSessions = Analytics::performQuery(Period::days(30), 'ga:percentNewSessions', ['dimensions' => 'ga:source']);

	        return view('cms.home', compact('tasks', 'mostVisitedPage', 'topBrowser', 'totalVisitorsAndPageViews', 'topReferrer', 'topReferrers', 'newSessions', 'topOs', 'mails'));
        }
    }



    
}
