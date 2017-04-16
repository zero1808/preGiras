<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Team;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if (Auth::check()) {
            $equipos = Team::all();
            if (count($equipos) > 0) {
                return view('teams/view')->with('messages', 'Actualmente existen los siguientes equipos:')->with('equipos', $equipos);
            } else {
                return view('teams/view')->with('messages', 'No existen equipos registrados');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (Auth::check()) {
            return view('teams/new');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (Auth::check()) {
            try {
                $team = new Team();
                $team->nombre = $request->nombre;
                $team->status = 1;
                $team->save();
                return view('teams/new')->with('messages', 'Se creo el equipo correctamente!');
            } catch (Exception $e) {
                // do task when error
                return view('teams/new')->with('messages', $e->getMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if (Auth::check()) {
            try {
                $equipo = Team::find($id);
                if (count($equipo) != 0) {
                    $equipo->delete();
                    return redirect('/teams');
                } else {
                    
                }
            } catch (Exception $e) {
                
            }
        }
    }

}
