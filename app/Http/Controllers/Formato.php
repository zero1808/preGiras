<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use FPDF;

require('html2pdf.php');

use DateTime;

class Formato extends \fpdf\FPDF {

    function Header() {
        #Establecemos los márgenes izquierda, arriba y derecha: 
        $this->AddFont('Gotham-M', 'B', 'gotham-medium.php');
        $this->SetMargins(0, 1, 0);
        $this->setY(0);
        $this->SetTitle(utf8_decode('FORMATO BASICO DE INFORMACIÓN'));
        $this->SetFont('Gotham-M', 'B', 16);
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(58, 181, 74);
        $this->Ln(0);
        $this->Cell(0, 2.5, utf8_decode(''), 0, 0, 'C', 1);
        $this->Ln();
        $this->SetFillColor(153, 202, 59);
        $this->Cell(0, 17, utf8_decode('FORMATO DE INFORMACIÓN BÁSICA'), 0, 0, 'C', 1);
        //EL CIRCULO CON EL NUMERO DE PAGINA
        $this->SetFillColor(85, 86, 85);
        $this->SemiCircle(279, 11, 8.5, 'F');
        //$this->Circle(50,25,5, -60, -180, 'D');
        $this->SetTextColor(255);
        $this->SetFont('Arial', 'B', 24);
        $this->Cell(0, 17, $this->PageNo(), 0, 0, 'R');

        $this->Ln(20);
        #Establecemos los márgenes izquierda, arriba y derecha: 
        $this->SetMargins(1.5, 0, 3);
    }

    function Footer() {
        $this->SetY(-10);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(0);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    function mainTable( $evento) {
        #Establecemos los márgenes izquierda, arriba y derecha: 
        $this->SetMargins(1.5, 0, 3);

        //indicamos la fuente
        $this->AddFont('Gotham-B', '', 'gotham-book.php');
        $this->AddFont('Gotham-B', 'B', 'gotham-book.php');
        $this->AddFont('Gotham-M', '', 'gotham-medium.php');
        $this->AddFont('Helvetica', '', 'helvetica.php');

        $bordeX = 2;
        $cadena = "";
        $bandera_participacion = false;
        $bandera_escenario = false;
        $nombre_evento = (isset($evento->nombre)) ? $evento->nombre : "";
        if (isset($evento->f_inicio)) {
            $fecha_evento_aux = explode(" ", $evento->f_inicio);
            $fecha_evento = $fecha_evento_aux[0];
        } else {
            $fecha_evento = '';
        }
        $hora_arribo = (isset($evento->hora_arribo)) ? $evento->hora_arribo : "";
        $hora_convocatoria = (isset($evento->hora_convocatoria)) ? $evento->hora_convocatoria : "";
        if (isset($evento->f_inicio) && isset($evento->f_final)) {
            $ent = strtotime($evento->f_inicio);
            $sal = strtotime($evento->f_final);
            $aux_fecha_ent = $sal - $ent;
            $duracion_evento = round(abs($aux_fecha_ent) / 60, 2);
        } else {
            $duracion_evento = '';
        }

        $domicilio_evento = $evento->calle_numero . ", " . $evento->colonia . ", C.P: " . $evento->cp;
        $municipio_evento = (isset($evento->idMunicipio)) ? $evento->municipality->name : "";
        $distrito_local = (isset($evento->distrito_impactado)) ? $evento->distrito_impactado : "";
        $seccional = (isset($evento->seccion_impactada)) ? $evento->seccion_impactada : "";
        $objetivo_evento = (isset($evento->objetivo)) ? $evento->objetivo : "";
        $responsable_politico = (isset($evento->responsable_politico)) ? $evento->responsable_politico : "";
        $tel_responsable_politico = (isset($evento->telefono_responsable_politico) || isset($evento->email_responsable_politico)) ? $evento->telefono_responsable_politico . "\n" . $evento->email_responsable_politico : "";
        $responsable_operativo = (isset($evento->responsable_operativo)) ? $evento->responsable_operativo : "";
        $tel_responsable_operativo = (isset($evento->telefono_responsable_operativo) || isset($evento->email_responsable_operativo)) ? $evento->telefono_responsable_operativo . "\n" . $evento->email_responsable_operativo : "";
        if (isset($evento->information)) {
            if (isset($evento->information->participacion) && ($evento->information->participacion != 'MASIVA' && $evento->information->participacion != 'REUNION_PRIVADA' && $evento->information->participacion != 'CONFERENCIA_DE_PRENSA' && $evento->information->participacion != 'ENCUENTRO_CON_MILITANTES' && $evento->information->participacion != 'ENCUENTRO_SECTORIAL' && $evento->information->participacion != 'ENCUENTRO_CON_SOCIEDAD_CIVIL')) {

                $otro_par_candidato = (isset($evento->information->participacion)) ? str_replace("_", " ", $evento->information->participacion) : "";
                $bandera_participacion = true;
            } else {
                $otro_par_candidato = '                                                                         ';
            }
            $asistentes_aproximados = (isset($evento->information->asistentes)) ? $evento->information->asistentes : "";
            $sector = (isset($evento->information->sector)) ? $evento->information->sector : "";
            $tema = (isset($evento->information->tema)) ? $evento->information->tema : "";
        } else {
            $otro_par_candidato = "";
            $asistentes_aproximados = "";
            $sector = "";
            $tema = "";
        }
        if (isset($evento->logisticrequiriment)) {
            if (isset($evento->logisticrequiriment->tipo_escenario) && ($evento->logisticrequiriment->tipo_escenario != 'AUDITORIO' && $evento->logisticrequiriment->tipo_escenario != 'CIRCULAR' && $evento->logisticrequiriment->tipo_escenario != 'MEDIALUNA' && $evento->logisticrequiriment->tipo_escenario != 'MESARUSA' && $evento->logisticrequiriment->tipo_escenario != 'HERRADURA')) {

                $otro_req_logico = (isset($evento->logisticrequiriment->tipo_escenario)) ? $evento->logisticrequiriment->tipo_escenario : "";
                $bandera_escenario = true;
            } else {
                $otro_req_logico = '                                                                         ';
            }
            $responsable_comunicacion = (isset($evento->logisticrequiriment->responsable_comunicacion)) ? $evento->logisticrequiriment->responsable_comunicacion : "";
            $tel_responsable_comunicacion = (isset($evento->logisticrequiriment->telefono_comunicacion)) ? $evento->logisticrequiriment->telefono_comunicacion . "\n     " : "\n         ";
            $otro_resp_comunicacion = (isset($evento->logisticrequiriment->otro_medio)) ? "\n" . $evento->logisticrequiriment->otro_medio : "\n         ";

            $presidium_orden = "1";
            $presidium_nombre = "Cesar Gibran Cadena Espinosa";
            $presidium_cargo = "Dirigente de Redes y Enlaces Comite Municipal del PRI Metepec";

            $programa_np = "1";
            $programa_intervencion = "Lorem ipsum es el texto de prueba en archivos de texto";
            $programa_cargo = "Dirigente de Redes y Enlaces Comite Municipal del PRI Metepec";
            $programa_duracion = "90";

            $p_susceptibles_orden = "1";
            $p_susceptibles_nombre = "Cesar Gibran Cadena Espinosa";
            $p_susceptibles_justificacion = "Lorem ipsum es el texto de prueba en archivos de texto";

            $invitados_orden = "1";
            $invitados_nombre = "Cesar Gibran Cadena Espinosa";
            $invitados_cargo = "Dirigente de Redes y Enlaces Comite Municipal del PRI Metepec";
        } else {
            $otro_req_logico = '';
            $responsable_comunicacion = '';
            $tel_responsable_comunicacion = '';
            $otro_resp_comunicacion = '';
            $presidium_orden = "1";
            $presidium_nombre = "Cesar Gibran Cadena Espinosa";
            $presidium_cargo = "Dirigente de Redes y Enlaces Comite Municipal del PRI Metepec";

            $programa_np = "1";
            $programa_intervencion = "Lorem ipsum es el texto de prueba en archivos de texto";
            $programa_cargo = "Dirigente de Redes y Enlaces Comite Municipal del PRI Metepec";
            $programa_duracion = "90";

            $p_susceptibles_orden = "1";
            $p_susceptibles_nombre = "Cesar Gibran Cadena Espinosa";
            $p_susceptibles_justificacion = "Lorem ipsum es el texto de prueba en archivos de texto";

            $invitados_orden = "1";
            $invitados_nombre = "Cesar Gibran Cadena Espinosa";
            $invitados_cargo = "Dirigente de Redes y Enlaces Comite Municipal del PRI Metepec";
        }

        if (isset($evento->place)) {
            $descripcion_fisica = (isset($evento->place->descripcion)) ? $evento->place->descripcion : "";
            $accesos = (isset($evento->place->acceso_lugar)) ? str_replace("_", " ", $evento->place->acceso_lugar) . "\n                     " : "                                      ";
            $riesgos = (isset($evento->place->riesgos)) ? $evento->place->riesgos : "";
            $problematica_politica = (isset($evento->place->problematica)) ? $evento->place->problematica : "";
        } else {
            $descripcion_fisica = "";
            $accesos = "";
            $riesgos = "";
            $problematica_politica = "";
        }
        $fecha_pregira = "03/04/2017";
        $hora_pregira = "12:55";
        $entrega_formato = "03/04/2017";
        $version = "12-12";

        if (isset($evento->program)) {
            if (isset($evento->program->presidiummembers)) {
                $numero_de_presidiums = count($evento->program->presidiummembers);
            } else {
                $numero_de_presidiums = 10;
            }
        } else {
            $numero_de_presidiums = 10;
        }


        $this->SetFont('Gotham-B', '', 13);
        $this->setXY($bordeX, $this->getY());
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(69, 66, 77); //color casi negro para las letras
        $this->Cell(55, 5, utf8_decode("DATOS GENERALES"), 0, 0, 'C', 0);


        $this->Ln(7);
        // $this->setX($bordeX);

        $this->SetFillColor(73, 168, 63);
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->SetLineWidth(0);


        $this->Cell(58, 10, utf8_decode('Nombre del evento:'), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);

        $this->MultiCell(0, 5, utf8_decode($nombre_evento), 0, 'L', true);
        $this->Ln();
        $this->Ln(1.5);
        //  $y2= $this->getY();
        //TITULO SEGUNDA COLUMNA  fecha y hora
        // $this->setX($bordeX);
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(25, 10, "Fecha:", 1, 0, 'C', 0);
        $this->Cell(0.4, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(25, 10, utf8_decode($fecha_evento), 0, 0, 'C', 1);

        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 0, '', 0); //cell without borders horizontal
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(65, 10, "Hora de arribo del C. Candidato:", 1, 0, 'C', 0);
        $this->Cell(0.4, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(25, 10, utf8_decode($hora_arribo), 0, 0, 'C', 1);


        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 0, '', 0); //cell without borders horizontal
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(45, 10, "Hora de convocatoria:", 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(25, 10, utf8_decode($hora_convocatoria), 0, 0, 'C', 1);

        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 0, '', 0); //cell without borders horizontal
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $y = $this->GetY();
        $x = $this->GetX();

        $this->MultiCell(35, 5, utf8_decode("Duración: Maximo 90min"), 1, 'C', 0);

        $this->SetXY($x + 35, $y);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode($duracion_evento), 0, 0, 'C', 1);

        $this->Ln();
        $this->Ln(1.5);
        // $this->Ln(7); 

        $y = $this->getY();
        // $this->setX($bordeX);
        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(25, 10, utf8_decode("Domicilio:"), 1, 0, 'C', 0);
        $this->Cell(0.4, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->MultiCell(75, 5, utf8_decode($domicilio_evento), 0, 'C', 1);
        $y3 = $this->getY();

        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->setXY(103, $y);
        $this->SetDrawColor(0, 0, 0); //color negro del borde
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(25, 10, utf8_decode("Municipio:"), 1, 0, 'C', 0);
        $this->Cell(0.4, 0, '', 0); //cell without borders horizontal
        $x = $this->GetX();

        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->MultiCell(50, 5, utf8_decode($municipio_evento), 0, 'C', 1);
        $y2 = $this->getY();

        $this->SetXY($x + 50, $y);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 0, '', 0); //cell without borders horizontal
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(30, 10, "Distrito local:", 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(20, 10, utf8_decode($distrito_local), 0, 0, 'C', 1);

        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 0, '', 0); //cell without borders horizontal
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(25, 10, "Seccional:", 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode($seccional), 0, 0, 'C', 1);

        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 0, '', 0); //cell without borders horizontal
        //TITULO   COLUMNA  objetivo 
        if ($y2 >= $y3) {
            $this->setY($y2);
            $this->Ln(5);
        } else {
            $this->setY($y3);
            
        }
        $this->Ln();
        $this->Ln(1.5);


        //CONFIGURACION DE COLOR GRIS CON BLANCO
        //$this->setX($bordeX);
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(40, 10, utf8_decode("Tipo de evento:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode("ENCUENTRO                    DIÁLOGO                     VISITA O RECORRIDO                      DEBATE                      FORO"), 0, 0, 'C', 1);
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro

        /* CUADROS DE ENCUENTRO */
        //$this->Rect(80, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
        $this->Rect(80, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
        $this->Text(81, $this->getY() + 6.5, "X");

        /* TERMINA CUADROS DE ENCUENTRO */

        /* CUADROS DE DIÁLOGO */
        if (isset($evento->information)) {
            if ($evento->tipo_evento == 'DIALOGO') {
                $this->Rect(123, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(124, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(123, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(124, $this->getY() + 6.5, "");
            }
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */
            if ($evento->tipo_evento == 'VISTA') {

                /* CUADROS DE VISITA O RECORRIDO  */
                //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
                $this->Rect(191, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(192, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(191, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(192, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */
            if ($evento->tipo_evento == 'DEBATE') {
                /* CUADROS DE DEBATE  */
                $this->Rect(234, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(235, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(234, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(235, $this->getY() + 6.5, "");
            }
            //$this->Rect(234, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */
            if ($evento->tipo_evento == 'FORO') {
                /* CUADROS DE FORO  */
                $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
                $this->Text(271, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
                $this->Text(271, $this->getY() + 6.5, "");
            }
            //$this->Rect(270, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE FORO RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE FORO  */
        } else {
            $this->Rect(123, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(124, $this->getY() + 6.5, "");
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(191, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(192, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */

            /* CUADROS DE DEBATE  */
            $this->Rect(234, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
            $this->Text(235, $this->getY() + 6.5, "");
            //$this->Rect(234, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */

            /* CUADROS DE FORO  */
            $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
            $this->Text(271, $this->getY() + 6.5, "");
            //$this->Rect(270, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE FORO RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE FORO  */
        }
        $this->Ln();
        $this->Ln(1.5);

        //CONFIGURACION DE COLOR GRIS CON BLANCO
        //$this->setX($bordeX);
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(50, 10, utf8_decode("Objetivo del Evento:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->MultiCell(0, 5, utf8_decode($objetivo_evento), 0, 'L', 1);
        $y2 = $this->getY();

        if ($y >= $y2) {
            $this->setY($y);
        } else {
            $this->setY($y2);
        }
        $this->Ln();
        $this->Ln(2);


        //linea
        $this->Line($bordeX, $this->getY(), 277, $this->getY());
        $this->Ln(2);

        $this->SetFont('Gotham-B', '', 13);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(69, 66, 77); //color casi negro para las letras
        $this->Cell(90, 5, utf8_decode("INFORMACIÓN DEL RESPONSABLE"), 0, 0, 'C', 0);

        $this->Ln(7);
        // $this->setX($bordeX);
        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(50, 10, utf8_decode("Responsable político:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(130, 10, utf8_decode($responsable_politico), 0, 0, 'C', 1);

        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(40, 10, utf8_decode("Teléfonos:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
$x=$this->GetY()+5;
        $this->MultiCell(0, 5, utf8_decode($tel_responsable_politico), 0, 'L', 1);
$z=$this->GetY();

//esto quiere decir que si multicell son mas de dos lineas, ya no hace un LN extra, aqui entra cuando es multicell de 1 linea
if ($x==$z){ $this->Ln(); } 

 

        $this->setY($this->GetY() + 1.5);
        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(50, 10, utf8_decode("Responsable operativo:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(130, 10, utf8_decode($responsable_operativo), 0, 0, 'C', 1);

        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(40, 10, utf8_decode("Teléfonos:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
$x=$this->GetY()+5;
        $this->MultiCell(0, 5, utf8_decode($tel_responsable_operativo), 0, 'L', 1);
$z=$this->GetY();
//esto quiere decir que si multicell son mas de dos lineas, ya no hace un LN extra, aqui entra cuando es multicell de 1 linea
if ($x==$z){ $this->Ln(); } 

        $this->Ln(2);
        //linea
        $this->Line($bordeX, $this->getY(), 277, $this->getY());
        $this->Ln(2);


        /* INICIA LA LINEA DE TIPO DE VESTIMENTA */
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(45, 10, utf8_decode("Tipo de vestimenta:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(120, 10, utf8_decode("FORMAL                  INFORMAL                CASUAL"), 0, 0, 'C', 1);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(0.4, 5, '', 0); //cell without borders
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro
        if (isset($evento->information)) {
            /* CUADROS DE ENCUENTRO */
            //$this->Rect(80, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            if ($evento->information->vestimenta == 'FORMAL') {
                $this->Rect(80, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(81, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(80, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(81, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            if ($evento->information->vestimenta == 'INFORMAL') {
                $this->Rect(123, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(124, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(123, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(124, $this->getY() + 6.5, "");
            }
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(159, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->information->vestimenta == 'CASUAL') {
                $this->Rect(159, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(160, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(159, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(160, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */
        } else {
            //$this->Rect(80, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(80, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(81, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            $this->Rect(123, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(124, $this->getY() + 6.5, "");
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(159, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(159, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(160, $this->getY() + 6.5, "");
        }
        /* CUADROS DE DEBATE  */
        $this->Rect(234, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
        $this->Text(235, $this->getY() + 6.5, "");
        //$this->Rect(234, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
        /* TERMINA CUADROS DE DEBATE  */

        /* CUADROS DE FORO  */
        $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
        $this->Text(271, $this->getY() + 6.5, "");
        //$this->Rect(270, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE FORO RELLENO SOLO HACER UN IF
        /* TERMINA CUADROS DE FORO  */

        /* INICIA RENTABILIDAD */
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(30, 10, utf8_decode("Rentabilidad:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        // $this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode("POLÍTICA             ESTRATÉGICA  "), 0, 0, 'C', 1);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(0.4, 5, '', 0); //cell without borders
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro



        /* CUADROS DE DEBATE  */
        if (isset($evento->information)) {
            if ($evento->information->rentabilidad == 'ESTRATEGICA') {
                $this->Rect(227, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(228, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(227, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(228, $this->getY() + 6.5, "");
            }
            //$this->Rect(227, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */

            /* CUADROS DE FORO  */
            if ($evento->information->rentabilidad == 'POLITICA') {
                $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
                $this->Text(271, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
                $this->Text(271, $this->getY() + 6.5, "");
            }
            //$this->Rect(270, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE FORO RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE FORO  */
        } else {
            $this->Rect(227, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
            $this->Text(228, $this->getY() + 6.5, "");
            //$this->Rect(227, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */

            /* CUADROS DE FORO  */
            $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
            $this->Text(271, $this->getY() + 6.5, "");
        }
        $this->Ln();
        $this->Ln();
        $this->Ln(1.5);

        /* INICIA PARTICIPACION DEL CANDIDATO */

        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(65, 9, utf8_decode("Participación del C. Candidato:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(160, 10, utf8_decode("MASIVA              REUNIÓN PRIVADA             CONFERENCIA DE PRENSA          "), 0, 0, 'C', 1);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(0.4, 5, '', 0); //cell without borders
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro
        if (isset($evento->information)) {
            /* CUADROS DE ENCUENTRO */
            //$this->Rect(90, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            if ($evento->information->participacion == 'MASIVA') {
                $this->Rect(90, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(91, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(90, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(91, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            if ($evento->information->participacion == 'REUNION_PRIVADA') {
                $this->Rect(145, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(146, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(145, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(146, $this->getY() + 6.5, "");
            }
            //$this->Rect(145, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(215, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->information->participacion == 'CONFERENCIA_DE_PRENSA') {
                $this->Rect(215, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(216, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(215, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(216, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */
        } else {
            $this->Rect(90, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(91, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            $this->Rect(145, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(146, $this->getY() + 6.5, "");
            //$this->Rect(145, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(215, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(215, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(216, $this->getY() + 6.5, "");
        }


        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(0, 10, utf8_decode("OTRO:"), 'LTR', 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS


        $this->Ln();
        //$this->Ln(1.5); 

        /* INICIA ENCUENTRO SECTORIAL */
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(226, 10, utf8_decode("ENCUENTRO SECTORIAL             ENCUENTRO CON MILITANTES             ENCUENTRO CON SOCIEDAD CIVIL          "), 0, 0, 'C', 1);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(0.4, 5, '', 0); //cell without borders
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro
        if (isset($evento->information)) {
            /* CUADROS DE ENCUENTRO */
            //$this->Rect(80, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            if ($evento->information->participacion == 'ENCUENTRO_SECTORIAL') {
                $this->Rect(55, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(56, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(55, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(56, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            if ($evento->information->participacion == 'ENCUENTRO_CON_MILITANTES') {
                $this->Rect(132, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(133, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(132, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(133, $this->getY() + 6.5, "");
            }
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->information->participacion == 'ENCUENTRO_CON_SOCIEDAD_CIVIL') {
                $this->Rect(217, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(218, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(217, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(218, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */
        } else {
            //$this->Rect(80, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(55, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(56, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            $this->Rect(132, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(133, $this->getY() + 6.5, "");
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(217, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(218, $this->getY() + 6.5, "");
        }

        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(0);
$x=$this->GetY()+5;
        $this->MultiCell(0, 5, utf8_decode($otro_par_candidato), 'LBR', 'C', 0);
$z=$this->GetY();

//esto quiere decir que si multicell son mas de dos lineas, ya no hace un LN extra, aqui entra cuando es multicell de 1 linea
if ($x==$z){ $this->Ln(); } 

         //$this->Ln(); 
        // $this->Ln(1.5); 
        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->setY($this->gety() + 1.5);
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(50, 10, utf8_decode("Asistentes aproximados:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(30, 10, utf8_decode($asistentes_aproximados), 0, 0, 'C', 1);

        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(40, 10, utf8_decode("Sector:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode($sector), 0, 0, 'C', 1);

        $this->Ln();
        $this->Ln(1.5);

        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(20, 10, utf8_decode("Tema:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(113, 10, utf8_decode($tema), 0, 0, 'C', 1);

        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(30, 10, utf8_decode("Utilitarios:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(40, 10, utf8_decode("SI            NO            "), 0, 0, 'C', 1);


        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro
        /* CUADROS  */
        if (isset($evento->information)) {
            if ($evento->information->utilitarios == 'SI') {
                $this->Rect(172, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(173, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(172, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(173, $this->getY() + 6.5, "");
            }
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS  */

            /* CUADROS  */
            if ($evento->information->utilitarios == 'NO') {
                //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
                $this->Rect(193, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(194, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(193, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(194, $this->getY() + 6.5, "");
            }
        } else {
            $this->Rect(172, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(173, $this->getY() + 6.5, "");
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS  */

            /* CUADROS  */
            //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(193, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(194, $this->getY() + 6.5, "");
        }
        /* TERMINA CUADROS  */

        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(30, 10, utf8_decode("Folletos:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode("SI            NO            "), 0, 0, 'C', 1);

        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro

        if (isset($evento->information)) {
            /* CUADROS  */
            if ($evento->information->folletos == 'SI') {
                $this->Rect(243, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(244, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(243, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(244, $this->getY() + 6.5, "");
            }
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS  */

            /* CUADROS  */
            //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->information->folletos == 'NO') {
                $this->Rect(263, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(264, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(263, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(264, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS  */
        } else {
            $this->Rect(243, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(244, $this->getY() + 6.5, "");
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS  */

            /* CUADROS  */
            //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(263, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(264, $this->getY() + 6.5, "");
        }
        $this->Ln();
        $this->Ln(); //antes tenia $this->Ln(2); lo acabo de cambiar
        //color de la linea negro
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(0);

 $inicioy = $this->getY(); //verifico si es mayor a 186.5 ya se que hacer

                 if ( ($inicioy )>= 186.5){
                    $this->addPage(); //si supera los 186 de altura, pues ya lo pongo en otra hoja
                   // $this->Ln(1);
                }

        $this->Line($bordeX, $this->getY(), 277, $this->getY());
        $this->Ln(2);

        $this->SetFont('Gotham-B', '', 13);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(69, 66, 77); //color casi negro para las letras

        $this->Cell(80, 5, utf8_decode("REQUERIMIENTOS LOGÍSTICOS"), 0, 0, 'C', 0);

        $this->Ln(7);





        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(40, 10, utf8_decode("Seguridad:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode("SEGURIDAD                    AMBULANCIA                      BOMBEROS                    PROTECCIÓN CIVIL"), 0, 0, 'C', 1);
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro
        if (isset($evento->logisticrequiriment)) {
            /* CUADROS DE ENCUENTRO */
            //$this->Rect(93, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            if ($evento->logisticrequiriment->seguridad == 1) {
                $this->Rect(93, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(94, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(93, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(94, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            if ($evento->logisticrequiriment->ambulancia == 1) {
                $this->Rect(145, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(146, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(145, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(146, $this->getY() + 6.5, "");
            }
            //$this->Rect(145, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(193, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->logisticrequiriment->bomberos == 1) {
                $this->Rect(193, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(194, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(193, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(194, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */

            /* CUADROS DE DEBATE  */
            if ($evento->logisticrequiriment->proteccion_civil == 1) {
                $this->Rect(255, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(256, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(255, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(256, $this->getY() + 6.5, "");
            }

            //$this->Rect(255, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */
        } else {
            $this->Rect(93, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(94, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            $this->Rect(145, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(146, $this->getY() + 6.5, "");
            //$this->Rect(145, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(193, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(193, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(194, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */

            /* CUADROS DE DEBATE  */
            $this->Rect(255, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
            $this->Text(256, $this->getY() + 6.5, "");
        }
        $this->Ln();
        $this->Ln(1.5);



        /* INICIA CONDUCCION DEL EVENTO */

        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(60, 10, utf8_decode("Conducción del evento:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode("MAESTRO DE CEREMONIAS                            ARTISTA                         EDECANES"), 0, 0, 'C', 1);
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro
        if (isset($evento->logisticrequiriment)) {
            /* CUADROS DE ENCUENTRO */
            if ($evento->logisticrequiriment->maestro_ceremonias == 1) {
                //$this->Rect(80, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(149, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(150, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(149, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(150, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            if ($evento->logisticrequiriment->artista == 1) {
                $this->Rect(199, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(200, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(199, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(200, $this->getY() + 6.5, "");
            }

            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->logisticrequiriment->edecanes == 1) {
                $this->Rect(251, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(252, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(251, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(252, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */
        } else {
            /* CUADROS DE ENCUENTRO */
            //$this->Rect(80, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(149, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(150, $this->getY() + 6.5, "X");
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            $this->Rect(199, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(200, $this->getY() + 6.5, "X");
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(251, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(252, $this->getY() + 6.5, "X");
        }


        $this->Ln();
        $this->Ln(1.5);


        /* INICIA CONDUCCION DEL EVENTO */

        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(60, 9, utf8_decode("Tipo de Escenario:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 10);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode("TIPO AUDITORIO               CUADRILÁTERO                MEDIA LUNA                  MESA RUSA                 HERRADURA"), 0, 0, 'C', 1);
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro

        /* CUADROS DE ENCUENTRO */
        if (isset($evento->logisticrequiriment)) {
            //$this->Rect(102, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO

            if ($evento->logisticrequiriment->tipo_escenario == 'AUDITORIO') {
                $this->Rect(102, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(103, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(102, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(103, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            if ($evento->logisticrequiriment->tipo_escenario == 'CIRCULAR') {
                $this->Rect(148, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(149, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(148, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(149, $this->getY() + 6.5, "");
            }
            //$this->Rect(148, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(188, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->logisticrequiriment->tipo_escenario == 'MEDIALUNA') {
                $this->Rect(188, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(189, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(188, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(189, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */

            /* CUADROS DE DEBATE  */
            if ($evento->logisticrequiriment->tipo_escenario == 'MESARUSA') {
                $this->Rect(229, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(230, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(229, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(230, $this->getY() + 6.5, "");
            }
            //$this->Rect(229, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */

            /* CUADROS DE FORO  */
            if ($evento->logisticrequiriment->tipo_escenario == 'HERRADURA') {
                $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
                $this->Text(271, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
                $this->Text(271, $this->getY() + 6.5, "");
            }
            //$this->Rect(270, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE FORO RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE FORO  */
        } else {
            //$this->Rect(102, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(102, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(103, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            $this->Rect(148, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(149, $this->getY() + 6.5, "");
            //$this->Rect(148, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(188, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(188, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(189, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */

            /* CUADROS DE DEBATE  */
            $this->Rect(229, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
            $this->Text(230, $this->getY() + 6.5, "");
            //$this->Rect(229, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */

            /* CUADROS DE FORO  */
            $this->Rect(270, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE FORO VACIO
            $this->Text(271, $this->getY() + 6.5, "");
            //$this->Rect(270, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE FORO RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE FORO  */
        }
        $this->Ln();

        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(60, 10, utf8_decode("OTRO:"), 0, 0, 'R', 1);

        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode($otro_req_logico), 0, 0, 'C', 1);


        $this->Ln();
        $this->Ln(1.5);
        /* INICIA TIPO DE ESTRADO */
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(40, 10, utf8_decode("Tipo de estrado:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode("TEMPLETE                                 MESA DE TRABAJO                             PISO / A PIE "), 0, 0, 'C', 1);
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro

        /* CUADROS DE ENCUENTRO */
        if (isset($evento->logisticrequiriment)) {
            //$this->Rect(104, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            if ($evento->logisticrequiriment->tipo_estrado == 'TEMPLETE') {
                $this->Rect(104, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(105, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(104, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(105, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            if ($evento->logisticrequiriment->tipo_estrado == 'MESATRABAJO') {
                $this->Rect(182, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(183, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(182, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(183, $this->getY() + 6.5, "");
            }
            //$this->Rect(182, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(240, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->logisticrequiriment->tipo_estrado == 'PISO') {
                $this->Rect(240, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(241, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(240, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(241, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */
        } else {
            //$this->Rect(104, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(104, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(105, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            $this->Rect(182, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(183, $this->getY() + 6.5, "");
            //$this->Rect(182, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(240, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(240, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(241, $this->getY() + 6.5, "");
        }

        $this->Ln();
        $this->Ln(3);


        //iniciamos los cuadros de los checkbox
        //color de la linea negro
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(0);
        $this->Line($bordeX, $this->getY(), 277, $this->getY());
        $inicioy = $this->getY(); //pido la y es importante para regresar y llenar los demas
        $this->Ln(1);

        $this->SetFont('Gotham-M', '', 10);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(69, 66, 77); //color casi negro para las letras
        $this->Cell(110, 5, utf8_decode("    RECURSOS MATERIALES"), 0, 0, 'L', 0);
        $this->Cell(90, 5, utf8_decode("    INSUMOS DE SEGURIDAD"), 0, 0, 'L', 0);
        $this->Cell(0, 5, utf8_decode("    IMAGEN"), 0, 0, 'L', 0);

        $this->Ln();
        $this->Ln();

        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 7.5);
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);

        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro

        $y = $this->getY(); //pido la y es importante para regresar y llenar los demas

        if (isset($evento->logisticrequiriment)) {
            if (isset($evento->logisticrequiriment->materialresources)) {
                $materiales = $evento->logisticrequiriment->materialresources;
                for ($i = 0; $i < count($materiales); $i++) {
                    if ($i % 2 == 0) {
                        $this->Cell(55, 5, utf8_decode("             " . $materiales[$i]->cantidad . "-" . $materiales[$i]->tipo), 0, 0, 'L', 0);
                        /* CUADROS */
                        //$this->Rect(6, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                        $this->Rect(6, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                        $this->Text(6.5, $this->getY() + 3.5, "");
                        /* TERMINA CUADROS O */
                    } else {
                        $this->Cell(55, 5, utf8_decode("             " . $materiales[$i]->cantidad . "-" . $materiales[$i]->tipo), 0, 0, 'L', 0);
                        /* CUADROS */
                        //$this->Rect(61, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                        $this->Rect(61, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                        $this->Text(61.5, $this->getY() + 3.5, "");
                        /* TERMINA CUADROS O */
                        $this->Ln();
                    }
                }
            }
        }

        $this->Ln();
        $y1 = $this->getY(); //ESTA ES LA ALTURA AL MOMENTO DE   RECURSOS MATERIALES


        $this->setXY(110, $y);
        if (isset($evento->logisticrequiriment)) {
            if (isset($evento->logisticrequiriment->securitysupplies)) {
                $security = $evento->logisticrequiriment->securitysupplies;

                for ($i = 0; $i < count($security); $i++) {
                    $this->setX(110);
                    $this->Cell(90, 5, utf8_decode("             " . $security[$i]->cantidad . "-" . $security[$i]->tipo), 0, 0, 'L', 0);
                    /* CUADROS */
                    //$this->Rect(115, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                    $this->Rect(115, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                    $this->Text(115.5, $this->getY() + 3.5, "");
                    /* TERMINA CUADROS O */

                    $this->Ln();
                }
            }
        }
        $y2 = $this->getY(); //ESTA ES LA ALTURA AL MOMENTO DE   INSUMOS DE SEGURIDAD

        $this->setXY(195, $y);
        if (isset($evento->logisticrequiriment)) {
            if (isset($evento->logisticrequiriment->imageresources)) {
                $imagenresource = $evento->logisticrequiriment->imageresources;
                for ($i = 0; $i < count($imagenresource); $i++) {
                    $this->setX(195);
                    $this->Cell(90, 5, utf8_decode("             " . $imagenresource[$i]->cantidad . "-" . $imagenresource[$i]->tipo), 0, 0, 'L', 0);
                    /* CUADROS */
                    //$this->Rect(200, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                    $this->Rect(200, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                    $this->Text(200.5, $this->getY() + 3.5, "");
                    /* TERMINA CUADROS O */

                    $this->Ln();
                }
            }
        }
        $y3 = $this->getY(); //ESTA ES LA ALTURA AL MOMENTO DE  IMAGEN


        if ($y1 >= $y2) {
            $aux = $y1;
        } else {
            $aux = $y2;
        }

        if ($aux >= $y3) {
            $this->setY($aux);
        } else {
            $this->setY($y3);
        }


        //linea final de los 3 cuadritos,
        $this->Line($bordeX, $this->getY(), 277, $this->getY());

        //ahora hare las lineas verticales
        $this->Line($bordeX, $inicioy, $bordeX, $this->getY());
        $this->Line(111, $inicioy, 111, $this->getY()); //primera linea
        $this->Line(196, $inicioy, 196, $this->getY());
        $this->Line(277, $inicioy, 277, $this->getY());
        $inicioy = $this->getY(); //pido la y es importante para regresar y llenar los demas
        $this->Ln();

        //HAGO LA TABLA DE ALIMENTOS, EMPIEZA ALIMENTOS
        $this->SetFont('Gotham-M', '', 10);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(69, 66, 77); //color casi negro para las letras
        $this->Cell(110, 5, utf8_decode("    ALIMENTOS"), 0, 0, 'L', 0);

        $y = $this->getY(); //pido la y es importante para regresar y llenar los demas
        $this->Ln();
        $this->Ln();



        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 7.5);
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);

        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro


        if (isset($evento->logisticrequiriment)) {
            if ($evento->logisticrequiriment->hidratacion == 1) {

                $this->Cell(55, 5, utf8_decode("             PUNTOS DE HIDRATACIÓN"), 0, 0, 'L', 0);
                /* CUADROS */
                //$this->Rect(6, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(6, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(6.5, $this->getY() + 3.5, "X");
                /* TERMINA CUADROS O */
            } else {

                $this->Cell(55, 5, utf8_decode("             PUNTOS DE HIDRATACIÓN"), 0, 0, 'L', 0);
                /* CUADROS */
                //$this->Rect(6, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(6, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(6.5, $this->getY() + 3.5, "");
                /* TERMINA CUADROS O */
            }
            if ($evento->logisticrequiriment->cofeebreak == 1) {

                $this->Cell(55, 5, utf8_decode("             COFFEE BREAK"), 0, 0, 'L', 0);
                /* CUADROS */
                //$this->Rect(61, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(61, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(61.5, $this->getY() + 3.5, "X");
                /* TERMINA CUADROS O */
                $this->Ln();
            } else {

                $this->Cell(55, 5, utf8_decode("             COFFEE BREAK"), 0, 0, 'L', 0);
                /* CUADROS */
                //$this->Rect(61, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(61, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(61.5, $this->getY() + 3.5, "");
                /* TERMINA CUADROS O */
                $this->Ln();
            }
            if ($evento->logisticrequiriment->bocadillos == 1) {
                $this->Cell(55, 5, utf8_decode("             BOCADILLOS"), 0, 0, 'L', 0);
                /* CUADROS */
                //$this->Rect(6, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(6, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(6.5, $this->getY() + 3.5, "X");
                /* TERMINA CUADROS O */
            } else {
                $this->Cell(55, 5, utf8_decode("             BOCADILLOS"), 0, 0, 'L', 0);
                /* CUADROS */
                //$this->Rect(6, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(6, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(6.5, $this->getY() + 3.5, "");
                /* TERMINA CUADROS O */
            }
            if ($evento->logisticrequiriment->agua == 1) {
                $this->Cell(55, 5, utf8_decode("             PUNTOS DE HIDRATACIÓN"), 0, 0, 'L', 0);
                /* CUADROS */
                //$this->Rect(61, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(61, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(61.5, $this->getY() + 3.5, "X");
                /* TERMINA CUADROS O */
                $this->Ln();
            } else {
                $this->Cell(55, 5, utf8_decode("             PUNTOS DE HIDRATACIÓN"), 0, 0, 'L', 0);
                /* CUADROS */
                //$this->Rect(61, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(61, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(61.5, $this->getY() + 3.5, "");
                /* TERMINA CUADROS O */
                $this->Ln();
            }
            if ($evento->logisticrequiriment->otro_alimento != null) {
                //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
                $this->SetFont('Gotham-B', '', 7.5);
                //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
                $this->SetFillColor(238, 239, 236);
                $this->SetTextColor(0);
                $this->Cell(15, 5, utf8_decode("OTRO:"), 0, 0, 'R', 0);

                //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
                $this->SetFont('Helvetica', '', 7.5); //font de cuando se va a rellenar la informacion
                $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
                $this->SetTextColor(0);
                $this->MultiCell(90, 5, utf8_decode($evento->logisticrequiriment->otro_alimento), 0, 'L', 0);
                $y1 = $this->getY(); //ESTA ES LA ALTURA AL MOMENTO DE  alimentos
                //AHORA HARE EL CUADRO  DE AVALADO FISCALIZACIONES  
            } else {
                                //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
                $this->SetFont('Gotham-B', '', 7.5);
                //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
                $this->SetFillColor(238, 239, 236);
                $this->SetTextColor(0);
                $this->Cell(15, 5, utf8_decode("OTRO:"), 0, 0, 'R', 0);

                //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
                $this->SetFont('Helvetica', '', 7.5); //font de cuando se va a rellenar la informacion
                $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
                $this->SetTextColor(0);
                $this->MultiCell(90, 5, utf8_decode(""), 0, 'L', 0);
                $y1 = $this->getY(); //ESTA ES LA ALTURA AL MOMENTO DE  alimentos
                //AHORA HARE EL CUADRO  DE AVALADO FISCALIZACIONES  
            }
        } else {
            $this->Cell(55, 5, utf8_decode("             PUNTOS DE HIDRATACIÓN"), 0, 0, 'L', 0);
            /* CUADROS */
            //$this->Rect(6, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(6, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(6.5, $this->getY() + 3.5, "");
            /* TERMINA CUADROS O */

            $this->Cell(55, 5, utf8_decode("             COFFEE BREAK"), 0, 0, 'L', 0);
            /* CUADROS */
            //$this->Rect(61, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(61, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(61.5, $this->getY() + 3.5, "");
            /* TERMINA CUADROS O */
            $this->Ln();


            $this->Cell(55, 5, utf8_decode("             BOCADILLOS"), 0, 0, 'L', 0);
            /* CUADROS */
            //$this->Rect(6, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(6, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(6.5, $this->getY() + 3.5, "");
            /* TERMINA CUADROS O */

            $this->Cell(55, 5, utf8_decode("             PUNTOS DE HIDRATACIÓN"), 0, 0, 'L', 0);
            /* CUADROS */
            //$this->Rect(61, $this->getY()+1, 3,3 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(61, $this->getY() + 1, 3, 3, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(61.5, $this->getY() + 3.5, "");
            /* TERMINA CUADROS O */
            $this->Ln();
            //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
            $this->SetFont('Gotham-B', '', 7.5);
            //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
            $this->SetFillColor(238, 239, 236);
            $this->SetTextColor(0);
            $this->Cell(15, 5, utf8_decode("OTRO:"), 0, 0, 'R', 0);

            //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
            $this->SetFont('Helvetica', '', 7.5); //font de cuando se va a rellenar la informacion
            $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
            $this->SetTextColor(0);
            $this->MultiCell(90, 5, utf8_decode(" "), 0, 'L', 0);
            $y1 = $this->getY(); //ESTA ES LA ALTURA AL MOMENTO DE  alimentos
            //AHORA HARE EL CUADRO  DE AVALADO FISCALIZACIONES
        }
        $this->setXY(120, $y);
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(50, 10, utf8_decode("Avalado fiscalización:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(55, 10, utf8_decode("SI              NO      "), 0, 0, 'C', 1);


        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro
        /* CUADROS  */
        if (isset($evento->logisticrequiriment)) {
            if ($evento->logisticrequiriment->fiscalizacion == 'SI') {
                $this->Rect(187, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(188, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(187, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(188, $this->getY() + 6.5, "");
            }
            //$this->Rect(187, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS  */

            /* CUADROS  */
            //$this->Rect(209, $this->getY()+2.5, 5,5 ,'F'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->logisticrequiriment->fiscalizacion == 'NO') {
                $this->Rect(209, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(210, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(209, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(210, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS  */
        } else {
            $this->Rect(187, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(188, $this->getY() + 6.5, "");
            //$this->Rect(187, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS  */

            /* CUADROS  */
            //$this->Rect(209, $this->getY()+2.5, 5,5 ,'F'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(209, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(210, $this->getY() + 6.5, "");
        }


        //HAGO LA LINEA INFERIOR DE ALIMENTOS
        $this->setY($y1);
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro
        $this->Line($bordeX, $this->getY(), 277, $this->getY());

        //AHORA LAS LINEAS VERTICALES DE LOS CUADROS
        $this->Line($bordeX, $inicioy, $bordeX, $this->getY());
        $this->Line(111, $inicioy, 111, $this->getY()); //primera linea
        $this->Line(277, $inicioy, 277, $this->getY());

        $this->SetY($y1 + 5);
        //Ahora hago responsable de comunicacion
        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(70, 10, utf8_decode("Responsable de comunicación:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(120, 10, utf8_decode($responsable_comunicacion), 0, 0, 'C', 1);

        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(25, 10, utf8_decode("Teléfono:"), 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);


$x=$this->GetY()+5;
        $this->MultiCell(0, 5, utf8_decode($tel_responsable_comunicacion), 0, 'L', 1);
$z=$this->GetY();


//esto quiere decir que si multicell son mas de dos lineas, ya no hace un LN extra, aqui entra cuando es multicell de 1 linea
if ($x==$z){ $this->Ln(); } 


        //$this->Ln();
        $this->Ln(2);
        /* INICIA CONDUCCION DEL EVENTO */

        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(60, 9, utf8_decode("Cobertura de comunicación:"), 1, 0, 'C', 0);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode("PULL CDE                 MEDIOS LOCALES              MEDIOS NACIONALES               FOTÓGRAFO"), 0, 0, 'C', 1);
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro

        if ($evento->logisticrequiriment) {
            /* CUADROS DE ENCUENTRO */
            if ($evento->logisticrequiriment->pull_cde == 1) {
                //$this->Rect(80, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
                $this->Rect(102, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(103, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(102, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(103, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            if ($evento->logisticrequiriment->medios_locales == 1) {
                $this->Rect(157, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(158, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(157, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(158, $this->getY() + 6.5, "");
            }
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */
            if ($evento->logisticrequiriment->medios_nacionales == 1) {
                /* CUADROS DE VISITA O RECORRIDO  */
                //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
                $this->Rect(218, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(219, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(218, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(219, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */

            /* CUADROS DE DEBATE  */
            if ($evento->logisticrequiriment->fotografo == 1) {
                $this->Rect(262, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(263, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(262, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(263, $this->getY() + 6.5, "");
            }
            //$this->Rect(234, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */
        } else {
            /* CUADROS DE ENCUENTRO */
            //$this->Rect(80, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
            $this->Rect(102, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(103, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            $this->Rect(157, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(158, $this->getY() + 6.5, "");
            //$this->Rect(123, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(191, $this->getY()+2.5, 5,5 ,'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(218, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(219, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */

            /* CUADROS DE DEBATE  */
            $this->Rect(262, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
            $this->Text(263, $this->getY() + 6.5, "");
            //$this->Rect(234, $this->getY()+2.5, 5,5 ,'DF'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */
        }
        $this->Ln();

        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 11);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(60, 10, utf8_decode("OTRO:"), 0, 0, 'R', 1);

        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode($otro_resp_comunicacion), 0, 0, 'C', 1);


        $this->Ln();
        $this->Ln(1.5);


        //AQUI VA LA INFORMACION QUE VA DENTRO DE Otro
        $this->AddPage(); //creo una NUEVA pagina con el fin de que esto que viene inicie en una nueva pagina
        $this->SetFillColor(129, 185, 59);
        $this->SetTextColor(255);
        $this->SetFont('Arial', 'B', 12);


        $tamano = ($numero_de_presidiums * 10) / 2;
        $this->setX((270 / 2) - $tamano);

        if (($numero_de_presidiums) % 2 == 1) { //es impar
            $candidato = ($numero_de_presidiums / 2) + .5;
        } else {
            $candidato = ($numero_de_presidiums / 2) + 1;
        }

        for ($i = 0; $i <= $numero_de_presidiums; $i++) {

            if (($i + 1) == $candidato) {
                $this->Cell(10, 10, utf8_decode("*"), 1, 0, 'C', 1);
            } else {
                $this->Cell(10, 10, utf8_decode(""), 1, 0, 'C', 1);
            }
        }
        $this->Ln();
        $this->Ln(5);


        //TITULO   COLUMNA  Presidium

        $this->SetTextColor(0);
        $this->SetFont('Gotham-M', '', 10);
        $this->Cell(277, 5, utf8_decode("* Lic. Alfredo Del Mazo Maza"), 0, 0, 'C');
        $this->Ln();


        $this->SetTextColor(0);
        $this->SetFont('Gotham-M', '', 10);
        $this->Cell(277, 5, utf8_decode("Candidato a Gobernador del Estado de México"), 0, 0, 'C');
        $this->Ln();
        $this->Ln(5);




        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 10);
        $this->SetFillColor(85, 86, 85);
        $this->SetTextColor(255);
        $this->Cell(0, 10, utf8_decode("PRESÍDIUM / PRIMERA FILA"), 0, 0, 'C', 1);

        $this->Ln();


        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-B', '', 10);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(255);
        $this->Cell(20, 5, utf8_decode("Orden"), 'LR', 0, 'C', 1);
        $this->Cell(120, 5, utf8_decode("Nombre"), 'LR', 0, 'C', 1);
        $this->Cell(0, 5, utf8_decode("Cargo"), 'LR', 0, 'C', 1);


        $this->Ln();

        //CONFIGURACION SIN COLOR de fondo
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);


        //ESTO ES LO QUE IRIA EN UN FOR
        if (isset($evento->program)) {
            if (isset($evento->program->presidiummembers)) {
                $miembro_presidium = $evento->program->presidiummembers;
                for ($i = 0; $i < count($miembro_presidium); $i++) {

                    $this->Cell(20, 10, utf8_decode($miembro_presidium[$i]->numero), 1, 0, 'C', 1);
                    $this->Cell(120, 10, utf8_decode($miembro_presidium[$i]->nombre), 1, 0, 'C', 1);
                    $this->Cell(0, 10, utf8_decode($miembro_presidium[$i]->cargo), 1, 0, 'C', 1);
                    $this->Ln();
                }
            }
        }
        //HASTA AQUI EL FOR

        $this->Ln();


        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 10);
        $this->SetFillColor(85, 86, 85);
        $this->SetTextColor(255);
        $this->Cell(0, 10, utf8_decode("PROGRAMA"), 0, 0, 'C', 1);

        $this->Ln();


        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-B', '', 10);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(255);
        $this->Cell(20, 5, utf8_decode("N.P."), 'LR', 0, 'C', 1);
        $this->Cell(112, 5, utf8_decode("Intervención"), 'LR', 0, 'C', 1);
        $this->Cell(112, 5, utf8_decode("Cargo"), 'LR', 0, 'C', 1);
        $this->Cell(0, 5, utf8_decode("Duración (min)"), 'LR', 0, 'C', 1);


        $this->Ln();

        //CONFIGURACION SIN COLOR de fondo
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);


        //ESTO ES LO QUE IRIA EN UN FOR
        if (isset($evento->program)) {
            if (isset($evento->program->dayorders)) {
                $ordenesdia = $evento->program->dayorders;
                for ($i = 0; $i < count($ordenesdia); $i++) {

                    $this->Cell(20, 10, utf8_decode($ordenesdia[$i]->np), 1, 0, 'C', 1);
                    $this->Cell(112, 10, utf8_decode($ordenesdia[$i]->intervencion), 1, 0, 'C', 1);
                    $this->Cell(112, 10, utf8_decode($ordenesdia[$i]->cargo), 1, 0, 'C', 1);
                    $this->Cell(0, 10, utf8_decode($ordenesdia[$i]->minutos), 1, 0, 'C', 1);
                    $this->Ln();
                }
            }
        }
        //HASTA AQUI EL FOR

        $this->Ln();


        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 10);
        $this->SetFillColor(85, 86, 85);
        $this->SetTextColor(255);
        $this->Cell(0, 10, utf8_decode("PERSONAS SUSCEPTIBLES DE MENCIONAR EN MENSAJE"), 0, 0, 'C', 1);

        $this->Ln();


        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-B', '', 10);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(255);
        $this->Cell(20, 5, utf8_decode("Orden"), 'LR', 0, 'C', 1);
        $this->Cell(120, 5, utf8_decode("Nombre"), 'LR', 0, 'C', 1);
        $this->Cell(0, 5, utf8_decode("Justificación de la mención"), 'LR', 0, 'C', 1);


        $this->Ln();

        //CONFIGURACION SIN COLOR de fondo
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);

        //ESTO ES LO QUE IRIA EN UN FOR
        if (isset($evento->program)) {
            if (isset($evento->program->firstlines)) {
                $suceptibles = $evento->program->firstlines;
                for ($i = 0; $i < count($suceptibles); $i++) {

                    $this->Cell(20, 10, utf8_decode($suceptibles[$i]->numero), 1, 0, 'C', 1);
                    $this->Cell(120, 10, utf8_decode($suceptibles[$i]->nombre), 1, 0, 'C', 1);
                    $this->Cell(0, 10, utf8_decode($suceptibles[$i]->justificacion), 1, 0, 'C', 1);
                    $this->Ln();
                }
            }
        }
        //HASTA AQUI EL FOR

        $this->Ln();

        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 10);
        $this->SetFillColor(85, 86, 85);
        $this->SetTextColor(255);
        $this->Cell(0, 10, utf8_decode("INVITADOS ESPECIALES"), 0, 0, 'C', 1);

        $this->Ln();


        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-B', '', 10);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(255);
        $this->Cell(20, 5, utf8_decode("Orden"), 'LR', 0, 'C', 1);
        $this->Cell(120, 5, utf8_decode("Nombre"), 'LR', 0, 'C', 1);
        $this->Cell(0, 5, utf8_decode("Cargo"), 'LR', 0, 'C', 1);


        $this->Ln();

        //CONFIGURACION SIN COLOR de fondo
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);

        //ESTO ES LO QUE IRIA EN UN FOR
        if (isset($evento->program)) {
            if (isset($evento->program->especialassistans)) {
                $asistentes_especiales = $evento->program->especialassistans;
                for ($i = 0; $i < count($asistentes_especiales); $i++) {

                    $this->Cell(20, 10, utf8_decode($asistentes_especiales[$i]->numero), 1, 0, 'C', 1);
                    $this->Cell(120, 10, utf8_decode($asistentes_especiales[$i]->nombre), 1, 0, 'C', 1);
                    $this->Cell(0, 10, utf8_decode($asistentes_especiales[$i]->cargo), 1, 0, 'C', 1);
                    $this->Ln();
                }
            }
        }
        //HASTA AQUI EL FOR

        $this->Ln();

        //AQUI HARE LINEAS DISCURSIVAS
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 10);
        $this->SetFillColor(85, 86, 85);
        $this->SetTextColor(255);
        $this->Cell(0, 10, utf8_decode("Líneas discursivas (Información para el C. Candidato, incluyendo principales demandas)"), 0, 0, 'C', 1);

        $this->Ln();

        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        if (isset($evento->program)) {
            $html = $evento->program->contenido;
        } else {
            $html = '';
        }
        $html = str_replace('<ul>', "\n", $html);
        $html = str_replace('<li>', "       *", $html);
        $html = str_replace('</li>', "\n", $html);
$html = str_replace('<p>', "\n", $html);
        $html = str_replace('</br>', "\n", $html);
        $html = str_replace('<br/>', "\n", $html);
        $html = str_replace('</ul>', "", $html);
$html = str_replace('</p>', "", $html);
$html = str_replace('&nbsp;', " ", $html);
        $this->MultiCell(0, 5, utf8_decode($html), 0, 'L', 1);

        $this->Ln();
        //linea
        $this->Line($bordeX, $this->getY(), 277, $this->getY());
        $this->Ln(2);

        $this->SetFont('Gotham-B', '', 13);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(69, 66, 77); //color casi negro para las letras
        $this->Cell(90, 5, utf8_decode("CARACTERÍSTICAS DEL LUGAR"), 0, 0, 'C', 0);

        $this->Ln();
        $this->Ln();

        $this->SetFillColor(85, 86, 85);
        $this->SetTextColor(255);
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(30, 10, utf8_decode("Lugar:"), 0, 0, 'C', 1);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-B', '', 9);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 10, utf8_decode("ABIERTO                          CERRADO                             PÚBLICO PERMISO                         PRIVADO CARTA DE AUTORIZACIÓN"), 0, 0, 'C', 1);
        //Estos son los cuadros de la opcion
        $this->SetDrawColor(0, 0, 0); //todos los cuadros con borde negro
        $this->SetFillColor(0, 0, 0); //todos los cuadros con borde negro

        /* CUADROS DE ENCUENTRO */
        //$this->Rect(72, $this->getY()+2.5, 5,5 ,'F'); //ESTE ES EL CUADRO DE ENCUENTRO VACIO
        if (isset($evento->place)) {
            if ($evento->place->lugar == 'ABIERTO') {
                $this->Rect(72, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(73, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(72, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
                $this->Text(73, $this->getY() + 6.5, "X");
            }

            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            if ($evento->place->lugar == 'CERRADO') {
                $this->Rect(114, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(115, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(114, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
                $this->Text(115, $this->getY() + 6.5, "");
            }
            //$this->Rect(114, $this->getY()+2.5, 5,5 ,'F'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(172, $this->getY()+2.5, 5,5 ,'F'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            if ($evento->place->lugar == 'PUBLICO') {
                $this->Rect(172, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(173, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(172, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
                $this->Text(173, $this->getY() + 6.5, "");
            }
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */

            /* CUADROS DE DEBATE  */
            if ($evento->place->lugar == 'PRIVADO') {
                $this->Rect(257, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(258, $this->getY() + 6.5, "X");
            } else {
                $this->Rect(257, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
                $this->Text(258, $this->getY() + 6.5, "");
            }
            // $this->Rect(257, $this->getY()+2.5, 5,5 ,'F'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */
        } else {
            $this->Rect(72, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE ENCUENTRO RELLENO SOLO HACER UN IF
            $this->Text(73, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE ENCUENTRO */

            /* CUADROS DE DIÁLOGO */
            $this->Rect(114, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DIÁLOGO  VACIO
            $this->Text(115, $this->getY() + 6.5, "");
            //$this->Rect(114, $this->getY()+2.5, 5,5 ,'F'); //ESTE ES EL CUADRO DE DIÁLOGO  RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DIÁLOGO */

            /* CUADROS DE VISITA O RECORRIDO  */
            //$this->Rect(172, $this->getY()+2.5, 5,5 ,'F'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO   VACIO
            $this->Rect(172, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE VISITA O RECORRIDO  RELLENO SOLO HACER UN IF
            $this->Text(173, $this->getY() + 6.5, "");
            /* TERMINA CUADROS DE VISITA O RECORRIDO  */

            /* CUADROS DE DEBATE  */
            $this->Rect(257, $this->getY() + 2.5, 5, 5, 'D'); //ESTE ES EL CUADRO DE DEBATE   VACIO
            $this->Text(258, $this->getY() + 6.5, "");
            // $this->Rect(257, $this->getY()+2.5, 5,5 ,'F'); //ESTE ES EL CUADRO DE DEBATE RELLENO SOLO HACER UN IF
            /* TERMINA CUADROS DE DEBATE  */
        }


        $this->Ln();
        $this->Ln(2);
$y=$this->getY();

  if ( ($y )>= 177){
                    $this->addPage(); //si supera los 140 de altura, pues ya lo pongo en otra hoja
$this->Ln(0);
                    $y=$this->getY();
                }
        //ahora hare descripcion del lugar
        $this->SetFillColor(85, 86, 85);
        $this->SetTextColor(255);
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(40, 10, utf8_decode("Descripción física:"), 0, 0, 'C', 1);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
$posx=$this->getX();
        $this->MultiCell(150, 5, utf8_decode($descripcion_fisica), 0, 'C', 1);
$y1=$this->getY();

               

$this->setXY($posx+150,$y);
        //ahora hare descripcion del lugar
        $this->SetFillColor(85, 86, 85);
        $this->SetTextColor(255);
        $this->SetFont('Gotham-M', '', 11);
        $this->Cell(30, 10, utf8_decode("Accesos:"), 0, 0, 'C', 1);
        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 5, '', 0); //cell without borders
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->MultiCell(0, 5, utf8_decode($accesos), 0, 'L', true);
        $y2=$this->getY();


       if ($y1 >= $y2) {
            $this->setY($y1);
        } else {
            $this->setY($y2); 
        }
 $this->Ln(2);

        //AHORA PONDRE LAS 3 IMAGENES
        //CONFIGURACION DE COLOR VERDE CON BLANCO
                 if ( ($this->getY() )>= 136.5){
                    $this->addPage(); //si supera los 140 de altura, pues ya lo pongo en otra hoja
                    $this->Ln(0.1);
                }

 
        $this->SetFont('Gotham-M', '', 10);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(255);
        $this->Cell(275, 5, utf8_decode("IMÁGENES DEL LUGAR"), 1, 0, 'C', 1);
        $this->Ln(); 
        if (isset($evento->place)) {
            $array_imagenes_lugar = array();
            if ( $evento->place->imagen_atras != null) {
                $array_imagenes_lugar[0] = $evento->place->imagen_atras;
            } else {
                $array_imagenes_lugar[0] = 'fondo_mapa.png';
            }
            if ($evento->place->imagen_frente != null) {
                $array_imagenes_lugar[1] = $evento->place->imagen_frente;
            } else {
                $array_imagenes_lugar[1] = 'fondo_mapa.png';
            }
            if ($evento->place->imagen_exterior != null) {
                $array_imagenes_lugar[2] = $evento->place->imagen_exterior;
            } else {
                $array_imagenes_lugar[2] = 'fondo_mapa.png';
            }
            for ($i = 0; $i <= 2; $i++) {
                $this->Cell(91.66, 55, $this->Image("http://smsem.org.mx/pregiras/uploads/fotos_lugar/".$array_imagenes_lugar[$i]."", $this->GetX() + 2, $this->GetY() + 2, 88, 50), 1, 0, 'C');
            }
        } else {
            $array_imagenes_lugar[0] = 'fondo_mapa.png';
            $array_imagenes_lugar[1] = 'fondo_mapa.png';
            $array_imagenes_lugar[2] = 'fondo_mapa.png';
            for ($i = 0; $i <= 2; $i++) {
                $this->Cell(91.66, 55, $this->Image('http://smsem.org.mx/pregiras/uploads/fotos_lugar/'.$array_imagenes_lugar[$i] . "", $this->GetX() + 2, $this->GetY() + 2, 88, 50), 1, 0, 'C');
            }
        }
        $this->setY($this->getY() + 5);
        $this->Ln();

        $inicioy = $this->getY();
                 if ( ($inicioy )>= 186){
                    $this->addPage(); //si supera los 186 de altura, pues ya lo pongo en otra hoja
                    $this->Ln(1);
                    $inicioy = $this->getY();
                }

        //AHORA HARE RIESGOS QUE PUEDAN...
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-M', '', 10);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(135, 5, utf8_decode("RIESGOS QUE PUEDAN ALTERAR EL BUEN DESARROLLO DEL EVENTO:"), 0, 0, 'C', 1);

        $this->Ln();
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->MultiCell(135, 5, utf8_decode($riesgos), 0, 'L', true);
        $y1 = $this->getY();

        $this->setXY(140, $inicioy);

        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Gotham-M', '', 10);
        //$this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFillColor(238, 239, 236);
        $this->SetTextColor(0);
        $this->Cell(0, 5, utf8_decode("PROBLEMÁTICA POLÍTICA:"), 0, 0, 'L', 1);

        $this->Ln();
        $this->setX(140);
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->MultiCell(0, 5, utf8_decode($problematica_politica), 0, 'L', true);
        $y2 = $this->getY();

        //saber cual es el ms grande la y mas grande
        if ($y1 >= $y2) {
            $this->setY($y1);
        } else {
            $this->setY($y2);
        }
        $this->Ln();

        $this->SetFont('Gotham-B', '', 14);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(69, 66, 77); //color casi negro para las letras
        $this->Cell(0, 5, utf8_decode("DISEÑO DEL EVENTO (CROQUIS)"), 0, 0, 'C', 0);

        $this->Ln();
        $this->Ln();
        if (isset($evento->foto_responsable_operativo)) {
            if ($evento->foto_responsable_operativo != NULL || $evento->foto_responsable_operativo !='') {
                $this->Image('http://smsem.org.mx/pregiras/uploads/fotos_responsable/'.$evento->foto_responsable_operativo, $this->GetX() + $bordeX + 70, $this->GetY(), 130, 45);
            }else {
                $this->Image('http://smsem.org.mx/pregiras/img/fondo_mapa.png', $this->GetX() + $bordeX, $this->GetY(), 273, 45);
            }
        }


        $this->setY($this->GetY() + 50);

//aqui vere , si esto ya supera el getY arriba de 168, pues ya lo paso ala hoja que sigue para que salga completo la linea del nombre y cargo
                if ( ($this->getY() )>= 167.5){
                    $this->addPage(); //si supera los 140 de altura, pues ya lo pongo en otra hoja
                    $this->Ln(0.5);             
                }
                
         $cadena_aux = explode(" ",$evento->created_at);       
        //aqui hare lod eabajo del mapa
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetDrawColor(0, 0, 0);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(30, 5, "Fecha pregira:", 1, 0, 'C', 0);
        $this->Cell(0.4, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(35, 5, utf8_decode($cadena_aux[0]), 0, 0, 'C', 1);

        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 0, '', 0); //cell without borders horizontal
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(45, 5, "Hora de pregira:", 1, 0, 'C', 0);
        $this->Cell(0.4, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(35, 5, utf8_decode($cadena_aux[1]), 0, 0, 'C', 1);


        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 0, '', 0); //cell without borders horizontal
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(45, 5, "Entrega formato:", 1, 0, 'C', 0);
        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(35, 5, utf8_decode(''), 0, 0, 'C', 1);

        //CELDA VACIA QUE SOLO SIRVE DE ESPACIO ENTRE CELDAS
        $this->Cell(1, 0, '', 0); //cell without borders horizontal
        //CONFIGURACION DE COLOR GRIS CON BLANCO
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(25, 5, utf8_decode("Versión:"), 1, 0, 'C', 0);

        $this->Cell(0.5, 0, '', 0); //cell without borders horizontal
        //ESTOS SON CONFIGURACIONES DE COLOR DE FONDO DONDE SE INSERTA TEXTO DEL FORMULARIO
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(0);
        $this->Cell(0, 5, utf8_decode($evento->contador_pdf), 0, 0, 'C', 1);

        $this->Ln();
        $this->Ln(15);
        $this->Line(35, $this->getY(), 100, $this->getY());
        $this->Line(175, $this->getY(), 240, $this->getY());
        $this->Ln(2);

        $this->SetFont('Gotham-M', '', 7);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(130, 5, utf8_decode("Nombre y firma:"), 0, 0, 'C', 0);
        $this->Cell(10, 0, '', 0); //cell without borders horizontal
        $this->SetFont('Gotham-M', '', 7);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(130, 5, utf8_decode("Nombre y firma:"), 0, 0, 'C', 0);

        $this->Ln();

        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(130, 5, utf8_decode($responsable_politico), 0, 0, 'C', 0);
        $this->Cell(10, 0, '', 0); //cell without borders horizontal
        $this->SetFont('Gotham-M', '', 11);
        $this->SetFillColor(243, 239, 234);
        $this->SetTextColor(87, 88, 93); //color mas grisaseo para las letras
        $this->Cell(130, 5, utf8_decode($responsable_operativo), 0, 0, 'C', 0);
    }

    /* public function render(){
      $pdf = new Pdf('L', 'mm', 'Letter');
      $pdf->AliasNbPages(); //necesario para contar el total de paginas, si no no sirve
      #Establecemos los márgenes izquierda, arriba y derecha:
      $pdf->SetMargins(1.5,  0 , 3);
      #Establecemos los márgenes izquierda, arriba y derecha:
      //$pdf->SetMargins(0, 0 ,0);


      $pdf->AddPage();
      $imagenmapa = 'C:\Users\zero_\Pictures\mapa.PNG';
      $fotoresp = 'http://fdzeta.com/imgcache/524385dz.jpg';
      $array = 'http://vignette2.wikia.nocookie.net/legendmarielu/images/b/b4/No_image_available.jpg';
      $pdf->mainTable($imagenmapa, $array);

      $pdf->Ln();
      $pdf->Output();
      } */

    function Circle($x, $y, $r, $style = 'D') {
        $this->Ellipse($x, $y, $r, $r, $style);
    }

    function SemiCircle($x, $y, $r, $style = 'D') {
        $this->SemiEllipse($x, $y, $r, $r, $style);
    }

    function Ellipse($x, $y, $rx, $ry, $style = 'D') {
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $lx = 4 / 3 * (M_SQRT2 - 1) * $rx;
        $ly = 4 / 3 * (M_SQRT2 - 1) * $ry;
        $k = $this->k;
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c', ($x + $rx) * $k, ($h - $y) * $k, ($x + $rx) * $k, ($h - ($y - $ly)) * $k, ($x + $lx) * $k, ($h - ($y - $ry)) * $k, $x * $k, ($h - ($y - $ry)) * $k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', ($x - $lx) * $k, ($h - ($y - $ry)) * $k, ($x - $rx) * $k, ($h - ($y - $ly)) * $k, ($x - $rx) * $k, ($h - $y) * $k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', ($x - $rx) * $k, ($h - ($y + $ly)) * $k, ($x - $lx) * $k, ($h - ($y + $ry)) * $k, $x * $k, ($h - ($y + $ry)) * $k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s', ($x + $lx) * $k, ($h - ($y + $ry)) * $k, ($x + $rx) * $k, ($h - ($y + $ly)) * $k, ($x + $rx) * $k, ($h - $y) * $k, $op));
    }

    function SemiEllipse($x, $y, $rx, $ry, $style = 'D') {
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $lx = 4 / 3 * (M_SQRT2 - 1) * $rx;
        $ly = 4 / 3 * (M_SQRT2 - 1) * $ry;
        $k = $this->k;
        $h = $this->h;
        $this->_out(sprintf('%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c', ($x + $rx) * $k, ($h - $y) * $k, ($x + $rx) * $k, ($h - ($y - $ly)) * $k, ($x + $lx) * $k, ($h - ($y - $ry)) * $k, $x * $k, ($h - ($y - $ry)) * $k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', ($x - $lx) * $k, ($h - ($y - $ry)) * $k, ($x - $rx) * $k, ($h - ($y - $ly)) * $k, ($x - $rx) * $k, ($h - $y) * $k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c', ($x - $rx) * $k, ($h - ($y + $ly)) * $k, ($x - $lx) * $k, ($h - ($y + $ry)) * $k, $x * $k, ($h - ($y + $ry)) * $k));
        $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c %s', ($x + $lx) * $k, ($h - ($y + $ry)) * $k, ($x + $rx) * $k, ($h - ($y + $ly)) * $k, ($x + $rx) * $k, ($h - $y) * $k, $op));
    }

}
