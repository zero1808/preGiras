<?php
namespace App\Http\Controllers;

//require('MultiCellBlt2.php');
//require('fpdf18/fpdf.php');
use FPDF;
class Ficha2 extends  \fpdf\FPDF  {

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
    function Contenido($fotoresp) {
    	//seteamos el margen del contenido
    	$this->SetMargins(10,10,151.5);

    	//declaramos las fuentes a usar o tentativamente a usar ya que no sabemos cual es la original
	    $this->AddFont('Gotham-B','','gotham-book.php');
	    $this->AddFont('Gotham-B','B','gotham-book.php');
	    $this->AddFont('Gotham-M','','gotham-medium.php');
	    $this->AddFont('Helvetica','','helvetica.php');
        
        $bordex=10;
        //variables locales
        $presidium_orden="1";
        $presidium_nombre="Cesar Gibran Cadena Espinosa de los Monteros";
        $presidium_cargo="Dirigente de Redes y Enlaces ";

        $this->Ln();


                $this->SetFont('Helvetica', '', 5); //font de cuando se va a rellenar la informacion
                $this->SetDrawColor(73, 168, 63);
                $this->SetTextColor(0);
        
 
                $largo=$this->getY();
                for($i=0;$i<=7;$i++){

                    if ($i % 3 == 0) {
                        $cont=1;
                        $this->setY( $largo);
                         $y=$this->getY(); 
                        $this->Cell(40,32,$presidium_orden.$this->Image($fotoresp, $this->GetX()+7.5, $this->GetY(), 25,30),1,0,'C');
                        $this->Ln();
                        $this->SetFont('Helvetica', 'B', 4.5); //font de cuando se va a rellenar la informacion
                        $this->Cell(5, 4,utf8_decode("1"), "LBR",0,  'C', 0);
                        $this->Cell(35, 4,utf8_decode("Ing Cesar Gibran Cadena Espinosa"), "R",0,  'C', 0);
                        $this->Ln(); 
                         $this->SetFont('Helvetica', '', 4.5); //font de cuando se va a rellenar la informacion 
                        $this->MultiCell(40, 5,utf8_decode("Dirigente de redes y Enlaces Comite Municipal PRI Metepec"), "LBR",  'C', 0);
                        $largo=$this->getY();
                                    }
                    else{
                         $this->setXY((40* $cont)+$bordex,$y);
                        $this->Cell(40,32,$presidium_orden.$this->Image($fotoresp, $this->GetX()+7.5, $this->GetY(), 25,30),1,0,'C');
                        $this->Ln();
                         $this->setX((40* $cont)+$bordex);
                          $this->SetFont('Helvetica', 'B', 4.5); //font de cuando se va a rellenar la informacion
                        $this->Cell(5, 4,utf8_decode("1"), "LBR",0,  'C', 0);
                        $this->Cell(35, 4,utf8_decode("Ing Cesar Gibran "), "R",0,  'C', 0);
                        $this->Ln();
                        $this->SetFont('Helvetica', '', 4.5); //font de cuando se va a rellenar la informacion
                         $this->setX((40* $cont)+$bordex);  
                        $this->MultiCell(40, 5,utf8_decode("Dirigente de redes y Enlaces Comite Municipal PRI Metepec"), "LBR",  'C', 0);
                        $cont++;
                        $aux=$this->getY();
                        if ($largo<=$aux){
                            $largo=$aux;
                        }


                    }

                }

        
    }
}

?>