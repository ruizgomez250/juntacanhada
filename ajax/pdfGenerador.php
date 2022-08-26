<?php
require('../fpdf184/fpdf.php');
require "../config/Conexion.php";
require '../fun/numerosAletras.php';




class PDF extends FPDF
{
private $spacio = 70;
private $izq=19;
    function getCiclo($valor)
    {
        switch ($valor) {
            case 1:
                # code...
                return 'Enero';
                break;
            case 2:
                # code...
                return 'Febrero';
                break;
            case 3:
                # code...
                return 'Marzo';
                break;
            case 4:
                # code...
                return 'Abril';
                break;
            case 5:
                # code...
                return 'Mayo';
                break;
            case 6:
                # code...
                return 'Junio';
                break;
            case 7:
                # code...
                return 'Julio';
                break;
            case 8:
                # code...
                return 'Agosto';
                break;
            case 9:
                # code...
                return 'Setiembre';
                break;
            case 10:
                # code...
                return 'Octubre';
                break;
            case 11:
                # code...
                return 'Noviembre';
                break;

            default:
                # code...
                return 'Diciembre';
                break;
        }
    }

    function Header()
    {
        // Logo
        $this->Image('../public/img/logocanhada.png', 20, 2, 50);
    }

    function datosHorizontal($datos, $nro)
    {
        // var_dump($datos);
        // die;
        $this->RoundedRect($this->izq, 30, 176, 33, 2, 'D');
        $this->Ln(20);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, utf8_decode('NRO USUARIO:'), 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(20, 10, utf8_decode($datos['id']), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 10, 'RUC/CI:', 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(20, 10, utf8_decode($datos['num_documento']), 0, 1, 'L');
        $this->Ln(-4);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, utf8_decode('RAZÓN SOCIAL:'), 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(80, 10, utf8_decode($datos['nombre']), 0, 1, 'L');
        $this->Ln(-4);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, utf8_decode('DIRECCIÓN:'), 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(100, 10, utf8_decode($datos['direccion']), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(30, 10, utf8_decode('NRO. ') . $nro, 0, 1, 'L');
        $this->SetFont('');
        $this->Ln(-4);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, 'ZONA:', 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(80, 10, utf8_decode($datos['zona']), 0, 1, 'L');
        $this->Ln(-4);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, utf8_decode('CATEGORÍA:'), 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(80, 10, utf8_decode($datos['categoria']), 0, 1, 'L');
    }


    function datosHorizontal2($datos, $nro)
    {
        // var_dump($datos);
        // die;  

        $this->Image('../public/img/logocanhada.png', 20, 158, 50, 24);
        $this->ln($this->spacio);

        $this->RoundedRect($this->izq, 186, 176, 33, 2, 'D');        
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, utf8_decode('NRO USUARIO:'), 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(20, 10, utf8_decode($datos['id']), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(20, 10, 'RUC/CI:', 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(20, 10, utf8_decode($datos['num_documento']), 0, 1, 'L');
        $this->Ln(-4);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, utf8_decode('RAZÓN SOCIAL:'), 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(80, 10, utf8_decode($datos['nombre']), 0, 1, 'L');
        $this->Ln(-4);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, utf8_decode('DIRECCIÓN:'), 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(100, 10, utf8_decode($datos['direccion']), 0, 0, 'L');
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(30, 10, utf8_decode('NRO. ') . $nro, 0, 1, 'L');
        $this->SetFont('');
        $this->Ln(-4);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, 'ZONA:', 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(80, 10, utf8_decode($datos['zona']), 0, 1, 'L');
        $this->Ln(-4);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(30, 10, utf8_decode('CATEGORÍA:'), 0, 0, 'L');
        $this->SetFont('');
        $this->Cell(80, 10, utf8_decode($datos['categoria']), 0, 1, 'L');
    }


    function tablaHorizontal($datosHorizontal, $nro)
    {
        //  $this->cabeceraHorizontal($cabeceraHorizontal);
        $this->datosHorizontal($datosHorizontal, $nro);
    }


    function tablaDetallecabecera($datos)
    {
        $this->RoundedRect($this->izq, 64, 176, 56, 2, 'D');
        $this->Ln(-2);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(10, 10, utf8_decode("CICLO:"), 0, 0, 'C');
        $this->SetFont('');
        $this->Cell(20, 10, $this->getCiclo($datos['mes']) . ' ' . $datos['anho'], 0, 0, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(30, 10, utf8_decode("PERIODO DE CONSUMO:"), 0, 0, 'C');
        $this->SetFont('');
        $this->Cell(40, 10, $datos['fecha_inicio'] . " | " . $datos['fecha_cierre'], 0, 0, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(10, 10, utf8_decode("EMISIÓN:"), 0, 0, 'C');
        $this->SetFont('');
        $this->Cell(20, 10, $datos['fechaemision'], 0, 0, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(18, 10, utf8_decode("VENCE:"), 0, 0, 'C');
        $this->SetFont('');
        $this->Cell(18, 10, $datos['fechavencimiento'], 0, 1, 'C');
        $this->SetFont('');
    }

    function tablaDetallecabecera2($datos)
    {
        $this->RoundedRect($this->izq, 220, 176, 56, 2, 'D');
        $this->Ln(-2);
        $this->Cell(10);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(10, 10, utf8_decode("CICLO:"), 0, 0, 'C');
        $this->SetFont('');
        $this->Cell(20, 10, $this->getCiclo($datos['mes']) . ' ' . $datos['anho'], 0, 0, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(30, 10, utf8_decode("PERIODO DE CONSUMO:"), 0, 0, 'C');
        $this->SetFont('');
        $this->Cell(40, 10, $datos['fecha_inicio'] . " | " . $datos['fecha_cierre'], 0, 0, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(10, 10, utf8_decode("EMISIÓN:"), 0, 0, 'C');
        $this->SetFont('');
        $this->Cell(20, 10, $datos['fechaemision'], 0, 0, 'C');
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(18, 10, utf8_decode("VENCE:"), 0, 0, 'C');
        $this->SetFont('');
        $this->Cell(18, 10, $datos['fechavencimiento'], 0, 1, 'C');
        $this->SetFont('');
    }

    function tablaDetalle($datos)
    {
        $this->Ln(-2);

        $this->Cell(5);
        $this->SetFont('Arial', 'B', 5);
        $this->Cell(14, 10, utf8_decode("LECTURA\n ANTERIOR"), 1, 0, 'C');
        $this->Cell(14, 10, utf8_decode("LECTURA\n ACTUAL"), 1, 0, 'C');
        $this->Cell(14, 10, utf8_decode("CONSUMO\n TOTAL"), 1, 0, 'C');
        $this->Cell(14, 10, utf8_decode("CONSUMO\n MINÍMO"), 1, 0, 'C');
        $this->Cell(14, 10, utf8_decode("CONSUMO\n EXCEDENTE"), 1, 0, 'C');
        $this->Cell(52, 10, utf8_decode("CONCEPTO"), 1, 0, 'C');
        $this->Cell(18, 10, utf8_decode("EXENTAS"), 1, 0, 'C');
        $this->Cell(18, 10, utf8_decode("5%"), 1, 0, 'C');
        $this->Cell(18, 10, utf8_decode("10%"), 1, 1, 'C');
        $this->SetFont('');
    }


    function tablaDetalle2($datos)
    {
        $this->Ln(-2);

        $this->Cell(5);
        $this->SetFont('Arial', 'B', 5);
        $this->Cell(14, 10, utf8_decode("LECTURA\n ANTERIOR"), 1, 0, 'C');
        $this->Cell(14, 10, utf8_decode("LECTURA\n ACTUAL"), 1, 0, 'C');
        $this->Cell(14, 10, utf8_decode("CONSUMO\n TOTAL"), 1, 0, 'C');
        $this->Cell(14, 10, utf8_decode("CONSUMO\n MINÍMO"), 1, 0, 'C');
        $this->Cell(14, 10, utf8_decode("CONSUMO\n EXCEDENTE"), 1, 0, 'C');
        $this->Cell(52, 10, utf8_decode("CONCEPTO"), 1, 0, 'C');
        $this->Cell(18, 10, utf8_decode("EXENTAS"), 1, 0, 'C');
        $this->Cell(18, 10, utf8_decode("5%"), 1, 0, 'C');
        $this->Cell(18, 10, utf8_decode("10%"), 1, 1, 'C');
        $this->SetFont('');
    }
    function tablaDetalleconsumo($datos)
    {
        //$this-[]>Ln(-2);
        $lecAct = $datos['lectura'];
        $lecAnt = $datos['lectura_ant'];
        $consumo = ($lecAnt > 0 ? $lecAct - $lecAnt : $lecAct);
        $min = 12;
        $consumoexedente = ($consumo > $min ? $consumo - $min : 0);

        $this->Cell(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(14, 10, $lecAnt, 1, 0, 'C');
        $this->Cell(14, 10, $lecAct, 1, 0, 'C');
        $this->Cell(14, 10,  $consumo, 1, 0, 'C');
        $this->Cell(14, 10, $min, 1, 0, 'C');
        $this->Cell(14, 10,  $consumoexedente, 1, 0, 'C');
        $this->SetFont('');
    }


    function tablaDetalleconsumox($datos)
    {
        //$this-[]>Ln(-2);
        $lecAct = $datos['lectura'];
        $lecAnt = $datos['lectura_ant'];
        $consumo = ($lecAnt > 0 ? $lecAct - $lecAnt : $lecAct);
        $min = 12;
        $consumoexedente = ($consumo > $min ? $consumo - $min : 0);

        $this->Cell(5);
        $this->SetFont('Arial', '', 8);
        $this->Cell(14, 10, $lecAnt, 1, 0, 'C');
        $this->Cell(14, 10, $lecAct, 1, 0, 'C');
        $this->Cell(14, 10,  $consumo, 1, 0, 'C');
        $this->Cell(14, 10, $min, 1, 0, 'C');
        $this->Cell(14, 10,  $consumoexedente, 1, 0, 'C');
        $this->SetFont('');
    }


    function tablaDetalleconsumo2($datos)
    {
        $filas = mysqli_num_rows($datos);
        $i = 0;
        $total = 0;
        $this->SetFont('Arial', '', 7);
        while ($reg = $datos->fetch_object()) {
            $this->Cell(52, 5, utf8_decode($reg->concepto), 0, 0, 'C');
            $this->Cell(18, 5, number_format($reg->precio_venta, 2, ',', '.'), 0, 0, 'R');
            $this->Cell(18, 5, utf8_decode(""), 0, 0, 'C');
            $this->Cell(18, 5, utf8_decode(""), 0, 1, 'C');
            $total = $total + $reg->precio_venta;
            if ($i < ($filas - 1)) {
                $this->Cell(75);
            }
            $i += 1;
            //if para contar salto de linea
            if($i==1){
                $this->spacio =70; 
            }else if($i == 2){
                $this->spacio = 75; 
            }else if($i == 3){
                $this->spacio = 70; 
            }else if($i == 4){
                $this->spacio = 65; 
            }else if($i == 5){
                $this->spacio = 60; 
            }
            
        }
        $this->SetFont('');
        $letras = strtoupper(convertir($total));
        $this->Cell(5);
        $this->Cell(28, 20, utf8_decode("TOTAL A PAGAR:"), 0, 0, 'L');
        $this->Cell(130, 20, utf8_decode($letras), 0, 0, 'L');
        $this->Cell(18, 20, number_format($total, 2, ',', '.'), 0, 1, 'R');
    }

    function tablaDetalleconsumox2($dato)
    {
     
        $filas = mysqli_num_rows($dato);
        $i = 0;
        $total = 0;
        $this->SetFont('Arial', '', 7);
        while ($reg = $dato->fetch_object()) {
            $this->Cell(52, 5, utf8_decode($reg->concepto), 0, 0, 'C');
            $this->Cell(18, 5, number_format($reg->precio_venta, 2, ',', '.'), 0, 0, 'R');
            $this->Cell(18, 5, utf8_decode(""), 0, 0, 'C');
            $this->Cell(18, 5, utf8_decode(""), 0, 1, 'C');
            $total = $total + $reg->precio_venta;
            if ($i < ($filas - 1)) {
                $this->Cell(75);
            }
            $i += 1;
        }
        $this->SetFont('');
        $letras = strtoupper(convertir($total));
        $this->Cell(5);
        $this->Cell(28, 20, utf8_decode("TOTAL A PAGAR:"), 0, 0, 'L');
        $this->Cell(130, 20, utf8_decode($letras), 0, 0, 'L');
        $this->Cell(18, 20, number_format($total, 2, ',', '.'), 0, 1, 'R');
    }


    //**********************************************************************************************************************************
    function CellFit($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $scale = false, $force = true)
    {
        //Get string width
        $str_width = $this->GetStringWidth($txt);

        //Calculate ratio to fit cell
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $ratio = ($w - $this->cMargin * 2) / $str_width;

        $fit = ($ratio < 1 || ($ratio > 1 && $force));
        if ($fit) {
            if ($scale) {
                //Calculate horizontal scaling
                $horiz_scale = $ratio * 100.0;
                //Set horizontal scaling
                $this->_out(sprintf('BT %.2F Tz ET', $horiz_scale));
            } else {
                //Calculate character spacing in points
                $char_space = ($w - $this->cMargin * 2 - $str_width) / max($this->MBGetStringLength($txt) - 1, 1) * $this->k;
                //Set character spacing
                $this->_out(sprintf('BT %.2F Tc ET', $char_space));
            }
            //Override user alignment (since text will fill up cell)
            $align = '';
        }

        //Pass on to Cell method
        $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);

        //Reset character spacing/horizontal scaling
        if ($fit)
            $this->_out('BT ' . ($scale ? '100 Tz' : '0 Tc') . ' ET');
    }

    function CellFitSpace($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        $this->CellFit($w, $h, $txt, $border, $ln, $align, $fill, $link, false, false);
    }

    //Patch to also work with CJK double-byte text
    function MBGetStringLength($s)
    {
        if ($this->CurrentFont['type'] == 'Type0') {
            $len = 0;
            $nbbytes = strlen($s);
            for ($i = 0; $i < $nbbytes; $i++) {
                if (ord($s[$i]) < 128)
                    $len++;
                else {
                    $len++;
                    $i++;
                }
            }
            return $len;
        } else
            return strlen($s);
    }
    //**********************************************************************************************

    function RoundedRect($x, $y, $w, $h, $r, $style = '', $angle = '1234')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' or $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2f %.2f m', ($x + $r) * $k, ($hp - $y) * $k));

        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - $y) * $k));
        if (strpos($angle, '2') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $y) * $k));
        else
            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($angle, '3') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2f %.2f l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($angle, '4') === false)
            $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($angle, '1') === false) {
            $this->_out(sprintf('%.2f %.2f l', ($x) * $k, ($hp - $y) * $k));
            $this->_out(sprintf('%.2f %.2f l', ($x + $r) * $k, ($hp - $y) * $k));
        } else
            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2f %.2f %.2f %.2f %.2f %.2f c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }



    function VCell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false)
    {
        //Output a cell
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
            //Automatic page break
            $x = $this->x;
            $ws = $this->ws;
            if ($ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation, $this->CurPageSize);
            $this->x = $x;
            if ($ws > 0) {
                $this->ws = $ws;
                $this->_out(sprintf('%.3F Tw', $ws * $k));
            }
        }
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $s = '';
        // begin change Cell function 
        if ($fill || $border > 0) {
            if ($fill)
                $op = ($border > 0) ? 'B' : 'f';
            else
                $op = 'S';
            if ($border > 1) {
                $s = sprintf(
                    'q %.2F w %.2F %.2F %.2F %.2F re %s Q ',
                    $border,
                    $this->x * $k,
                    ($this->h - $this->y) * $k,
                    $w * $k,
                    -$h * $k,
                    $op
                );
            } else
                $s = sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
        }
        if (is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (is_int(strpos($border, 'L')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'l')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);

            if (is_int(strpos($border, 'T')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
            else if (is_int(strpos($border, 't')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);

            if (is_int(strpos($border, 'R')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'r')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);

            if (is_int(strpos($border, 'B')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'b')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
        }
        if (trim($txt) != '') {
            $cr = substr_count($txt, "\n");
            if ($cr > 0) { // Multi line
                $txts = explode("\n", $txt);
                $lines = count($txts);
                for ($l = 0; $l < $lines; $l++) {
                    $txt = $txts[$l];
                    $w_txt = $this->GetStringWidth($txt);
                    if ($align == 'U')
                        $dy = $this->cMargin + $w_txt;
                    elseif ($align == 'D')
                        $dy = $h - $this->cMargin;
                    else
                        $dy = ($h + $w_txt) / 2;
                    $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                    if ($this->ColorFlag)
                        $s .= 'q ' . $this->TextColor . ' ';
                    $s .= sprintf(
                        'BT 0 1 -1 0 %.2F %.2F Tm (%s) Tj ET ',
                        ($this->x + .5 * $w + (.7 + $l - $lines / 2) * $this->FontSize) * $k,
                        ($this->h - ($this->y + $dy)) * $k,
                        $txt
                    );
                    if ($this->ColorFlag)
                        $s .= ' Q ';
                }
            } else { // Single line
                $w_txt = $this->GetStringWidth($txt);
                $Tz = 100;
                if ($w_txt > $h - 2 * $this->cMargin) {
                    $Tz = ($h - 2 * $this->cMargin) / $w_txt * 100;
                    $w_txt = $h - 2 * $this->cMargin;
                }
                if ($align == 'U')
                    $dy = $this->cMargin + $w_txt;
                elseif ($align == 'D')
                    $dy = $h - $this->cMargin;
                else
                    $dy = ($h + $w_txt) / 2;
                $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                if ($this->ColorFlag)
                    $s .= 'q ' . $this->TextColor . ' ';
                $s .= sprintf(
                    'q BT 0 1 -1 0 %.2F %.2F Tm %.2F Tz (%s) Tj ET Q ',
                    ($this->x + .5 * $w + .3 * $this->FontSize) * $k,
                    ($this->h - ($this->y + $dy)) * $k,
                    $Tz,
                    $txt
                );
                if ($this->ColorFlag)
                    $s .= ' Q ';
            }
        }
        // end change Cell function 
        if ($s)
            $this->_out($s);
        $this->lasth = $h;
        if ($ln > 0) {
            //Go to next line
            $this->y += $h;
            if ($ln == 1)
                $this->x = $this->lMargin;
        } else
            $this->x += $w;
    }

    function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
    {
        //Output a cell
        $k = $this->k;
        if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
            //Automatic page break
            $x = $this->x;
            $ws = $this->ws;
            if ($ws > 0) {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            $this->AddPage($this->CurOrientation, $this->CurPageSize);
            $this->x = $x;
            if ($ws > 0) {
                $this->ws = $ws;
                $this->_out(sprintf('%.3F Tw', $ws * $k));
            }
        }
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $s = '';
        // begin change Cell function
        if ($fill || $border > 0) {
            if ($fill)
                $op = ($border > 0) ? 'B' : 'f';
            else
                $op = 'S';
            if ($border > 1) {
                $s = sprintf(
                    'q %.2F w %.2F %.2F %.2F %.2F re %s Q ',
                    $border,
                    $this->x * $k,
                    ($this->h - $this->y) * $k,
                    $w * $k,
                    -$h * $k,
                    $op
                );
            } else
                $s = sprintf('%.2F %.2F %.2F %.2F re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, -$h * $k, $op);
        }
        if (is_string($border)) {
            $x = $this->x;
            $y = $this->y;
            if (is_int(strpos($border, 'L')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'l')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);

            if (is_int(strpos($border, 'T')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
            else if (is_int(strpos($border, 't')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);

            if (is_int(strpos($border, 'R')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'r')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);

            if (is_int(strpos($border, 'B')))
                $s .= sprintf('%.2F %.2F m %.2F %.2F l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
            else if (is_int(strpos($border, 'b')))
                $s .= sprintf('q 2 w %.2F %.2F m %.2F %.2F l S Q ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
        }
        if (trim($txt) != '') {
            $cr = substr_count($txt, "\n");
            if ($cr > 0) { // Multi line
                $txts = explode("\n", $txt);
                $lines = count($txts);
                for ($l = 0; $l < $lines; $l++) {
                    $txt = $txts[$l];
                    $w_txt = $this->GetStringWidth($txt);
                    if ($align == 'R')
                        $dx = $w - $w_txt - $this->cMargin;
                    elseif ($align == 'C')
                        $dx = ($w - $w_txt) / 2;
                    else
                        $dx = $this->cMargin;

                    $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                    if ($this->ColorFlag)
                        $s .= 'q ' . $this->TextColor . ' ';
                    $s .= sprintf(
                        'BT %.2F %.2F Td (%s) Tj ET ',
                        ($this->x + $dx) * $k,
                        ($this->h - ($this->y + .5 * $h + (.7 + $l - $lines / 2) * $this->FontSize)) * $k,
                        $txt
                    );
                    if ($this->underline)
                        $s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
                    if ($this->ColorFlag)
                        $s .= ' Q ';
                    if ($link)
                        $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
                }
            } else { // Single line
                $w_txt = $this->GetStringWidth($txt);
                $Tz = 100;
                if ($w_txt > $w - 2 * $this->cMargin) { // Need compression
                    $Tz = ($w - 2 * $this->cMargin) / $w_txt * 100;
                    $w_txt = $w - 2 * $this->cMargin;
                }
                if ($align == 'R')
                    $dx = $w - $w_txt - $this->cMargin;
                elseif ($align == 'C')
                    $dx = ($w - $w_txt) / 2;
                else
                    $dx = $this->cMargin;
                $txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
                if ($this->ColorFlag)
                    $s .= 'q ' . $this->TextColor . ' ';
                $s .= sprintf(
                    'q BT %.2F %.2F Td %.2F Tz (%s) Tj ET Q ',
                    ($this->x + $dx) * $k,
                    ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k,
                    $Tz,
                    $txt
                );
                if ($this->underline)
                    $s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
                if ($this->ColorFlag)
                    $s .= ' Q ';
                if ($link)
                    $this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
            }
        }
        // end change Cell function
        if ($s)
            $this->_out($s);
        $this->lasth = $h;
        if ($ln > 0) {
            //Go to next line
            $this->y += $h;
            if ($ln == 1)
                $this->x = $this->lMargin;
        } else
            $this->x += $w;
    }

    function getCabecera($id)
    {
        $sql = "SELECT va.id
        ,va.estado 
        ,num_extracto
        ,va.fechavencimiento 
        ,va.fecha_inicio
        ,va.fecha_cierre
        ,va.fechaemision 
        ,va.idcliente 
        ,concat_ws(' ',p.nombre,p.apellido) nombre 
        ,l.fecha_lectura
        ,l.lectura
        ,l.lectura_ant 
        ,l.mesciclo mes
        ,l.anhociclo anho
        FROM `venta_agua` va 
        inner join lectura l on l.id = va.idlectura 
        inner join cliente c on c.id = va.idcliente 
        inner join persona p on p.idpersona = c.id_persona
        left join zona z on z.id = c.id_zona
        WHERE va.id = (select max(id) id from venta_agua WHERE idcliente='$id')
        ORDER BY c.id_zona
        ";
        return ejecutarConsultaSimpleFila($sql);        
    }

    function getDetalleVenta($idventa)
    {
        $sql = "SELECT `idventa`
                , `concepto`
                ,`precio_venta` 
                FROM `venta_detalle` 
                WHERE `idventa`='$idventa'";
        return ejecutarConsulta($sql);
    }

    function getDatosCliente($nrousuario)
    {
        $sql = "SELECT c.id 
        ,CONCAT_ws(' ',p.nombre,p.apellido) nombre 
        ,p.num_documento 
        ,p.direccion
        ,h.medidor
        ,cu.descripcion categoria
        ,z.descripcion zona 
        ,COALESCE(va.id,0) idventaagua        
        FROM `cliente` c 
        LEFT JOIN persona p on p.idpersona = c.id_persona 
        LEFT JOIN categoria_usuario cu on cu.id = c.id_categoria 
        left join hidrometro h on h.idcliente = c.id 
        left join venta_agua va on va.idcliente = c.id
        left join zona z on z.id = c.id_zona
        where c.estado = 1  AND c.id = '$nrousuario'order by nombre asc";
        return ejecutarConsultaSimpleFila($sql);
    }


    function getNroCliente()
    {
        $sql = "SELECT DISTINCT  va.`idcliente` 
        FROM `venta_agua` va 
        inner join cliente c on c.id = va.idcliente
        WHERE va.`estado` = 1
        ORDER BY c.id_zona,c.orden ASC";
        return ejecutarConsulta($sql);
    }

    function getCliente()
    {
        $sql = "SELECT max(`id`) id, `idcliente` FROM `venta_agua` WHERE `estado` = 1";
        return ejecutarConsulta($sql);
    }


} // FIN Class PDF
