<?php

namespace App\Http\Controllers;

use App\Models\tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
         return $tareas = tarea::select('tareas.*','status.name as status_name')
        ->join('status','tareas.status_id','status.id')
        ->where('tareas.user_id','=',$request['user'])
        ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required ||max:20||min:5',
            'desc' => 'required',
            'owner' => 'required'
        ]);

        tarea::create([
            'title' => $request['title'],
            'description' => $request['desc'],
            'user_id' => $request['owner'],
            'status_id' => 1 //created with seeders
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(tarea $tarea)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tarea $tarea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
        $validated = $request->validate([
            'id' => 'required||integer',
            'title' => 'required||max:20||min:5 ',
            'desc' => 'required ',
            'owner' => 'required'
        ]);

        tarea::where('id','=',$request['id'])
        ->update([
            'title' => $request['title'],
            'description' => $request['desc'],
            'user_id' => $request['owner'],
            'status_id' => $request['status']
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        tarea::where('id','=',$request['task'])
        ->delete();
    }
}
