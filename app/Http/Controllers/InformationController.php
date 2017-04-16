<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Information;
use App\Event;
use App\Comitereception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Input;
use Validator;
use Redirect;
use Session;
use Illuminate\Support\Facades\Hash;
use Carbon;

class InformationController extends Controller {

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
        if (Auth::check()) {
            try {
                $evento = Event::find($request->idEvento);
                if (count($evento) > 0) {
                    if (!$evento->information) {
                        $information = new Information();
                        $information->idEvent = $request->idEvento;
                        $information->tipo_evento = $request->tipo_evento;
                        $information->vestimenta = $request->vestimenta;
                        $information->sugerencia_vestimenta = $request->sugerenciavestimenta;
                        //$information->trascendencia = $request->trascendencia;
                        $information->rentabilidad = $request->rentabilidad;
                        $information->asistentes = $request->asistentes_aprox;
                        if ($request->participacioncandidato != '0') {
                            $information->participacion = $request->participacioncandidato;
                        } else {
                            $information->participacion = $request->otro_participacion;
                        }
                        if ($request->sector != '0') {
                            $information->sector = $request->sector;
                        } else {
                            $information->sector = $request->otro_sector;
                        }
                        $information->tema = $request->tema;
                        $information->folletos = $request->folletos;
                        $information->utilitarios = $request->utilitarios;

                        $saved = $information->save();
                        //$this->addComite($request);
                        if ($saved) {
                            return response()->json([
                                        'status' => true
                            ]);
                        } else {
                            return response()->json([
                                        'status' => false
                            ]);
                        }
                    } else {

                        $saved = $this->update($request, $request->idInformation);
                        //$this->upload_foto_responsable_existe($request, $request->idInformation);
                        if ($saved) {
                            return response()->json([
                                        'status' => true
                            ]);
                        } else {
                            return response()->json([
                                        'status' => false
                            ]);
                        }
                    }
                } else {
                    $message = 'Ocurrio un error al buscar el evento, el evento no existe o fue borrado';
                }
            } catch (Exception $e) {
                
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
        if (Auth::check()) {
            try {

                $information = Information::find($id);
                if (count($information) > 0) {
                    $information->tipo_evento = $request->tipo_evento;
                    $information->vestimenta = $request->vestimenta;
                    $information->sugerencia_vestimenta = $request->sugerenciavestimenta;
                    //$information->trascendencia = $request->trascendencia;
                    $information->rentabilidad = $request->rentabilidad;
                    $information->asistentes = $request->asistentes_aprox;
                    if ($request->participacioncandidato != '0') {
                        $information->participacion = $request->participacioncandidato;
                    } else {
                        $information->participacion = $request->otro_participacion;
                    }
                    if ($request->sector != '0') {
                        $information->sector = $request->sector;
                    } else {
                        $information->sector = $request->otro_sector;
                    }
                    $information->tema = $request->tema;
                    $information->folletos = $request->folletos;
                    $information->utilitarios = $request->utilitarios;
                    $saved = $information->save();
                    //$this->addComite($request);
                    return $saved;
                } else {
                    $message = 'Ocurrio un error al buscar el evento, el evento no existe o fue borrado';
                }
            } catch (Exception $e) {
                
            }
        }
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

    public function upload_foto_responsable_existe(Request $request, $id) {
// getting all of the post data
        $file = $request->file('foto_responsable');
// Making counting of uploaded images
        if (!isset($file) || empty($file)) {
            
        } else {
            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
            $validator = Validator::make(array('file' => $file), $rules);
            if ($validator->passes()) {
                $destinationPath = 'uploads';
                $caracteres = "0123456789abcdefABCDEF";
                $longitud = 20;

                $cadena_aux = $this->rand_code($caracteres, $longitud);
                $filename = $request->idInformation . $cadena_aux . $file->getClientOriginalName();
                $upload_success = $file->move($destinationPath, $filename);
                if ($upload_success) {
                    $information = Information::find($request->idInformation);
                    if (count($information) > 0) {
                        $information->foto_responsable = $filename;
                        $information->save();
                    }
                }
            }
        }
    }

    function rand_code($chars, $long) {
        $code = "";
        for ($x = 0; $x <= $long; $x++) {
            $rand = rand(1, strlen($chars));
            $code .= substr($chars, $rand, 1);
        }
        return $code;
    }

    public function addComite(Request $request) {
        if (Auth::check()) {
            try {
                if (isset($request->ComitebienvenidaNombre) && isset($request->ComitebienvenidaCargo) && isset($request->ComitebienvenidaObservaciones)) {
                    $nombres = $request->ComitebienvenidaNombre;
                    $cargos = $request->ComitebienvenidaCargo;
                    $observaciones = $request->ComitebienvenidaObservaciones;
                    $nombresarray = array();
                    $cargosarray = array();
                    $observacionesarray = array();
                    $informations = Information::where('idEvent', '=', $request->idEvento)->get();
                    if (count($informations) > 0) {
                        $information = $informations[0];
                        if (!empty($nombres)) {
                            foreach ($nombres as $nombre) {
                                if (empty($nombre) || $nombre == '' || $nombre == null) {
                                    $nombre = NULL;
                                }
                                array_push($nombresarray, $nombre);
                            }
                        }
                        if (!empty($cargos)) {
                            foreach ($cargos as $cargo) {
                                if (empty($cargo) || $cargo == '' || $cargo == null) {
                                    $cargo = 'NA';
                                } else {
                                    $cargo = $cargo;
                                }
                                array_push($cargosarray, $cargo);
                            }
                        }
                        if (!empty($observaciones)) {
                            foreach ($observaciones as $observacion) {
                                if (empty($observacion) || $observacion == '' || $observacion == null) {
                                    $observacion = 'NA';
                                }
                                array_push($observacionesarray, $observacion);
                            }
                        }

                        for ($i = 0; $i < count($nombresarray); $i++) {
                            if (empty($nombresarray[$i]) || $nombresarray[$i] == null || $nombresarray[$i] == '') {
                                
                            } else {
                                $comite = new Comitereception();
                                $comite->idInformation = $information->id;
                                $comite->nombre = $nombresarray[$i];
                                $comite->cargo = $cargosarray[$i];
                                $comite->observaciones = $observacionesarray[$i];
                                $comite->save();
                            }
                        }
                    } else {
                        
                    }
                }
            } catch (Exception $ex) {
                $message = $ex - getMessage();
            }
        }
    }

}
