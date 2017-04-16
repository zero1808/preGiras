<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Event;
use App\Place;
use App\Picplace;
use App\Bossplace;
use Input;
use Validator;
use Redirect;
use Session;
use Illuminate\Support\Facades\Hash;
use Carbon;

class PlaceController extends Controller {

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
                $evento = Event::find($request->idEventoPlaces);
                if (count($evento) > 0) {
                    if (!$evento->place) {
                        $place = new Place();
                        $place->idEvent = $request->idEventoPlaces;
                        $place->descripcion = $request->descripcion_lugar;
                        if ($request->acceso_lugar != '0') {
                            $place->acceso_lugar = $request->acceso_lugar;
                        } else {
                            $place->acceso_lugar = $request->other_acceso;
                        }
                        if ($request->lugar != '0') {
                            $place->lugar = $request->lugar;
                        } else {
                            $place->lugar = $request->other_lugar;
                        }
                        $place->riesgos = $request->riesgos_sociales;
                        $place->problematica = $request->problematica_politica;
                        $fotoslugar_frente = $request->file('fotoslugar_frente');
                        if (!isset($fotoslugar_frente) || empty($fotoslugar_frente)) {
                            
                        } else {
                            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                            $validator = Validator::make(array('file' => $fotoslugar_frente), $rules);
                            if ($validator->passes()) {
                                $destinationPath = 'uploads/fotos_lugar/';
                                $caracteres = "0123456789abcdefABCDEF";
                                $longitud = 25;

                                $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                                $extension = explode(".", $fotoslugar_frente->getClientOriginalName());
                                $filename = $cadena_aux . "." . $extension[1];
                                $upload_success = $fotoslugar_frente->move($destinationPath, $filename);
                                if ($upload_success) {
                                    $place->imagen_frente = $filename;
                                }
                            }
                        }
                        $fotoslugar_atras = $request->file('fotoslugar_atras');
                        if (!isset($fotoslugar_atras) || empty($fotoslugar_atras)) {
                            
                        } else {
                            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                            $validator = Validator::make(array('file' => $fotoslugar_atras), $rules);
                            if ($validator->passes()) {
                                $destinationPath = 'uploads/fotos_lugar/';
                                $caracteres = "0123456789abcdefABCDEF";
                                $longitud = 25;

                                $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                                $extension = explode(".", $fotoslugar_atras->getClientOriginalName());
                                $filename = $cadena_aux . "." . $extension[1];
                                $upload_success = $fotoslugar_atras->move($destinationPath, $filename);
                                if ($upload_success) {
                                    $place->imagen_atras = $filename;
                                }
                            }
                        }
                        $fotoslugar_exterior = $request->file('fotoslugar_exterior');
                        if (!isset($fotoslugar_exterior) || empty($fotoslugar_exterior)) {
                            
                        } else {
                            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                            $validator = Validator::make(array('file' => $fotoslugar_exterior), $rules);
                            if ($validator->passes()) {
                                $destinationPath = 'uploads/fotos_lugar/';
                                $caracteres = "0123456789abcdefABCDEF";
                                $longitud = 25;

                                $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                                $extension = explode(".", $fotoslugar_exterior->getClientOriginalName());
                                $filename = $cadena_aux . "." . $extension[1];
                                $upload_success = $fotoslugar_exterior->move($destinationPath, $filename);
                                if ($upload_success) {
                                    $place->imagen_exterior = $filename;
                                }
                            }
                        }
                        $saved = $place->save();
                        //$this->multiple_upload_fotos_nuevo($request);
                        //$this->addBosses($request);
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
                        $saved = $this->update($request, $evento->place->id);

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
            } catch (Exception $ex) {
                
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
        if (Auth::check()) {
            try {
                $place = Place::find($id);
                if (count($place) > 0) {
                    $place->idEvent = $request->idEventoPlaces;
                    $place->descripcion = $request->descripcion_lugar;
                    if ($request->acceso_lugar != '0') {
                        $place->acceso_lugar = $request->acceso_lugar;
                    } else {
                        $place->acceso_lugar = $request->other_acceso;
                    }
                    if ($request->lugar != '0') {
                        $place->lugar = $request->lugar;
                    } else {
                        $place->lugar = $request->other_lugar;
                    }
                    $place->riesgos = $request->riesgos_sociales;
                    $place->problematica = $request->problematica_politica;
                    $fotoslugar_frente = $request->file('fotoslugar_frente');
                    if (!isset($fotoslugar_frente) || empty($fotoslugar_frente)) {
                        
                    } else {
                        $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                        $validator = Validator::make(array('file' => $fotoslugar_frente), $rules);
                        if ($validator->passes()) {
                            $destinationPath = 'uploads/fotos_lugar/';
                            $caracteres = "0123456789abcdefABCDEF";
                            $longitud = 25;

                            $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                            $extension = explode(".", $fotoslugar_frente->getClientOriginalName());
                            $filename = $cadena_aux . "." . $extension[1];
                            $upload_success = $fotoslugar_frente->move($destinationPath, $filename);
                            if ($upload_success) {
                                $place->imagen_frente = $filename;
                            }
                        }
                    }
                    $fotoslugar_atras = $request->file('fotoslugar_atras');
                    if (!isset($fotoslugar_atras) || empty($fotoslugar_atras)) {
                        
                    } else {
                        $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                        $validator = Validator::make(array('file' => $fotoslugar_atras), $rules);
                        if ($validator->passes()) {
                            $destinationPath = 'uploads/fotos_lugar/';
                            $caracteres = "0123456789abcdefABCDEF";
                            $longitud = 25;

                            $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                            $extension = explode(".", $fotoslugar_atras->getClientOriginalName());
                            $filename = $cadena_aux . "." . $extension[1];
                            $upload_success = $fotoslugar_atras->move($destinationPath, $filename);
                            if ($upload_success) {
                                $place->imagen_atras = $filename;
                            }
                        }
                    }
                    $fotoslugar_exterior = $request->file('fotoslugar_exterior');
                    if (!isset($fotoslugar_exterior) || empty($fotoslugar_exterior)) {
                        
                    } else {
                        $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                        $validator = Validator::make(array('file' => $fotoslugar_exterior), $rules);
                        if ($validator->passes()) {
                            $destinationPath = 'uploads/fotos_lugar/';
                            $caracteres = "0123456789abcdefABCDEF";
                            $longitud = 25;

                            $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                            $extension = explode(".", $fotoslugar_exterior->getClientOriginalName());
                            $filename = $cadena_aux . "." . $extension[1];
                            $upload_success = $fotoslugar_exterior->move($destinationPath, $filename);
                            if ($upload_success) {
                                $place->imagen_exterior = $filename;
                            }
                        }
                    }
                    $saved = $place->save();
                    /*$this->multiple_upload_fotos_existe($request);
                    $this->addBosses($request);*/
                    return $saved;
                } else {
                    $message = "Ocurrio un error, no se encontro el evento o el evento fue borrado";
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

    public function multiple_upload_fotos_nuevo(Request $request) {
// getting all of the post data
        $files = $request->file('fotos_lugar');
// Making counting of uploaded images
        $file_count = count($files);
// start count how many uploaded
        $uploadcount = 0;
        if (!isset($files) || empty($files) || $file_count = 0) {
            
        } else {
            foreach ($files as $file) {
                $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                $validator = Validator::make(array('file' => $file), $rules);
                if ($validator->passes()) {
                    $destinationPath = 'uploads';
                    $caracteres = "0123456789abcdefABCDEF";
                    $longitud = 20;

                    $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                    $extension = explode(".", $file->getClientOriginalName());
                    $filename = $cadena_aux . "." . $extension[1];
                    $upload_success = $file->move($destinationPath, $filename);
                    if ($upload_success) {
                        $uploadcount ++;
                        $places = Place::where('idEvent', '=', $request->idEventoPlaces)->get();
                        if (count($places) > 0) {
                            $pic = new Picplace();
                            $place = $places[0];
                            $pic->idPlace = $place->id;
                            $pic->url = $filename;
                            $pic->save();
                        }
                    }
                }
            }

            if ($uploadcount == $file_count) {
                Session::flash('success', 'Upload successfully');
                return redirect('/home');
            } else {
                return redirect('/home')->withInput()->withErrors($validator);
            }
        }
    }

    public function multiple_upload_fotos_existe(Request $request) {
// getting all of the post data
        $files = $request->file('fotoslugar');
// Making counting of uploaded images
        $file_count = count($files);
// start count how many uploaded
        $uploadcount = 0;
        if (!isset($files) || empty($files) || $file_count = 0) {
            
        } else {
            foreach ($files as $file) {
                $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                $validator = Validator::make(array('file' => $file), $rules);
                if ($validator->passes()) {
                    $destinationPath = 'uploads';
                    $caracteres = "0123456789abcdefABCDEF";
                    $longitud = 20;

                    $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                    $extension = explode(".", $file->getClientOriginalName());
                    $filename = $cadena_aux . "." . $extension[1];
                    $upload_success = $file->move($destinationPath, $filename);
                    if ($upload_success) {
                        $uploadcount ++;
                        $pic = new Picplace();
                        $places = Place::where('idEvent', '=', $request->idEventoPlaces)->get();
                        if (count($places) > 0) {
                            $place = $places[0];
                            $pic->idPlace = $place->id;
                            $pic->url = $filename;
                            $pic->save();
                        }
                    }
                }
            }
            if ($uploadcount == $file_count) {
                Session::flash('success', 'Upload successfully');
                return redirect('/home');
            } else {
                return redirect('/home')->withInput()->withErrors($validator);
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

    public function addBosses(Request $request) {

        if (Auth::check()) {
            try {
                if (isset($request->AutoridadeslugarNombre) && isset($request->AutoridadeslugarCargo) && isset($request->AutoridadeslugarObservaciones)) {
                    $nombres = $request->AutoridadeslugarNombre;
                    $cargos = $request->AutoridadeslugarCargo;
                    $observaciones = $request->AutoridadeslugarObservaciones;
                    $nombresarray = array();
                    $cargosarray = array();
                    $observacionesarray = array();
                    $places = Place::where('idEvent', '=', $request->idEventoPlaces)->get();
                    if (count($places) > 0) {
                        $place = $places[0];
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
                                $boss = new Bossplace();
                                $boss->idPlace = $place->id;
                                $boss->nombre = $nombresarray[$i];
                                $boss->cargo = $cargosarray[$i];
                                $boss->observaciones = $observacionesarray[$i];
                                $boss->save();
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
