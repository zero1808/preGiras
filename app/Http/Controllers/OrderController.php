<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\Team;

class OrderController extends Controller {

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
        try {

            $orders = Order::where('idTeam', '=', $request->idTeam)->where('idEvent', '=', $request->evento)->get();
            if (count($orders) == 0) {
                $order = new Order();
                $order->idEvent = $request->evento;
                $order->idTeam = $request->idTeam;
                $order->status = 1;
                $order->save();
                $equipos = Team::all();
                if (count($equipos) > 0) {
                    return view('teams/view')->with('messages', 'Actualmente existen los siguientes equipos:')->with('equipos', $equipos)->with('onSuccessMessage', 'Se asigno el evento correctamente');
                } else {
                    return view('teams/view')->with('messages', 'No existen equipos actualmente:')->with('equipos', $equipos)->with('onSuccessMessage', 'Se asigno el evento correctamente');
                }
            } else {
                $equipos = Team::all();
                if (count($equipos) > 0) {
                    return view('teams/view')->with('messages', 'Actualmente existen los siguientes equipos:')->with('equipos', $equipos)->with('error', 'El evento ya habia sido asignado a este equipo anteriormente');
                } else {
                    return view('teams/view')->with('messages', 'No existen equipos actualmente:')->with('equipos', $equipos)->with('error', 'El evento ya habia sido asignado a este equipo anteriormente');
                } 
            }
        } catch (Exception $e) {
            $equipos = Team::all();
            if (count($equipos) > 0) {
                return view('teams/view')->with('messages', 'Actualmente existen los siguientes equipos:')->with('equipos', $equipos)->with('onSuccessMessage', $e->getMessage());
            } else {
                return view('teams/view')->with('messages', 'No existen equipos actualmente:')->with('equipos', $equipos)->with('onSuccessMessage', $e->getMessage());
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
//
    }

}
