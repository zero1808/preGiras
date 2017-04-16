<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use App\Presidiummember;
use App\Event;
use App\Especialassistan;
use App\Firstline;
use App\Dayorder;
use Input;
use Validator;
use Redirect;
use Session;
use Illuminate\Support\Facades\Hash;
use Carbon;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller {

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
                $evento = Event::find($request->idEventPrograms);
                if (count($evento) > 0) {
                    if (!$evento->program) {
                        $program = new Program();
                        $program->idEvent = $request->idEventPrograms;
                        $program->contenido = $request->contenido;
                        $program->estado_entrega = $request->entrega_informacion;
                        $program->asistentes_ficha = $request->asistentes_ficha;
                        $contenido = $request->file('archivo_lineas_discursivas');
                        $programa = $request->file('archivo_programa_evento');
                        if (!isset($contenido) || empty($contenido)) {
                            
                        } else {
                            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                            $validator = Validator::make(array('file' => $contenido), $rules);
                            if ($validator->passes()) {
                                $destinationPath = 'uploads/discursivas';
                                $caracteres = "0123456789abcdefABCDEF";
                                $longitud = 20;

                                $cadena_aux = $this->rand_code($caracteres, $longitud);
                                $filename = $request->idEventPrograms . $cadena_aux . $contenido->getClientOriginalName();
                                $upload_success = $contenido->move($destinationPath, $filename);
                                if ($upload_success) {
                                    $program->url_contenido = $filename;
                                }
                            }
                        }
                        if (!isset($programa) || empty($programa)) {
                            
                        } else {
                            $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                            $validator = Validator::make(array('file' => $programa), $rules);
                            if ($validator->passes()) {
                                $destinationPath = 'uploads/discursivas';
                                $caracteres = "0123456789abcdefABCDEF";
                                $longitud = 20;

                                $cadena_aux = $this->rand_code($caracteres, $longitud);
                                $filename = $request->idEventPrograms . $cadena_aux . $programa->getClientOriginalName();
                                $upload_success = $programa->move($destinationPath, $filename);
                                if ($upload_success) {
                                    $program->url_programa = $filename;
                                }
                            }
                        }
                        $saved = $program->save();
                        $this->addPresidium($request);
                        $this->addInvitadosEspeciales($request);
                        $this->addFirstLines($request);
                        $this->addOrdenes($request);
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
                        $saved = $this->update($request, $evento->program->id);

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

                $program = Program::find($id);
                if (count($program) > 0) {
                    $program->contenido = $request->contenido;
                    $program->estado_entrega = $request->entrega_informacion;
                    $program->asistentes_ficha = $request->asistentes_ficha;
                    $contenido = $request->file('archivo_lineas_discursivas');
                    $programa = $request->file('archivo_programa_evento');
                    if (!isset($contenido) || empty($contenido)) {
                        
                    } else {
                        $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                        $validator = Validator::make(array('file' => $contenido), $rules);
                        if ($validator->passes()) {
                            $destinationPath = 'uploads/discursivas';
                            $caracteres = "0123456789abcdefABCDEF";
                            $longitud = 20;

                            $cadena_aux = $this->rand_code($caracteres, $longitud);
                            $filename = $request->idEventPrograms . $cadena_aux . $contenido->getClientOriginalName();
                            $upload_success = $contenido->move($destinationPath, $filename);
                            if ($upload_success) {
                                $program->url_contenido = $filename;
                            }
                        }
                    }
                    if (!isset($programa) || empty($programa)) {
                        
                    } else {
                        $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                        $validator = Validator::make(array('file' => $programa), $rules);
                        if ($validator->passes()) {
                            $destinationPath = 'uploads/discursivas';
                            $caracteres = "0123456789abcdefABCDEF";
                            $longitud = 20;

                            $cadena_aux = $this->rand_code($caracteres, $longitud);
                            $filename = $request->idEventPrograms . $cadena_aux . $programa->getClientOriginalName();
                            $upload_success = $programa->move($destinationPath, $filename);
                            if ($upload_success) {
                                $program->url_programa = $filename;
                            }
                        }
                    }
                    $saved=$program->save();
                    $this->addPresidium($request);
                    $this->addInvitadosEspeciales($request);
                    $this->addFirstLines($request);
                    $this->addOrdenes($request);
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

    public function addPresidium(Request $request) {
        if (Auth::check()) {
            try {
                if (isset($request->PresidiumNumero) && isset($request->PresidiumNombre) && isset($request->PresidiumCargo)) {
                    $numeros = $request->PresidiumNumero;
                    $nombres = $request->PresidiumNombre;
                    $cargos = $request->PresidiumCargo;
                    $fotos = $request->PresidiumFoto;
                    $numerossarray = array();
                    $nombresarray = array();
                    $cargosarray = array();
                    $fotosarray = array();
                    $programs = Program::where('idEvent', '=', $request->idEventPrograms)->get();
                    if (count($programs) > 0) {
                        $program = $programs[0];
                        if (!empty($numeros)) {
                            foreach ($numeros as $numero) {
                                if (empty($numero) || $numero == '' || $numero == null) {
                                    $numero = NULL;
                                }
                                array_push($numerossarray, $numero);
                            }
                        }
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
                                }
                                array_push($cargosarray, $cargo);
                            }
                        }
                        if (!empty($fotos)) {
                            foreach ($fotos as $foto) {
                                if (empty($foto) || $foto == '' || $foto == null) {
                                    $foto = null;
                                }
                                array_push($fotosarray, $foto);
                            }
                        }

                        for ($i = 0; $i < count($numerossarray); $i++) {
                            if (empty($nombresarray[$i]) || $nombresarray[$i] == null || $nombresarray[$i] == '') {
                                
                            } else {
                                $presidiummember = new Presidiummember();
                                $presidiummember->idProgram = $program->id;
                                $presidiummember->numero = $numerossarray[$i];
                                $presidiummember->nombre = $nombresarray[$i];
                                $presidiummember->cargo = $cargosarray[$i];
                                if (!isset($fotosarray[$i]) || empty($fotosarray[$i])) {
                                    
                                } else {
                                    $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                                    $validator = Validator::make(array('file' => $fotosarray[$i]), $rules);
                                    if ($validator->passes()) {
                                        $destinationPath = 'uploads';
                                        $caracteres = "0123456789abcdefABCDEF";
                                        $longitud = 20;

                                        $cadena_aux = $this->rand_code($caracteres, $longitud);
                                        $filename = $program->id . $cadena_aux . $fotosarray[$i]->getClientOriginalName();
                                        $upload_success = $fotosarray[$i]->move($destinationPath, $filename);
                                        if ($upload_success) {
                                            $presidiummember->foto = $filename;
                                        }
                                    }
                                }
                                $presidiummember->save();
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

    public function addInvitadosEspeciales(Request $request) {
        if (Auth::check()) {
            try {
                if (isset($request->InvitadosENumero) && isset($request->InvitadosENombre) && isset($request->InvitadosECargo)) {
                    $numeros = $request->InvitadosENumero;
                    $nombres = $request->InvitadosENombre;
                    $cargos = $request->InvitadosECargo;
                    $fotos = $request->InvitadosEFoto;
                    $numerossarray = array();
                    $nombresarray = array();
                    $cargosarray = array();
                    $fotosarray = array();
                    $programs = Program::where('idEvent', '=', $request->idEventPrograms)->get();
                    if (count($programs) > 0) {
                        $program = $programs[0];
                        if (!empty($numeros)) {
                            foreach ($numeros as $numero) {
                                if (empty($numero) || $numero == '' || $numero == null) {
                                    $numero = NULL;
                                }
                                array_push($numerossarray, $numero);
                            }
                        }
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

                        if (!empty($fotos)) {
                            foreach ($fotos as $foto) {
                                if (empty($foto) || $foto == '' || $foto == null) {
                                    $foto = null;
                                }
                                array_push($fotosarray, $foto);
                            }
                        }

                        for ($i = 0; $i < count($numerossarray); $i++) {
                            if (empty($nombresarray[$i]) || $nombresarray[$i] == null || $nombresarray[$i] == '') {
                                
                            } else {
                                $invitadoe = new Especialassistan();
                                $invitadoe->idProgram = $program->id;
                                $invitadoe->numero = $numerossarray[$i];
                                $invitadoe->nombre = $nombresarray[$i];
                                $invitadoe->cargo = $cargosarray[$i];
                                if (!isset($fotosarray[$i]) || empty($fotosarray[$i])) {
                                    
                                } else {
                                    $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                                    $validator = Validator::make(array('file' => $fotosarray[$i]), $rules);
                                    if ($validator->passes()) {
                                        $destinationPath = 'uploads';
                                        $caracteres = "0123456789abcdefABCDEF";
                                        $longitud = 20;

                                        $cadena_aux = $this->rand_code($caracteres, $longitud);
                                        $filename = $program->id . $cadena_aux . $fotosarray[$i]->getClientOriginalName();
                                        $upload_success = $fotosarray[$i]->move($destinationPath, $filename);
                                        if ($upload_success) {
                                            $invitadoe->foto = $filename;
                                        }
                                    }
                                }
                                $invitadoe->save();
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

    public function addFirstLines(Request $request) {
        if (Auth::check()) {
            try {
                if (isset($request->PrimeraslineasNumero) && isset($request->PrimeraslineasNombre) && isset($request->PrimeraslineasJustificacion)) {
                    $lineas = $request->PrimeraslineasNumero;
                    $cargos = $request->PrimeraslineasNombre;
                    $justificaciones = $request->PrimeraslineasJustificacion;
                    $lineassarray = array();
                    $cargosarray = array();
                    $justificacionesarray = array();
                    $programs = Program::where('idEvent', '=', $request->idEventPrograms)->get();
                    if (count($programs) > 0) {
                        $program = $programs[0];
                        if (!empty($lineas)) {
                            foreach ($lineas as $linea) {
                                if (empty($linea) || $linea == '' || $linea == null) {
                                    $linea = null;
                                }
                                array_push($lineassarray, $linea);
                            }
                        }

                        if (!empty($cargos)) {
                            foreach ($cargos as $cargo) {
                                if (empty($cargo) || $cargo == '' || $cargo == null) {
                                    $cargo = null;
                                } else {
                                    $cargo = $cargo;
                                }
                                array_push($cargosarray, $cargo);
                            }
                        }
                        if (!empty($justificaciones)) {
                            foreach ($justificaciones as $justificacion) {
                                if (empty($justificacion) || $justificacion == '' || $justificacion == null) {
                                    $justificacion = 'NA';
                                } else {
                                    $justificacion = $justificacion;
                                }
                                array_push($justificacionesarray, $justificacion);
                            }
                        }


                        for ($i = 0; $i < count($lineassarray); $i++) {
                            if (empty($cargosarray[$i]) || $cargosarray[$i] == null || $cargosarray[$i] == '') {
                                
                            } else {
                                $primeralinea = new Firstline();
                                $primeralinea->idProgram = $program->id;
                                $primeralinea->numero = $lineassarray[$i];
                                $primeralinea->nombre = $cargosarray[$i];
                                $primeralinea->justificacion = $justificacionesarray[$i];

                                $primeralinea->save();
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

    public function addOrdenes(Request $request) {
        if (Auth::check()) {
            try {
                $numeros = $request->OrdenDiaNumero;
                $intervenciones = $request->OrdenDiaIntervencion;
                $cargos = $request->OrdenDiaCargo;
                $duraciones = $request->OrdenDiaDuracion;
                $numerosarray = array();
                $intervencionesarray = array();
                $cargosarray = array();
                $duracionesarray = array();
                $programs = Program::where('idEvent', '=', $request->idEventPrograms)->get();
                if (count($programs) > 0) {
                    $program = $programs[0];
                    if (!empty($numeros)) {
                        foreach ($numeros as $numero) {
                            if (empty($numero) || $numero == '' || $numero == null) {
                                $numero = null;
                            }
                            array_push($numerosarray, $numero);
                        }
                    }
                    if (!empty($intervenciones)) {
                        foreach ($intervenciones as $intervencion) {
                            if (empty($intervencion) || $intervencion == '' || $intervencion == null) {
                                $intervencion = NULL;
                            }
                            array_push($intervencionesarray, $intervencion);
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

                    if (!empty($duraciones)) {
                        foreach ($duraciones as $duracion) {
                            if (empty($duracion) || $duracion == '' || $duracion == null) {
                                $duracion = null;
                            }
                            array_push($duracionesarray, $duracion);
                        }
                    }

                    for ($i = 0; $i < count($numerosarray); $i++) {
                        if (empty($intervencionesarray[$i]) || $intervencionesarray[$i] == null || $intervencionesarray[$i] == '') {
                            
                        } else {
                            $orden = new Dayorder();
                            $orden->idProgram = $program->id;
                            $orden->np = $numerosarray[$i];
                            $orden->intervencion = $intervencionesarray[$i];
                            $orden->cargo = $cargosarray[$i];
                            $orden->minutos = $duracionesarray[$i];
                            $orden->save();
                        }
                    }
                } else {
                    
                }
            } catch (Exception $ex) {
                $message = $ex - getMessage();
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

}
