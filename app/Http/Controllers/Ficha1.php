<?php
namespace App\Http\Controllers;

//require('MultiCellBlt2.php');
//require('fpdf18/fpdf.php');
use FPDF;
class Ficha1 extends \fpdf\FPDF  {

    function Header() {
    	//indicamos la font a utilizar para el titulo
        $this->AddFont('Gotham-M','B','gotham-medium.php'); 
        //seteamos el titulo que aparecera en el navegador 
        $this->SetTitle(utf8_decode('Toma de Protesta Candidato PVEM'));

        //linea que simplemente me marca la mitad de la hoja como referencia
    	$this->Line(139.5,$this->getY(),140,250);

    	//bajamos la cabecera 13 espacios
        $this->Ln(10);
        //seteamos la fuente, el color de texto, y el color de fondo de el titulo
        $this->SetFont('Gotham-M','B',11);
        $this->SetTextColor(255,255,255);
        $this->SetFillColor(73, 168, 63);
        //escribimos titulo
        $this->Cell(0,5,utf8_decode('Toma de Protesta Candidato PVEM'),0,0,'C',1); //el completo es 279 bueno 280 /2 = 140  si seran 10 de cada borde, entonces 120

        $this->Ln();
    }
    function Contenido($imagenlogo) {
    	//seteamos el margen del contenido
    	$this->SetMargins(10,10,151.5);

    	//declaramos las fuentes a usar o tentativamente a usar ya que no sabemos cual es la original
	    $this->AddFont('Gotham-B','','gotham-book.php');
	    $this->AddFont('Gotham-B','B','gotham-book.php');
	    $this->AddFont('Gotham-M','','gotham-medium.php');
	    $this->AddFont('Helvetica','','helvetica.php');

        //variables locales
        $numero_de_presidiums=6;

        $presidium_orden="1";
        $presidium_nombre="Cesar Gibran Cadena Espinosa de los Monteros";
        $presidium_cargo="Dirigente de Redes y Enlaces ";

    	//la imagen del PVEM
    	$this->Image($imagenlogo, $this->GetX()+10, $this->GetY()+10, 100,40);

    	//el primer espacio
    	$this->Ln(3);
        $this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0,0,0); //color gris para las letras
        $this->Cell(35, 5,utf8_decode("Distribución Logística:"), 0,0, 'C', 1);

        $this->setY($this->GetY()+45);
        $this->Ln();
        $this->SetFillColor(231, 234,243); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetFont('Helvetica', '', 9); //font de cuando se va a rellenar la informacion
        $this->SetTextColor(0,0,0); //color gris para las letras
        $this->Cell(40, 5,utf8_decode("Presídium (Primera Fila):"), 0,0, 'C', 1);

        $this->Ln(); 
        $this->Ln(); 

        $this->SetFillColor(160,68,68); //color de fondo donde se va a rellenar los campos (como azul claro)
        $this->SetTextColor(255); //color gris para las letras
               $tamano= ($numero_de_presidiums*7.5)/2;
                $this->setX((120/2)-$tamano);

                if (  ($numero_de_presidiums) % 2 ==1){ //es impar
                    $candidato=($numero_de_presidiums/2)+.5;
                }else{
                     $candidato=($numero_de_presidiums/2)+1;
                }

                    for($i=0;$i<=$numero_de_presidiums;$i++){

                        if ( ($i+1) == $candidato ){
                        $this->Cell(7, 7,utf8_decode("*"), 1, 0, 'C', 1);
                        }else{
                         $this->Cell(7, 7,utf8_decode(""), 1, 0, 'C', 1);   
                        }
                    }
                    $this->Ln(); 
                    $this->Ln(5);  


                //CONFIGURACION DE COLOR VERDE CON BLANCO
                $this->SetFont('Gotham-B','',6.5);
                $this->SetFillColor(73, 168, 63);
                $this->SetTextColor(255);
                $this->Cell(9, 5,utf8_decode("Orden"), 'LR', 0, 'C', 1);
                $this->Cell(55, 5,utf8_decode("Nombre"), 'LR', 0, 'C', 1);
                $this->Cell(0, 5,utf8_decode("Cargo"), 'LR', 0, 'C', 1);


                $this->Ln();    


                //CONFIGURACION SIN COLOR de fondo
                $this->SetFont('Helvetica', '', 6.5); //font de cuando se va a rellenar la informacion
                $this->SetFillColor(255, 255, 255);
                $this->SetTextColor(0);


                //ESTO ES LO QUE IRIA EN UN FOR
                for($i=0;$i<=7;$i++){
                   
                    $this->Cell(9, 5,utf8_decode($presidium_orden), 1, 0, 'C', 1);
                    $this->Cell(55, 5,utf8_decode($presidium_nombre), 1, 0, 'C', 1);
                    $this->MultiCell(0, 5,utf8_decode($presidium_cargo), 1,  'C', 1);
                    $this->Ln(1);
                 }      
        
    }
        function MultiCellBltArray($w, $h, $blt_array, $border=0, $align='J', $fill=false)
    {
        if (!is_array($blt_array))
        {
            die('MultiCellBltArray requires an array with the following keys: bullet,margin,text,indent,spacer');
            exit;
        }
                
        //Save x
        $bak_x = $this->x;
        
        for ($i=0; $i<sizeof($blt_array['text']); $i++)
        {
            //Get bullet width including margin
            $blt_width = $this->GetStringWidth($blt_array['bullet'] . $blt_array['margin'])+$this->cMargin*2;
            
            // SetX
            $this->SetX($bak_x);
            
            //Output indent
            if ($blt_array['indent'] > 0)
                $this->Cell($blt_array['indent']);
            
            //Output bullet
            $this->Cell($blt_width,$h,$blt_array['bullet'] . $blt_array['margin'],0,'',$fill);
            
            //Output text
            $this->MultiCell($w-$blt_width,$h,$blt_array['text'][$i],$border,$align,$fill);
            
            //Insert a spacer between items if not the last item
            if ($i != sizeof($blt_array['text'])-1)
                $this->Ln($blt_array['spacer']);
            
            //Increment bullet if it's a number
            if (is_numeric($blt_array['bullet']))
                $blt_array['bullet']++;
        }
    
        //Restore x
        $this->x = $bak_x;
    }
}


?>