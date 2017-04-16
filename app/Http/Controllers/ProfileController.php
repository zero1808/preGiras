<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Municipality;
use App\Order;
use App\Profile;
use App\User;
use App\Team;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $municipios_list = Municipality::all();

        return view('profiles/new')->with('municipios', $municipios_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
        $request->user()->profile()->create([
            'name' => $request->name,
            'ap_paterno' => $request->ap_paterno,
            'ap_materno' => $request->ap_materno,
            'direccion' => $request->direccion,
            'idMunicipio' => $request->municipio,
            'telefono_cel' => $request->telefono_cel,
            'telefono_casa' => $request->telefono_casa,
            'status' => 1
        ]);
        return redirect('/home');
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
        //
    }

    public function team(Request $request) {
        if (Auth::check()) {
            try {
                $profile = Profile::find($request->idProfile);
                $profile->idTeam = $request->equipoId;
                $profile->save();
                return $this->onSuccessChangeTeam('Cambio de equipo con exito!');
            } catch (Exception $e) {
                return $this->onSuccessChangeTeam($e->getMessage());
            }
        }
    }
    public function onSuccessChangeTeam($successMessage){
        $usuarios = User::all();
        $teams = Team::all();
        if(count($usuarios)>0){
            return view('users/view')->with('messages','Actualmente existen los siguientes usuarios:')->with('usuarios',$usuarios)->with('teams',$teams)->with('succesMessage',$successMessage);
        }else{
            return view('users/view')->with('messages','No existen usuarios registrados')->with('successMessage',$successMessage);
        }
    }

}
