<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
use App\User;
use App\Order;
use App\Municipality;
use App\Seccional;
use App\Event;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (Auth::check()) {
            $user = Auth::user();
            $messages = '';

            if (!$user->profile) {
                return redirect()->route('profiles.create');
            } else {
                $municipios = Municipality::all();
                $profiles = User::where('level', '=', '2')->get();
                $seccionales = Seccional::all();
                if ($user->level == 1) {
                    //$events = Event::where('events.status','=','1')->select('events.id as id_v','events.nombre as nombre_evento','events.f_inicio as fi','municipalities.name as nombre_m','profiles.name as nombre_p','profiles.ap_paterno as ap','profiles.ap_materno as am')->leftJoin('municipalities','events.idMunicipio','=','municipalities.id')->leftJoin('profiles','events.idResponsable','=','profiles.id')->get();
                    
                    $events = Event::all()->sortByDesc('id');
                    if (count($events) > 0) {
                        $messages = 'Actualmente existen los siguientes eventos de pregira:';
                    } else {
                        $messages = 'No existen eventos de pregira';
                    }
                    return view('home')->with('eventos', $events)->with('messages', $messages)->with('municipios', $municipios)->with('profiles', $profiles)->with('seccionales',$seccionales);
                } else if ($user->level == 2) {
                    $profile = Auth::user()->profile;
                    if ($profile->idTeam == NULL || empty($profile->idTeam) || $profile->idTeam == '') {
                        $events_responsable = Event::where('idResponsable', '=', $profile->id)->orderBy('id','desc')->get();
                        if (count($events_responsable) > 0) {
                            $messages = 'Eres responsable de los siguientes eventos:';
                        } else {
                            $messages = 'Hasta el momento no eres responsable de algún evento';
                        }
                        return view('home')->with('eventos_responsable', $events_responsable)->with('messages', $messages)->with('noequipo', 'Aun no te han asignado a algún equipo')->with('municipios', $municipios)->with('seccionales',$seccionales)->with('profiles', $profiles);
                    } else {
                        $events_responsable = Event::where('idResponsable', '=', $profile->id)->orderBy('id','desc')->get();
                        $events_team = Event::where('orders.idTeam', '=', $profile->idTeam)->leftJoin('orders', 'orders.idEvent', '=', 'events.id')->select('events.*','orders.id as idorden')->orderBy('id','desc')->get();
                        if (count($events_responsable) > 0) {
                            $messages = 'Eres responsable de los siguientes eventos:';
                        } else {
                            $messages = 'Hasta el momento no eres responsable de algún evento';
                        }

                        if (count($events_team) > 0) {
                            $messageEquipo = 'Tu equipo es responsable de los siguientes eventos:';
                        } else {
                            $messageEquipo = 'Hasta el momento tu equipo no es responsable de algun evento;';
                        }
                        return view('home')->with('eventos_responsable', $events_responsable)->with('messages', $messages)->with('eventos_equipo', $events_team)->with('messageEquipo', $messageEquipo)->with('municipios', $municipios)->with('seccionales',$seccionales)->with('profiles', $profiles);
                    }
                }
                else if($user->level == 3){
                    $profile = Auth::user()->profile;
                    return redirect()->to('/calendario');
                }
            }
        }
    }

}
