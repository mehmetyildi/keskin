<?php

namespace App\Http\Controllers\Cms;

use Illuminate\Http\Request;
use App\Models\Cms\Task;


class TasksController extends BaseController
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
     * Show the tasks dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = Task::all();
        return view('cms.tasks.index', compact('tasks'));
    }

    /**
     * Change the settings
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Task::create($request->all());
        return 'Yeni iş eklendi';
    }

    /**
     * Change the settings
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $task = Task::findOrFail($request->id);
        $task->description = $request->description;
        $task->save();
        return 'İş güncellendi';
    }


    /**
     * Show the form for adding new to-do.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetch()
    {
        return Task::where('isDone', false)->latest()->get();
    }

    /**
     * Reorder records
     *
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request){
        $dataIds = json_decode(stripslashes($request->ids));
    
        for($i=0; $i<count($dataIds); $i++){
            $record = Task::find($dataIds[$i]);
            $record->position = $i + 1;
            $record->isDone = false;
            $record->save();
        }
        return 'İşler güncellendi';
    }

    /**
     * Reorder records
     *
     * @return \Illuminate\Http\Response
     */
    public function orderCompleted(Request $request){
        $dataIds = json_decode(stripslashes($request->ids));
    
        for($i=0; $i<count($dataIds); $i++){
            $record = Task::find($dataIds[$i]);
            $record->position = $i + 1;
            $record->isDone = true;
            $record->save();
        }
        return 'İşler güncellendi';
    }
    
}
