<?php

namespace App\Http\Controllers;

//require('MultiCellBlt2.php');
//require('fpdf18/fpdf.php');
use FPDF;
use DateTime;

class Ficha extends \fpdf\FPDF {

    function Header() {

        //indicamos la font a utilizar para el titulo
        $this->AddFont('Gotham-M', 'B', 'gotham-medium.php');
        //seteamos el titulo que aparecera en el navegador 
        $this->SetTitle(utf8_decode('Toma de Protesta Candidato PVEM'));

        //linea que simplemente me marca la mitad de la hoja como referencia
        $this->Line(139.5, $this->getY(), 140, 250);

        //bajamos la cabecera 13 espacios
        $this->Ln(10);
    }

    function Contenido($imagenlogo, $evento, $fotoresp) {
        $inicio = $this->getY();
        if (isset($evento)) {
            $evento_nombre = $evento->nombre;
        } else {
            $evento_nombre = '';
        }        
//seteamos la fuente, el color de texto, y el color de fondo de el titulo
        $this->SetFont('Gotham-M', 'B', 9);
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(73, 168, 63);
        //escribimos titulo
       
$this->MultiCell(0,5,utf8_decode($evento_nombre),0,'C',1); //el completo es 279 bueno 280 /2 = 140  si seran 10 de cada borde, entonces 120








        //seteamos el margen del contenido
        $this->SetMargins(10, 10, 151.5);
        //mitad de la hoja de la mitad tomada para poner los datos del evento
        $mitad = 59;
        //borde x para los numeros y los puntos
        $bordex = 10;
        //variables locales
        if (isset($evento)) {
            $evento_nombre = $evento->nombre;
            $ent = strtotime($evento->f_inicio);
            $sal = strtotime($evento->f_final);
            $hora_final = explode(' ', $evento->f_final);

            $aux_fecha_ent = $sal - $ent;
            $duracion_evento = round(abs($aux_fecha_ent) / 60, 2);
            $hora = explode(" ", $evento->f_inicio);
            $dt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $evento->f_inicio, 'America/Mexico_City');
            setlocale(LC_TIME, 'es-MX');
            $fecha_evento = $dt->formatLocalized('%A %d %B del %Y');
            $hora_evento = $hora[1];
// Mittwoch 21 Mai 1975
            setlocale(LC_TIME, '');
            $domicilio_evento = $evento->calle_numero . ", " . $evento->colonia . ", " . "CP: " . $evento->cp . ", " . $evento->municipality->name;
            $municipio_evento = "";
            $hora_convocatoria = $evento->hora_convocatoria;
            if (isset($evento->information)) {
                $asistentes_aproximados = $evento->information->asistentes;
                $vestimenta = $evento->information->vestimenta;
            } else {
                $asistentes_aproximados = '';
                $vestimenta = '';
            }
            $hora_termino_evento = $hora_final[1];
            $responsable_politico = $evento->responsable_politico; //." / ".$evento->cargo_responsable_politico;
        } else {
            $fecha_evento = "";
            $hora_evento = '';
            $domicilio_evento = "";
            $municipio_evento = "";
            $asistentes_aproximados = '';
            $hora_convocatoria = "";
            $duracion_evento = '';
            $hora_termino_evento = '';
            $vestimenta = '';
            $responsable_politico = '';
            $evento_nombre = '';
        }



        //declaramos las fuentes a usar o tentativamente a usar ya que no sabemos cual es la original
        $this->AddFont('Gotham-B', '', 'gotham-book.php');
        $this->AddFont('Gotham-B', 'B', 'gotham-book.php');
        $this->AddFont('Gotham-M', '', 'gotham-medium.php');
        $this->AddFont('Helvetica', '', 'helvetica.php');

        //la imagen del PVEM
       // $this->Image($imagenlogo, $this->GetX() + 10, $this->GetY() + 15, 30, 30);

        //el primer espacio
        $this->Ln(3);

        //fecha y hora del evento
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(255, 0, 0); //color rojo para las letras
        $this->Cell(0, 5, utf8_decode($fecha_evento . ", " . $hora_evento . " hrs."), 0, 0, 'R', 0);

        //bajamos renglon
        $this->Ln();

        //domicilio y municipio del evento
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color negro para las letras
        //posicionamos ala mitad de la hoja
        $this->setX($mitad);
        $this->MultiCell(0, 5, utf8_decode($domicilio_evento . "" . $municipio_evento . ""), 0, 'R', 0);

        $this->setY($this->GetY() + 2);


        //asistentes del evento
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(118, 118, 118); //color gris para las letras
        //posicionamos ala mitad de la hoja
        $this->setX($mitad);
        $this->Cell(55, 5, utf8_decode("Asistentes: "), 0, 0, 'R', 0);

        //respuesta
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->Cell(0, 5, utf8_decode($asistentes_aproximados), 0, 0, 'R', 0);


        //bajamos renglon
        $this->Ln(7);

        //asistentes del evento
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(118, 118, 118); //color gris para las letras
        //posicionamos ala mitad de la hoja
        $this->setX($mitad);
        $this->Cell(55, 5, utf8_decode("Hora de convocatoria: "), 0, 0, 'R', 0);

        //respuesta
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->Cell(0, 5, utf8_decode($hora_convocatoria), 0, 0, 'R', 0);


        //bajamos renglon
        $this->Ln(7);

        //asistentes del evento
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(118, 118, 118); //color gris para las letras
        //posicionamos ala mitad de la hoja
        $this->setX($mitad);
        $this->Cell(50, 5, utf8_decode("Duracion: "), 0, 0, 'R', 0);

        //respuesta
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->Cell(0, 5, utf8_decode($duracion_evento . " Minutos"), 0, 0, 'R', 0);


        //bajamos renglon
        $this->Ln(7);

        //asistentes del evento
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(118, 118, 118); //color gris para las letras
        //posicionamos ala mitad de la hoja
        $this->setX($mitad);
        $this->Cell(50, 5, utf8_decode("Término del Evento: "), 0, 0, 'R', 0);

        //respuesta
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->Cell(0, 5, utf8_decode($hora_termino_evento . " hrs."), 0, 0, 'R', 0);

        //bajamos renglon
        $this->Ln(7);

        //asistentes del evento
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(118, 118, 118); //color gris para las letras
        //posicionamos ala mitad de la hoja
        $this->setX($mitad);
        $this->Cell(50, 5, utf8_decode("Vestimenta: "), 0, 0, 'R', 0);

        //respuesta
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->Cell(0, 5, utf8_decode($vestimenta), 0, 0, 'R', 0);


        //bajamos renglon
        $this->Ln(7);

        //asistentes del evento
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(118, 118, 118); //color gris para las letras
        //posicionamos ala mitad de la hoja
        $this->setX(25);
        $this->Cell(50, 5, utf8_decode("Responsable del Evento: "), 0, 0, 'R', 0);

        //respuesta
        $this->SetFont('Helvetica', '', 8.5); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->MultiCell(0, 5, utf8_decode($responsable_politico), 0, 'R', 0);


        $this->Ln(1);

        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->Cell(25, 5, utf8_decode("Programa:"), 0, 0, 'C', 1);

        $this->Ln();
        $this->Ln();


        $sample_text = 'This is bulleted text. The text is indented and the bullet appears at the first line only. This list is built with a single call to MultiCellBltArray().';
        //aqui vienen los numeros
        //Test 3
        $test3 = array();
        $test3['bullet'] = 1;
        $test3['margin'] = ')     ';
        $test3['indent'] = 10;
        $test3['spacer'] = 2.5; //espacio
        $test3['text'] = array();
        if (isset($evento->program)) {
            if (isset($evento->program->dayorders)) {
                $ordenes = $evento->program->dayorders->sortByDesc('np');
                $test3 = '';
                for ($i = 0; $i < count($ordenes); $i++) {
                    $test3 = $test3 . '' . $ordenes[$i]->np . ") Intervencion: " . $ordenes[$i]->intervencion . ' Cargo: ' . $ordenes[$i]->cargo . " Duracion: " . $ordenes[$i]->minutos . " Minutos.\n";
                }
                $this->SetX($bordex);
                $this->MultiCell(120, 6,utf8_decode( $test3), 0, 'L', 0);
            }
        } else {
            $this->SetX($bordex);
            $this->MultiCellBltArray(120, 6, $test3);
        }


        $this->Ln();

        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->Cell(25, 5, utf8_decode("Asistentes:"), 0, 0, 'C', 1);

        $this->Ln();
        $this->Ln();


        if (isset($evento->program)) {
            $html = $evento->program->asistentes_ficha;
            $html = str_replace('<ul>', "", $html);
            $html = str_replace('<li>', "*   ", $html);
            $html = str_replace('</li>', "\n", $html);
            $html = str_replace('<p>', "\n", $html);
            $html = str_replace('</br>', "\n", $html);
            $html = str_replace('<br/>', "\n", $html);
            $html = str_replace('<br>', "\n", $html);
            $html = str_replace('</ul>', "", $html);
            $html = str_replace('</p>', "", $html);
            $html = str_replace('&nbsp;', " ", $html);
        } else {
            $html = "";
            $html = str_replace('<ul>', "", $html);
            $html = str_replace('<li>', "*   ", $html);
            $html = str_replace('</li>', "\n", $html);
            $html = str_replace('<p>', "\n", $html);
            $html = str_replace('</br>', "\n", $html);
            $html = str_replace('<br/>', "\n", $html);
            $html = str_replace('<br>', "\n", $html);
            $html = str_replace('</ul>', "", $html);
            $html = str_replace('</p>', "", $html);
            $html = str_replace('&nbsp;', " ", $html);
        }
        $this->MultiCell(120, 5, utf8_decode($html), 0, 'L', 0);


        //inicia hoja 2
        //borde x para los numeros y los puntos
        $bordex = 150;
        $this->setY($inicio);

        //seteamos la fuente, el color de texto, y el color de fondo de el titulo
        $this->SetFont('Gotham-M', 'B', 9);
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(73, 168, 63);
        //escribimos titulo
        $this->setX($bordex);
 
$this->MultiCell(120,5,utf8_decode($evento_nombre),0,'C',1); //el completo es 279 bueno 280 /2 = 140  si seran 10 de cada borde, entonces 120

       // $this->Ln();
        $this->setX($bordex);
        //seteamos el margen del contenido
        $this->SetMargins(10, 10, 151.5);

        //declaramos las fuentes a usar o tentativamente a usar ya que no sabemos cual es la original
        $this->AddFont('Gotham-B', '', 'gotham-book.php');
        $this->AddFont('Gotham-B', 'B', 'gotham-book.php');
        $this->AddFont('Gotham-M', '', 'gotham-medium.php');
        $this->AddFont('Helvetica', '', 'helvetica.php');

        //variables locales
        if (isset($evento->program)) {
            if (isset($evento->program->presidiummembers)) {
                $numero_de_presidiums = count($evento->program->presidiummembers);
            } else {
                $numero_de_presidiums = 0;
            }
        } else {
            $numero_de_presidiums = 0;
        }
        // da exactamente el numero de cuadros que se indique aqui, para que de uno mas, eliminar el menos 1 de los for.
        //el codigo soporta maximo 19 personas en el presidium menos el candidato 16.

        $presidium_orden = "1";
        $presidium_nombre = "Cesar Gibran Cadena Espinosa de los Monteros";
        $presidium_cargo = "Dirigente de Redes y Enlaces ";
        if (isset($evento->foto_responsable_operativo)) {
            if ($evento->foto_responsable_operativo != NULL || $evento->foto_responsable_operativo !='') {
                $this->Image('http://smsem.org.mx/pregiras/uploads/fotos_responsable/'.$evento->foto_responsable_operativo, $this->GetX() + 10, $this->GetY() + 10, 100, 40);
            }else {
                $this->Image('http://smsem.org.mx/pregiras/img/fondo_mapa.png', $this->GetX() + 10, $this->GetY() + 10, 100, 40);
            }
        }
       
        $this->Ln(3);
        $this->setX($bordex);
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->Cell(35, 5, utf8_decode("Distribución Logística:"), 0, 0, 'C', 1);

        $this->setY($this->GetY() + 45);
        $this->Ln();
        $this->setX($bordex);
        $this->SetFillColor(231, 234, 243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0, 0, 0); //color gris para las letras
        $this->Cell(40, 5, utf8_decode("Presídium (Primera Fila):"), 0, 0, 'C', 1);

        $this->Ln();
        $this->Ln();
        $this->setX($bordex);
        $this->SetFillColor(160, 68, 68); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(255); //color gris para las letras
        if (isset($evento->program)) {

            if (isset($evento->program->presidiummembers)) {
                $tamano = ($numero_de_presidiums * 7.5) / 2;
                $this->setX(212 - $tamano);

                if (($numero_de_presidiums) % 2 == 1) { //es impar
                    $candidato = ($numero_de_presidiums / 2) + .5;
                } else {
                    $candidato = ($numero_de_presidiums / 2) + 1;
                }

                for ($i = 0; $i <= $numero_de_presidiums - 1; $i++) {

                    if (($i + 1) == $candidato) {
                        $this->Cell(7, 7, utf8_decode("*"), 1, 0, 'C', 1);
                    } else {
                        $this->Cell(7, 7, utf8_decode(""), 1, 0, 'C', 1);
                    }
                }
            }
        }
        $this->Ln();
        $this->Ln(5);
        $this->setX($bordex);

        //CONFIGURACION DE COLOR VERDE CON BLANCO
        $this->SetFont('Gotham-B', '', 6.5);
        $this->SetFillColor(73, 168, 63);
        $this->SetTextColor(255);
        $this->Cell(9, 5, utf8_decode("Orden"), 'LR', 0, 'C', 1);
        $this->Cell(55, 5, utf8_decode("Nombre"), 'LR', 0, 'C', 1);
        $this->Cell(55, 5, utf8_decode("Cargo"), 'LR', 0, 'C', 1);


        $this->Ln();

        $this->setX($bordex);
        //CONFIGURACION SIN COLOR de fondo
        $this->SetFont('Helvetica', '', 6.5); //font de cuando se va a rellenar la informacion
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);


        //ESTO ES LO QUE IRIA EN UN FOR
        if (isset($evento->program)) {
            if (isset($evento->program->presidiummembers)) {
                $miembro_presidium = $evento->program->presidiummembers;
                for ($i = 0; $i <= $numero_de_presidiums - 1; $i++) {
$inicioy=$this->getY();
$this->SetFillColor(255, 255, 255);
                    $this->Cell(9, 5, utf8_decode($miembro_presidium[$i]->numero), 'T', 0, 'C', 1);
                    $this->Cell(55, 5, utf8_decode($miembro_presidium[$i]->nombre), 'T', 0, 'C', 1);
                    $this->MultiCell(55, 5, utf8_decode($miembro_presidium[$i]->cargo), 1, 'C', 1);
                    
                        /*AQUI HAGO LAS LINEAS DE LOS CUADROS*/
                        $this->SetDrawColor(0,0, 0); //todos los cuadros con borde negro
                        $this->SetFillColor(0,0, 0); //todos los cuadros con borde negro
                        $this->Line($bordex,$this->getY(),214,$this->getY()); //LINEA INFERIOR
                        //AHORA LAS LINEAS VERTICALES DE LOS CUADROS
                        $this->Line($bordex,$inicioy,$bordex,$this->getY());
                        $this->Line($bordex+9,$inicioy,$bordex+9,$this->getY());

                    $this->Ln(1);
                    $this->setX($bordex);
                }
            }
        }

        $this->addPage(); //carlos hizo addpage
        //seteamos el margen del contenido
        $this->SetMargins(10, 10, 151.5);

        $inicio = $this->getY();
        if (isset($evento)) {
            $evento_nombre = $evento->nombre;
        } else {
            $evento_nombre = '';
        }        
//seteamos la fuente, el color de texto, y el color de fondo de el titulo
        $this->SetFont('Gotham-M', 'B', 9);
        $this->SetTextColor(255, 255, 255);
        $this->SetFillColor(73, 168, 63);
        //escribimos titulo
      
$this->MultiCell(0,5,utf8_decode($evento_nombre),0,'C',1); //el completo es 279 bueno 280 /2 = 140  si seran 10 de cada borde, entonces 120



  


        //declaramos las fuentes a usar o tentativamente a usar ya que no sabemos cual es la original
        $this->AddFont('Gotham-B', '', 'gotham-book.php');
        $this->AddFont('Gotham-B', 'B', 'gotham-book.php');
        $this->AddFont('Gotham-M', '', 'gotham-medium.php');
        $this->AddFont('Helvetica', '', 'helvetica.php');

        $bordex = 10;
        //variables locales
        $presidium_orden = "1";
        $presidium_nombre = "Cesar Gibran Cadena Espinosa de los Monteros";
        $presidium_cargo = "Dirigente de Redes y Enlaces ";

        $this->Ln();


        $this->SetFont('Helvetica', '', 5); //font de cuando se va a rellenar la informacion
        $this->SetDrawColor(73, 168, 63);
        $this->SetTextColor(0);


        $largo = $this->getY();
        if (isset($evento->program)) {
            if (isset($evento->program->especialassistans)) {
                $asistentes_especiales = $evento->program->especialassistans;
                for ($i = 0; $i < count($asistentes_especiales); $i++) {

                    if ($i % 3 == 0) {
                        $cont = 1;
                        $this->setY($largo);
                        $y = $this->getY();
                        if ($asistentes_especiales[$i]->foto != null || $asistentes_especiales[$i]->foto != '') {
                            $this->Cell(40, 32, $asistentes_especiales[$i]->numero . $this->Image("http://smsem.org.mx/pregiras/uploads/" . $asistentes_especiales[$i]->foto . "", $this->GetX() + 7.5, $this->GetY(), 25, 30), 1, 0, 'C');
                        } else {
                            $this->Cell(40, 32, $asistentes_especiales[$i]->numero . $this->Image("http://smsem.org.mx/pregiras/img/fondo_mapa.png", $this->GetX() + 7.5, $this->GetY(), 25, 30), 1, 0, 'C');
                        }


                        $this->Ln();
                        $this->SetFont('Helvetica', 'B', 4.5); //font de cuando se va a rellenar la informacion
                        $this->Cell(5, 4, utf8_decode($asistentes_especiales[$i]->numero), "LBR", 0, 'C', 0);
                        $this->Cell(35, 4, utf8_decode($asistentes_especiales[$i]->nombre), "R", 0, 'C', 0);
                        $this->Ln();
                        $this->SetFont('Helvetica', '', 4.5); //font de cuando se va a rellenar la informacion 
                        $this->MultiCell(40, 5, utf8_decode($asistentes_especiales[$i]->cargo), "LBR", 'C', 0);
                        $largo = $this->getY();
                    } else {
                        $this->setXY((40 * $cont) + $bordex, $y);

                        if ($asistentes_especiales[$i]->foto  != null || $asistentes_especiales[$i]->foto != '') {
                            $this->Cell(40, 32, $asistentes_especiales[$i]->numero . $this->Image("http://smsem.org.mx/pregiras/uploads/" . $asistentes_especiales[$i]->foto . "", $this->GetX() + 7.5, $this->GetY(), 25, 30), 1, 0, 'C');
                        } else {
                            $this->Cell(40, 32, $asistentes_especiales[$i]->numero . $this->Image("http://smsem.org.mx/pregiras/img/fondo_mapa.png", $this->GetX() + 7.5, $this->GetY(), 25, 30), 1, 0, 'C');
                        }

                        $this->Ln();
                        $this->setX((40 * $cont) + $bordex);
                        $this->SetFont('Helvetica', 'B', 4.5); //font de cuando se va a rellenar la informacion
                        $this->Cell(5, 4, utf8_decode($asistentes_especiales[$i]->numero), "LBR", 0, 'C', 0);
                        $this->Cell(35, 4, utf8_decode($asistentes_especiales[$i]->nombre), "R", 0, 'C', 0);
                        $this->Ln();
                        $this->SetFont('Helvetica', '', 4.5); //font de cuando se va a rellenar la informacion
                        $this->setX((40 * $cont) + $bordex);
                        $this->MultiCell(40, 5, utf8_decode($asistentes_especiales[$i]->cargo), "LBR", 'C', 0);
                        $cont++;
                        $aux = $this->getY();
                        if ($largo <= $aux) {
                            $largo = $aux;
                        }
                    }
                }
            }
        }
    }

    function MultiCellBltArray($w, $h, $blt_array, $border = 0, $align = 'J', $fill = false) {
        if (!is_array($blt_array)) {
            die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
            exit;
        }

        //Save x
        $bak_x = $this->x;

        for ($i = 0; $i < sizeof($blt_array['text']); $i++) {
            //Get bullet width including margin
            $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin']) + $this->cMargin * 2;

            // SetX
            $this->SetX($bak_x);

            //Output indent
            if ($blt_array['indent'] > 0)
                $this->Cell($blt_array['indent']);

            //Output bullet
            $this->Cell($blt_width, $h, $blt_array['bullet'] . $blt_array['margin'], 0, '', $fill);

            //Output text
            $this->MultiCell($w - $blt_width, $h, $blt_array['text'][$i], $border, $align, $fill);

            //Insert a spacer between items if not the last item
            if ($i != sizeof($blt_array['text']) - 1)
                $this->Ln($blt_array['spacer']);

            //Increment bullet if it's a number
            if (is_numeric($blt_array['bullet']))
                $blt_array['bullet'] ++;
        }

        //Restore x
        $this->x = $bak_x;
    }

}

?>