<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Logisticrequiriment;
use App\Event;
use App\Materialresource;
use App\Securitysupplie;
use App\Imageresource;

class LogisticrequirimentController extends Controller {

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


                $evento = Event::find($request->idEventLogistic);
                if (count($evento) > 0) {
                    if (!$evento->logisticrequiriment) {
                        $requerimiento = new Logisticrequiriment();
                        $requerimiento->idEvent = $request->idEventLogistic;
                        $requerimiento->seguridad = null;
                        $requerimiento->ambulancia = null;
                        $requerimiento->bomberos = null;
                        $requerimiento->proteccion_civil = null;
                        if (isset($request->seguridad)) {
                            foreach ((array) $request->seguridad as $seguridad) {
                                if ($seguridad == 'seguridad') {
                                    $requerimiento->seguridad = 1;
                                }
                                if ($seguridad == 'ambulancia') {
                                    $requerimiento->ambulancia = 1;
                                }
                                if ($seguridad == 'bomberos') {
                                    $requerimiento->bomberos = 1;
                                }
                                if ($seguridad == 'proteccion_civil') {
                                    $requerimiento->proteccion_civil = 1;
                                }
                            }
                        }
                        $requerimiento->maestro_ceremonias = null;
                        $requerimiento->artista = null;
                        $requerimiento->edecanes = null;
                        if (isset($request->conduccion)) {
                            foreach ((array) $request->conduccion as $conduccion) {
                                if ($conduccion == 'maestro') {
                                    $requerimiento->maestro_ceremonias = 1;
                                }
                                if ($conduccion == 'artista') {
                                    $requerimiento->artista = 1;
                                }

                                if ($conduccion == 'edecanes') {
                                    $requerimiento->edecanes = 1;
                                }
                            }
                        }

                        if ($request->escenario != '0') {
                            $requerimiento->tipo_escenario = $request->escenario;
                        } else {
                            $requerimiento->tipo_escenario = $request->other_escenario;
                        }

                        $requerimiento->tipo_estrado = $request->tipo_estrado;
                        $requerimiento->hidratacion = null;
                        $requerimiento->coffeebreak = null;
                        $requerimiento->bocadillos = null;
                        $requerimiento->agua = null;
                        $requerimiento->otro_alimento = null;
                        if (isset($request->alimentos)) {
                            foreach ((array) $request->alimentos as $alimento) {
                                if ($alimento == 'HIDRATACION') {
                                    $requerimiento->hidratacion = 1;
                                }
                                if ($alimento == 'COFEE') {
                                    $requerimiento->coffeebreak = 1;
                                }

                                if ($alimento == 'BOCADILLOS') {
                                    $requerimiento->bocadillos = 1;
                                }
                                if ($alimento == 'AGUA') {
                                    $requerimiento->agua = 1;
                                }
                                if ($alimento == 'OTRO') {
                                    $requerimiento->otro_alimento = $request->otro_alimento;
                                }
                            }
                        }
                        $requerimiento->pull_cde = null;
                        $requerimiento->medios_locales = null;
                        $requerimiento->medios_nacionales = null;
                        $requerimiento->fotografo = null;
                        $requerimiento->otro_medio = null;
                        if (isset($request->cobertura)) {
                            foreach ((array) $request->cobertura as $cobertura) {
                                if ($cobertura == 'PULLCDE') {
                                    $requerimiento->pull_cde = 1;
                                }
                                if ($cobertura == 'MEDIOSLOCALES') {
                                    $requerimiento->medios_locales = 1;
                                }

                                if ($cobertura == 'MEDIOSNACIONALES') {
                                    $requerimiento->medios_nacionales = 1;
                                }
                                if ($cobertura == 'FOTOGRAFO') {
                                    $requerimiento->fotografo = 1;
                                }
                                if ($cobertura == 'OTRO') {
                                    $requerimiento->otro_medio = $request->otro_cobertura;
                                }
                            }
                        }
                        $requerimiento->fiscalizacion = $request->fiscalizacion;
                        $requerimiento->responsable_comunicacion = $request->responsable_comunicacion;
                        $requerimiento->telefono_comunicacion = $request->telefono_comunicacion;
                        $saved = $requerimiento->save();
                        $this->addMateriales($request);
                        $this->addInsumos($request);
                        $this->addImagen($request);
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
                        $saved = $this->update($request, $request->idEventLogistic);
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
        if (Auth::check()) {
            try {


                $requerimientos = Logisticrequiriment::where('idEvent', '=', $id)->get();
                if (count($requerimientos) > 0) {
                    $requerimiento = $requerimientos[0];
                    $requerimiento->seguridad = null;
                    $requerimiento->ambulancia = null;
                    $requerimiento->bomberos = null;
                    $requerimiento->proteccion_civil = null;
                    if (isset($request->seguridad)) {
                        foreach ((array) $request->seguridad as $seguridad) {
                            if ($seguridad == 'seguridad') {
                                $requerimiento->seguridad = 1;
                            }
                            if ($seguridad == 'ambulancia') {
                                $requerimiento->ambulancia = 1;
                            }
                            if ($seguridad == 'bomberos') {
                                $requerimiento->bomberos = 1;
                            }
                            if ($seguridad == 'proteccion_civil') {
                                $requerimiento->proteccion_civil = 1;
                            }
                        }
                    }
                    $requerimiento->maestro_ceremonias = null;
                    $requerimiento->artista = null;
                    $requerimiento->edecanes = null;
                    if (isset($request->conduccion)) {
                        foreach ((array) $request->conduccion as $conduccion) {
                            if ($conduccion == 'maestro') {
                                $requerimiento->maestro_ceremonias = 1;
                            }
                            if ($conduccion == 'artista') {
                                $requerimiento->artista = 1;
                            }

                            if ($conduccion == 'edecanes') {
                                $requerimiento->edecanes = 1;
                            }
                        }
                    }

                    if ($request->escenario != '0') {
                        $requerimiento->tipo_escenario = $request->escenario;
                    } else {
                        $requerimiento->tipo_escenario = $request->other_escenario;
                    }

                    $requerimiento->tipo_estrado = $request->tipo_estrado;

                    $requerimiento->hidratacion = null;
                    $requerimiento->coffeebreak = null;
                    $requerimiento->bocadillos = null;
                    $requerimiento->agua = null;
                    $requerimiento->otro_alimento = null;
                    if (isset($request->alimentos)) {
                        foreach ((array) $request->alimentos as $alimento) {
                            if ($alimento == 'HIDRATACION') {
                                $requerimiento->hidratacion = 1;
                            }
                            if ($alimento == 'COFEE') {
                                $requerimiento->coffeebreak = 1;
                            }

                            if ($alimento == 'BOCADILLOS') {
                                $requerimiento->bocadillos = 1;
                            }
                            if ($alimento == 'AGUA') {
                                $requerimiento->agua = 1;
                            }
                            if ($alimento == 'OTRO') {
                                $requerimiento->otro_alimento = $request->otro_alimento;
                            }
                        }
                    }
                    $requerimiento->pull_cde = null;
                    $requerimiento->medios_locales = null;
                    $requerimiento->medios_nacionales = null;
                    $requerimiento->fotografo = null;
                    $requerimiento->otro_medio = null;
                    if (isset($request->cobertura)) {
                        foreach ((array) $request->cobertura as $cobertura) {
                            if ($cobertura == 'PULLCDE') {
                                $requerimiento->pull_cde = 1;
                            }
                            if ($cobertura == 'MEDIOSLOCALES') {
                                $requerimiento->medios_locales = 1;
                            }

                            if ($cobertura == 'MEDIOSNACIONALES') {
                                $requerimiento->medios_nacionales = 1;
                            }
                            if ($cobertura == 'FOTOGRAFO') {
                                $requerimiento->fotografo = 1;
                            }
                            if ($cobertura == 'OTRO') {
                                $requerimiento->otro_medio = $request->otro_cobertura;
                            }
                        }
                    }
                    $requerimiento->fiscalizacion = $request->fiscalizacion;
                    $requerimiento->responsable_comunicacion = $request->responsable_comunicacion;
                    $requerimiento->telefono_comunicacion = $request->telefono_comunicacion;
                    $saved = $requerimiento->save();
                    $this->addMateriales($request);
                    $this->addInsumos($request);
                    $this->addImagen($request);
                    return $saved;
                } else {
                    
                }
            } catch (Exception $ex) {
                
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

    public function addMateriales(Request $request) {
        if (Auth::check()) {
            try {
                if (isset($request->materialesNumero) && isset($request->materialesMaterial) && isset($request->materialesObservacion)) {
                    $cantidades = $request->materialesNumero;
                    $materiales = $request->materialesMaterial;
                    $observaciones = $request->materialesObservacion;
                    $cantidadesarray = array();
                    $materialesarray = array();
                    $observacionesarray = array();
                    $requerimientos = Logisticrequiriment::where('idEvent', '=', $request->idEventLogistic)->get();
                    if (count($requerimientos) > 0) {
                        $requerimiento = $requerimientos[0];
                        if (!empty($cantidades)) {
                            foreach ($cantidades as $cantidad) {
                                if (empty($cantidad) || $cantidad == '' || $cantidad == null) {
                                    $cantidad = 0;
                                }
                                array_push($cantidadesarray, $cantidad);
                            }
                        }
                        if (!empty($materiales)) {
                            foreach ($materiales as $material) {
                                if (empty($material) || $material == '0' || $material == null) {
                                    $material = null;
                                } else {
                                    $material = $material;
                                }
                                array_push($materialesarray, $material);
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

                        for ($i = 0; $i < count($materialesarray); $i++) {
                            if (empty($materialesarray[$i]) || $materialesarray[$i] == null || $materialesarray[$i] == '') {
                                
                            } else {
                                $resource = new Materialresource();
                                $resource->idRequeriments = $requerimiento->id;
                                $resource->cantidad = $cantidadesarray[$i];
                                $resource->tipo = $materialesarray[$i];
                                $resource->observaciones = $observacionesarray[$i];
                                $resource->save();
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

    public function addInsumos(Request $request) {
        if (Auth::check()) {
            try {
                if (isset($request->insumosNumero) && isset($request->insumosInsumo) && isset($request->insumosObservaciones)) {
                    $cantidades = $request->insumosNumero;
                    $materiales = $request->insumosInsumo;
                    $observaciones = $request->insumosObservaciones;
                    $cantidadesarray = array();
                    $materialesarray = array();
                    $observacionesarray = array();
                    $requerimientos = Logisticrequiriment::where('idEvent', '=', $request->idEventLogistic)->get();
                    if (count($requerimientos) > 0) {
                        $requerimiento = $requerimientos[0];
                        if (!empty($cantidades)) {
                            foreach ($cantidades as $cantidad) {
                                if (empty($cantidad) || $cantidad == '' || $cantidad == null) {
                                    $cantidad = 0;
                                }
                                array_push($cantidadesarray, $cantidad);
                            }
                        }
                        if (!empty($materiales)) {
                            foreach ($materiales as $material) {
                                if (empty($material) || $material == '0' || $material == null) {
                                    $material = null;
                                } else {
                                    $material = $material;
                                }
                                array_push($materialesarray, $material);
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

                        for ($i = 0; $i < count($materialesarray); $i++) {
                            if (empty($materialesarray[$i]) || $materialesarray[$i] == null || $materialesarray[$i] == '' || $cantidadesarray[$i] == null || $cantidadesarray[$i] == '') {
                                
                            } else {
                                $resource = new Securitysupplie();
                                $resource->idRequeriments = $requerimiento->id;
                                $resource->cantidad = $cantidadesarray[$i];
                                $resource->tipo = $materialesarray[$i];
                                $resource->observaciones = $observacionesarray[$i];
                                $resource->save();
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

    public function addImagen(Request $request) {
        if (Auth::check()) {
            try {
                if (isset($request->imagenNumero) && isset($request->imagenImagen) && isset($request->imagenObservaciones)) {
                    $cantidades = $request->imagenNumero;
                    $materiales = $request->imagenImagen;
                    $observaciones = $request->imagenObservaciones;
                    $cantidadesarray = array();
                    $materialesarray = array();
                    $observacionesarray = array();
                    $requerimientos = Logisticrequiriment::where('idEvent', '=', $request->idEventLogistic)->get();
                    if (count($requerimientos) > 0) {
                        $requerimiento = $requerimientos[0];
                        if (!empty($cantidades)) {
                            foreach ($cantidades as $cantidad) {
                                if (empty($cantidad) || $cantidad == '' || $cantidad == null) {
                                    $cantidad = 0;
                                }
                                array_push($cantidadesarray, $cantidad);
                            }
                        }
                        if (!empty($materiales)) {
                            foreach ($materiales as $material) {
                                if (empty($material) || $material == '0' || $material == null) {
                                    $material = null;
                                } else {
                                    $material = $material;
                                }
                                array_push($materialesarray, $material);
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

                        for ($i = 0; $i < count($materialesarray); $i++) {
                            if (empty($materialesarray[$i]) || $materialesarray[$i] == null || $materialesarray[$i] == '' || $cantidadesarray[$i] == null || $cantidadesarray[$i] == '') {
                                
                            } else {
                                $resource = new Imageresource();
                                $resource->idRequeriments = $requerimiento->id;
                                $resource->cantidad = $cantidadesarray[$i];
                                $resource->tipo = $materialesarray[$i];
                                $resource->observaciones = $observacionesarray[$i];
                                $resource->save();
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
