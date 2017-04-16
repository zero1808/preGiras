<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Team;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

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
            $usuarios = User::all();
            $teams = Team::all();
            if (count($usuarios) > 0) {
                return view('users/view')->with('messages', 'Actualmente existen los siguientes usuarios:')->with('usuarios', $usuarios)->with('teams', $teams);
            } else {
                return view('users/view')->with('messages', 'No existen usuarios registrados');
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
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
                $usuario = User::find($id);
                if (count($usuario) != 0) {
                    $usuario->delete();
                    return redirect('/users');
                } else {
                    
                }
            } catch (Exception $e) {
                
            }
        }
    }

    
}
