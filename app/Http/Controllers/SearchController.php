<?php

namespace App\Http\Controllers;

use App\Order;
use App\Event;
use App\Seccional;
use Illuminate\Http\Request;
use App\Http\Controllers\Formato;
class SearchController extends Controller {
  public function __construct() {
        $this->middleware('auth');
    }
    //
    public function findEventsByTeam($id) {
        if (is_numeric($id) && !empty($id)) {
            $events = Event::all();
            if (count($events) > 0) {
                
                $arr["eventos"] = array();
                foreach ($events as $event) {
                   
                    array_push($arr["eventos"], $event);
                }
                return response()->json([
                            'eventos' => $arr["eventos"],
                            'status' => true
                ]);
            } else {
                return response()->json([
                            'eventos' => null,
                            'status' => false
                ]);
            }
        }
    }
    public function createPDF($id){
        $evento = Event::find($id);
        $pdf = new Formato();
        $pdf->AddPage('L','A4');
        $pdf->mainTable($evento);
        $fact_pdf = "uploads/" . $evento->nombre. ".pdf";
        $pdf->Output($fact_pdf, 'F');
    }
    public function findSeccionalByMunicipio($id) {
        if (is_numeric($id)) {
            $casillas = Seccional::where('municipio', '=', $id)->orderBy('seccion','desc')->get();
            if (count($casillas) > 0) {

                $arr["seccionales"] = array();
                foreach ($casillas as $casilla) {
                    array_push($arr["seccionales"], $casilla->seccion);
                }
                return response()->json([
                            'seccionales' => $arr["seccionales"],
                            'status' => true
                ]);
            } else {
                return response()->json([
                            'seccionales' => null,
                            'status' => false
                ]);
            }
        }
    }
    public function borrarMaterial($id) {
        if (is_numeric($id)) {
            $material = \App\Materialresource::find($id);
            if (count($material) > 0) {

              $material->delete();
              return redirect('/home');
            }
            
        }
    }
    public function borrarImage($id) {
        if (is_numeric($id)) {
            $material = \App\Imageresource::find($id);
            if (count($material) > 0) {

              $material->delete();
              return redirect('/home');
            }
            
        }
    }
    public function borrarSecurity($id) {
        if (is_numeric($id)) {
            $material = \App\Securitysupplie::find($id);
            if (count($material) > 0) {

              $material->delete();
              return redirect('/home');
            }
            
        }
    }
}
 