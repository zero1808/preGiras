<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Municipality;
use App\Profile;
use App\Event;
use App\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use App\Seccional;
use Illuminate\Support\Facades\Crypt;
use Input;
use Validator;
use Redirect;
use Session;
use Illuminate\Support\Facades\Hash;
use Carbon;
use App\Http\Controllers\Formato;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Ficha;
use App\Http\Controllers\Ficha1;
use App\Http\Controllers\Ficha2;
class EventController extends Controller {

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
        if (Auth::check()) {
            $municipios = Municipality::all();
            $profiles = User::where('level', '=', '2')->get();
            return view('events/new')->with('municipios', $municipios)->with('profiles', $profiles);
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
                if (!isset($request->idEvent)) {
                    $event = new Event();
                    $fi = $request->fi . " " . $request->hi;
                    $ff = $request->fi . " " . $request->hf;
                    $aux = new DateTime($fi);
                    $aux_final = new DateTime($ff);
                    $fecha_inicio = $aux->format('Y-m-d H:i:s');
                    $fecha_final = $aux_final->format('Y-m-d H:i:s');
                    $event->nombre = $request->nombre;
                    $event->f_inicio = $fecha_inicio;
                    $event->f_final = $fecha_final;
                    $event->hora_arribo = $request->h_arribo;
                    $event->hora_convocatoria = $request->h_convocatoria;
                    $event->calle_numero = $request->calle_numero;
                    $event->colonia = $request->colonia;
                    $event->cp = $request->cp;
                    $event->idMunicipio = $request->municipio;
                    $event->seccion_impactada = $request->seccion_impactada;
                    $event->distrito_impactado = $request->distrito;
                    $event->responsable_politico = $request->responsable_politico;
                    $event->cargo_responsable_politico = $request->cargo_responsable_politico;
                    $foto_responsable_politico = $request->file('foto_responsable_politico');
                    if (!isset($foto_responsable_politico) || empty($foto_responsable_politico)) {
                        
                    } else {
                        $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                        $validator = Validator::make(array('file' => $foto_responsable_politico), $rules);
                        if ($validator->passes()) {
                            $destinationPath = 'uploads/fotos_responsable/';
                            $caracteres = "0123456789abcdefABCDEF";
                            $longitud = 25;

                            $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                            $extension = explode(".", $foto_responsable_politico->getClientOriginalName());
                            $filename = $cadena_aux . "." . $extension[1];
                            $upload_success = $foto_responsable_politico->move($destinationPath, $filename);
                            if ($upload_success) {
                                $event->foto_responsable_politico = $filename;
                            }
                        }
                    }
                    $event->telefono_responsable_politico = $request->telefono_responsable_politico;
                    $event->email_responsable_politico = $request->email_responsable_politico;
                    $event->responsable_operativo = $request->responsable_operativo;
                    $event->cargo_responsable_operativo = $request->cargo_responsable_operativo;
                    $foto_responsable_operativo = $request->file('foto_responsable_operativo');
                    if (!isset($foto_responsable_operativo) || empty($foto_responsable_operativo)) {
                        
                    } else {
                        $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                        $validator = Validator::make(array('file' => $foto_responsable_operativo), $rules);
                        if ($validator->passes()) {
                            $destinationPath = 'uploads/fotos_responsable/';
                            $caracteres = "0123456789abcdefABCDEF";
                            $longitud = 20;

                            $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                            $extension = explode(".", $foto_responsable_operativo->getClientOriginalName());
                            $filename = $cadena_aux . "." . $extension[1];
                            $upload_success = $foto_responsable_operativo->move($destinationPath, $filename);
                            if ($upload_success) {
                                $event->foto_responsable_operativo = $filename;
                            }
                        }
                    }
                    $event->telefono_responsable_operativo = $request->telefono_responsable_operativo;
                    $event->email_responsable_operativo = $request->email_responsable_operativo;
                    $event->objetivo = $request->objetivo;

                    $event->idResponsable = $request->responsable;
                    $event->status = 1;
                    $event->lat = $request->lat;
                    $event->lng = $request->lng;
                    $event->save();

                    return $this->onSuccessCreate();
                } else {
                    $evento = Event::find($request->idEvent);
                    if (count($evento) > 0) {
                        $this->update($request, $request->idEvent);
                        return redirect('/home');
                    }
                }
            } catch (Exception $e) {
                // do task when error
                $municipios = Municipality::all();
                $profiles = User::where('level', '=', '2')->get();
                return view('events/new')->with('municipios', $municipios)->with('profiles', $profiles)->with('messages', $e->getMessage());
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
        if (Auth::check()) {
            try {
                $evento = Event::find($id);

                if (count($evento) != 0) {

                    if (!$evento->information) {
                        $information = false;
                        $information_object = null;
                        $comitereception = false;
                        $comitereception_object = null;
                    } else {
                        $information = true;
                        $information_object = $evento->information;
                        if (!$evento->information->comitereceptions) {
                            $comitereception = false;
                            $comitereception_object = null;
                        } else {
                            $comitereception = true;
                            $comitereception_object = $evento->information->comitereceptions;
                        }
                    }
                    if (!$evento->place) {
                        $place = false;
                        $place_object = null;
                        $picplace = false;
                        $picplace_object = null;
                        $bossplace = false;
                        $bossplace_object = null;
                    } else {
                        $place = true;
                        $place_object = $evento->place;
                        if (!$evento->place->picplaces) {
                            $picplace = false;
                            $picplace_object = null;
                        } else {
                            $picplace = true;
                            $picplace_object = $evento->place->picplaces;
                        }

                        if (!$evento->place->bossplaces) {
                            $bossplace = false;
                            $bossplace_object = null;
                        } else {
                            $bossplace = true;
                            $bossplace_object = $evento->place->bossplaces;
                        }
                    }

                    if (!$evento->program) {
                        $program = false;
                        $program_object = null;
                        $presidium = false;
                        $presidium_object = null;
                        $asistentesespeciales = false;
                        $asistentesespeciales_object = null;
                        $primeraslineas = false;
                        $primeraslineas_object = null;
                        $ordenesdia = false;
                        $ordenesdia_object = null;
                    } else {
                        $program = true;
                        $program_object = $evento->program;
                        if (!$evento->program->presidiummembers) {
                            $presidium = false;
                            $presidium_object = null;
                        } else {
                            $presidium = true;
                            $presidium_object = $evento->program->presidiummembers;
                        }
                        if (!$evento->program->especialassistans) {
                            $asistentesespeciales = false;
                            $asistentesespeciales_object = null;
                        } else {
                            $asistentesespeciales = true;
                            $asistentesespeciales_object = $evento->program->especialassistans;
                        }

                        if (!$evento->program->firstlines) {
                            $primeraslineas = false;
                            $primeraslineas_object = null;
                        } else {
                            $primeraslineas = true;
                            $primeraslineas_object = $evento->program->firstlines;
                        }
                        if (!$evento->program->dayorders) {
                            $ordenesdia = false;
                            $ordenesdia_object = null;
                        } else {
                            $ordenesdia = true;
                            $ordenesdia_object = $evento->program->dayorders;
                        }
                    }

                    if (!$evento->logisticrequiriment) {
                        $logistic = false;
                        $logistic_object = null;
                        $materialresources = false;
                        $materialresources_object = null;
                        $imageresources = false;
                        $imageresources_object = null;
                        $securitysupplies = false;
                        $securitysupplies_object = null;
                    } else {
                        $logistic = true;
                        $logistic_object = $evento->logisticrequiriment;
                        if (!$evento->logisticrequiriment->materialresources) {
                            $materialresources = false;
                            $materialresources_object = null;
                        } else {
                            $materialresources = true;
                            $materialresources_object = $evento->logisticrequiriment->materialresources;
                        }
                        if (!$evento->logisticrequiriment->imageresources) {
                            $imageresources = false;
                            $imageresources_object = null;
                        } else {
                            $imageresources = true;
                            $imageresources_object = $evento->logisticrequiriment->imageresources;
                        }
                        if (!$evento->logisticrequiriment->securitysupplies) {
                            $securitysupplies = false;
                            $securitysupplies_object = null;
                        } else {
                            $securitysupplies = true;
                            $securitysupplies_object = $evento->logisticrequiriment->securitysupplies;
                        }
                    }
                    return response()->json([
                                'evento' => $evento,
                                'status' => true,
                                'information' => $information,
                                'place' => $place,
                                'information_object' => $information_object,
                                'place_object' => $place_object,
                                'picplace' => $picplace,
                                'picplace_object' => $picplace_object,
                                'bossplace' => $picplace,
                                'bossplace_object' => $bossplace_object,
                                'comitereception' => $comitereception,
                                'comitereception_object' => $comitereception_object,
                                'program' => $program,
                                'program_object' => $program_object,
                                'presidium' => $presidium,
                                'presidium_object' => $presidium_object,
                                'asistentesespeciales' => $asistentesespeciales,
                                'asistentesespeciales_object' => $asistentesespeciales_object,
                                'primeraslineas' => $primeraslineas,
                                'primeraslineas_object' => $primeraslineas_object,
                                'ordenesdia' => $ordenesdia,
                                'ordenesdia_object' => $ordenesdia_object,
                                'logistic' => $logistic,
                                'logistic_object' => $logistic_object,
                                'materialresources' => $materialresources,
                                'materialresources_object' => $materialresources_object,
                                'imageresources' => $imageresources,
                                'imageresources_object' => $imageresources_object,
                                'securitysupplies' => $securitysupplies,
                                'securitysupplies_object' => $securitysupplies_object
                    ]);
                } else {
                    return response()->json([
                                'evento' => "No se encontro el evento",
                                'status' => false
                    ]);
                }
            } catch (Exception $e) {
                return response()->json([
                            'evento' => $e->getMessage(),
                            'status' => true
                ]);
            }
        }
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
                $event = Event::find($id);
                if (count($event) > 0) {
                    $fi = $request->fi . " " . $request->hi;
                    $ff = $request->fi . " " . $request->hf;
                    $aux = new DateTime($fi);
                    $aux_final = new DateTime($ff);

                    $fecha_inicio = $aux->format('Y-m-d H:i:s');
                    $fecha_final = $aux_final->format('Y-m-d H:i:s');
                    $event->nombre = $request->nombre;
                    $event->f_inicio = $fecha_inicio;
                    $event->f_final = $fecha_final;
                    $event->hora_arribo = $request->h_arribo;
                    $event->hora_convocatoria = $request->h_convocatoria;
                    $event->calle_numero = $request->calle_numero;
                    $event->colonia = $request->colonia;
                    $event->cp = $request->cp;
                    $event->idMunicipio = $request->municipio;
                    $event->seccion_impactada = $request->seccion_impactada;
                    $event->distrito_impactado = $request->distrito;
                    $event->responsable_politico = $request->responsable_politico;
                    $event->cargo_responsable_politico = $request->cargo_responsable_politico;
                    $foto_responsable_politico = $request->file('foto_responsable_politico');
                    if (!isset($foto_responsable_politico) || empty($foto_responsable_politico)) {
                        
                    } else {
                        $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                        $validator = Validator::make(array('file' => $foto_responsable_politico), $rules);
                        if ($validator->passes()) {
                            $destinationPath = 'uploads/fotos_responsable/';
                            $caracteres = "0123456789abcdefABCDEF";
                            $longitud = 25;

                            $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                            $extension = explode(".", $foto_responsable_politico->getClientOriginalName());
                            $filename = $cadena_aux . "." . $extension[1];
                            $upload_success = $foto_responsable_politico->move($destinationPath, $filename);
                            if ($upload_success) {
                                $event->foto_responsable_politico = $filename;
                            }
                        }
                    }
                    $event->telefono_responsable_politico = $request->telefono_responsable_politico;
                    $event->email_responsable_politico = $request->email_responsable_politico;
                    $event->responsable_operativo = $request->responsable_operativo;
                    $event->cargo_responsable_operativo = $request->cargo_responsable_operativo;
                    $foto_responsable_operativo = $request->file('foto_responsable_operativo');
                    if (!isset($foto_responsable_operativo) || empty($foto_responsable_operativo)) {
                        
                    } else {
                        $rules = array('file' => 'required'); //'required|mimes:png,gif,jpeg,txt,pdf,doc'
                        $validator = Validator::make(array('file' => $foto_responsable_operativo), $rules);
                        if ($validator->passes()) {
                            $destinationPath = 'uploads/fotos_responsable/';
                            $caracteres = "0123456789abcdefABCDEF";
                            $longitud = 25;

                            $cadena_aux = $this->rand_code($caracteres, $longitud) . "" . $this->rand_code($caracteres, $longitud);
                            $extension = explode(".", $foto_responsable_operativo->getClientOriginalName());
                            $filename = $cadena_aux . "." . $extension[1];
                            $upload_success = $foto_responsable_operativo->move($destinationPath, $filename);
                            if ($upload_success) {
                                $event->foto_responsable_operativo = $filename;
                            }
                        }
                    }
                    $event->telefono_responsable_operativo = $request->telefono_responsable_operativo;
                    $event->email_responsable_operativo = $request->email_responsable_operativo;
                    $event->objetivo = $request->objetivo;
                    $event->idResponsable = $request->responsable;
                    $event->status = 1;
                    $event->lat = $request->lat;
                    $event->lng = $request->lng;
                    $saved = $event->save();
                    return $saved;
                }
            } catch (Exception $ex) {
                $message = 'Error: ' . $ex->getMessage();
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
        if (Auth::check()) {
            try {
                $evento = Event::find($id);
                if (count($evento) != 0) {
                    $evento->delete();
                    return redirect('/home');
                } else {
                    
                }
            } catch (Exception $e) {
                
            }
        }
    }
public function borrarEvento(Request $request) {
//
        if (Auth::check()) {
            try {
                $id = $request->idEventoBorrar;    
                $evento = Event::find($id);
                if (count($evento) != 0) {
                    $evento->delete();
                    return redirect('/home');
                } else {
                    
                }
            } catch (Exception $e) {
                
            }
        }
    }
    public function onSuccessCreate() {
        if (Auth::check()) {
            $municipios = Municipality::all();
            $profiles = User::where('level', '=', '2')->get();
            return view('events/new')->with('municipios', $municipios)->with('profiles', $profiles)->with('messages', 'Evento creado con exito!');
        }
    }

    public function editBase(Request $request) {
        $saved = $this->update($request, $request->idEvent);
        if($saved){
            return response()->json([
                'status'=>true
            ]);
        }else{
         return response()->json([
                'status'=>false
            ]);   
        }
    }

    public function eventosCalendar() {
        $eventos = Event::where('status', '=', '1')->select('id', 'nombre as title', 'f_inicio as start', 'f_final as end')->get();
        if (count($eventos) > 0) {
            return response()->json([
                        'status' => true,
                        'eventos' => $eventos
            ]);
        } else {
            return respose()->json([
                        'status' => false,
                        'eventos' => null
            ]);
        }
    }

    public function calendario() {
        if (Auth::check()) {
            $municipios = Municipality::all();
            $profiles = User::where('level', '=', '2')->get();
            $seccionales = Seccional::all();
            return view('events/calendar')->with('municipios', $municipios)->with('profiles', $profiles)->with('seccionales', $seccionales);
        } else {
            return view('auth/login');
        }
    }
    public function fullagenda() {
        if (Auth::check()) {
     
            return view('events/fullagenda');
        } else {
            return view('auth/login');
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

    public function generatePdf($id) {
        $evento = Event::find($id);
        $pdf = new Formato('L', 'mm', 'Letter');
        $pdf->AliasNbPages(); //necesario para contar el total de paginas, si no no sirve
        #Establecemos los márgenes izquierda, arriba y derecha: 
        $pdf->SetMargins(1.5, 0, 3);
        #Establecemos los márgenes izquierda, arriba y derecha: 
        //$pdf->SetMargins(0, 0 ,0);
        $contador=$evento->contador_pdf;
        $evento->contador_pdf = $contador + 1;
        $evento->save();
        $pdf->AddPage();

        $pdf->mainTable($evento);

        $pdf->Ln();
        $pdf->Output();
    }

    public function generarFicha($id) {
        $evento = Event::find($id);
        $pdf = new Ficha('L', 'mm', 'Letter');
        $pdf->SetMargins(10, 10, 149.5);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();
    $fotoresp='http://1.bp.blogspot.com/_QZOtqtmNfCc/ShyqMoTsYEI/AAAAAAAAAA0/PSFRDkIldjg/S220/TAMA%C3%91O+INFANTIL.jpg';

        $imagenlogo = 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/31/Mexican_Green_Party.svg/160px-Mexican_Green_Party.svg.png';
        $pdf->Contenido($imagenlogo,$evento,$fotoresp);

        $pdf->Ln();
        $pdf->Output();
    }

    public function generarFicha1() {
        $pdf = new Ficha1('L', 'mm', 'Letter');
        $pdf->SetMargins(10, 10, 149.5);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $imagenlogo = 'http://smsem.org.mx/pregiras/img/tipo_herradura.jpg';
        $pdf->Contenido($imagenlogo);

        $pdf->Ln();
        $pdf->Output();
    }

    public function generarFicha2() {
        $pdf = new Ficha2('L', 'mm', 'Letter');
        $pdf->SetMargins(10, 10, 149.5);
        $pdf->SetAutoPageBreak(false);
        $pdf->AddPage();

        $fotoresp = 'http://1.bp.blogspot.com/_QZOtqtmNfCc/ShyqMoTsYEI/AAAAAAAAAA0/PSFRDkIldjg/S220/TAMA%C3%91O+INFANTIL.jpg';
        $pdf->Contenido($fotoresp);

        $pdf->Ln();
        $pdf->Output();
    }

}
