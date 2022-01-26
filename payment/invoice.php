<?php
require('../utils/fpdf/fpdf.php');
define('POUND', chr(128));

class Invoice extends FPDF
{
    var $columns;
    var $format;
    var $angle = 0;
    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));

        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }

    function Rotate($angle, $x = -1, $y = -1)
    {
        if ($x == -1)
            $x = $this->x;
        if ($y == -1)
            $y = $this->y;
        if ($this->angle != 0)
            $this->_out('Q');
        $this->angle = $angle;
        if ($angle != 0) {
            $angle *= M_PI / 180;
            $c = cos($angle);
            $s = sin($angle);
            $cx = $x * $this->k;
            $cy = ($this->h - $y) * $this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm', $c, $s, -$s, $c, $cx, $cy, -$cx, -$cy));
        }
    }

    function _endpage()
    {
        if ($this->angle != 0) {
            $this->angle = 0;
            $this->_out('Q');
        }
        parent::_endpage();
    }

    // public functions
    function sizeOfText($text, $width)
    {
        $index    = 0;
        $nb_lines = 0;
        $loop     = TRUE;
        while ($loop) {
            $pos = strpos($text, "\n");
            if (!$pos) {
                $loop  = FALSE;
                $line = $text;
            } else {
                $line  = substr($text, $index, $pos);
                $text = substr($text, $pos + 1);
            }
            $length = floor($this->GetStringWidth($line));
            $res = 1 + floor($length / $width);
            $nb_lines += $res;
        }
        return $nb_lines;
    }
    // Company
    function addCompany($name, $address)
    {
        $x1 = 10;
        $y1 = 40;
        //Positioning at the bottom
        $this->SetXY($x1, $y1);
        $this->SetFont('Arial', 'B', 12);
        $length = $this->GetStringWidth($name);
        $this->Cell($length, 2, $name);
        $this->SetXY($x1, $y1 + 4);
        $this->SetFont('Arial', '', 10);
        $length = $this->GetStringWidth($address);
        //Company contact details
        $line = $this->sizeOfText($address, $length);
        $this->MultiCell($length, 4, $address);
    }
    function addDate($date)
    {
        $r1  = $this->w - 59;
        $r2  = $r1 + 26;
        $y1  = 17;
        $y2  = $y1;
        $mid = $y1 + ($y2 / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2, 'D');
        $this->Line($r1, $mid, $r2, $mid);
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(10, 5, "DATE", 0, 0, "C");
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
        $this->SetFont("Arial", "", 10);
        $this->Cell(10, 5, $date, 0, 0, "C");
    }

    function addClient($ref)
    {
        $r1  = $this->w - 31;
        $r2  = $r1 + 19;
        $y1  = 17;
        $y2  = $y1;
        $mid = $y1 + ($y2 / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2, 'D');
        $this->Line($r1, $mid, $r2, $mid);
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(10, 5, "CLIENT", 0, 0, "C");
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
        $this->SetFont("Arial", "", 10);
        $this->Cell(10, 5, $ref, 0, 0, "C");
    }
    function addPageNumber($page)
    {
        $r1  = $this->w - 80;
        $r2  = $r1 + 19;
        $y1  = 17;
        $y2  = $y1;
        $mid = $y1 + ($y2 / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2, 'D');
        $this->Line($r1, $mid, $r2, $mid);
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 3);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(10, 5, "PAGE", 0, 0, "C");
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 9);
        $this->SetFont("Arial", "", 10);
        $this->Cell(10, 5, $page, 0, 0, "C");
    }

    // Client address
    function addClientAddress($name, $address)
    {
        $r1     = $this->w - 80;
        $y1     = 40;
         $this->SetXY($r1, $y1);
        $this->SetFont('Arial', 'B', 12);
        $length = $this->GetStringWidth($name);
        $this->Cell($length, 2, $name);
        $this->SetXY($r1, $y1 + 4);
        $this->SetFont('Arial', '', 10);
        $length = $this->GetStringWidth($address);
        //Client contact details
        $line = $this->sizeOfText($address, $length);
        $this->MultiCell($length, 4, $address);
    }

    // Mode of payment
    function addPaymentMode($mode)
    {
        $r1  = 10;
        $r2  = $r1 + 60;
        $y1  = 80;
        $y2  = $y1 + 10;
        $mid = $y1 + (($y2 - $y1) / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
        $this->Line($r1, $mid, $r2, $mid);
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 1);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(10, 4, "Payment Mode", 0, 0, "C");
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 5);
        $this->SetFont("Arial", "", 10);
        $this->Cell(10, 5, $mode, 0, 0, "C");
    }
    // Invoice date
    function addInvoiceDate($date)
    {
        $r1  = 80;
        $r2  = $r1 + 40;
        $y1  = 80;
        $y2  = $y1 + 10;
        $mid = $y1 + (($y2 - $y1) / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
        $this->Line($r1, $mid, $r2, $mid);
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 1);
        $this->SetFont("Arial", "B", 10);
        $this->Cell(10, 4, "Invoice Date", 0, 0, "C");
        $this->SetXY($r1 + ($r2 - $r1) / 2 - 5, $y1 + 5);
        $this->SetFont("Arial", "", 10);
        $this->Cell(10, 5, $date, 0, 0, "C");
    }

    // Transaction ID
    function addTxnID($txn)
    {
        $this->SetFont("Arial", "B", 10);
        $r1  = $this->w - 80;
        $r2  = $r1 + 70;
        $y1  = 80;
        $y2  = $y1 + 10;
        $mid = $y1 + (($y2 - $y1) / 2);
        $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2 - $y1), 2.5, 'D');
        $this->Line($r1, $mid, $r2, $mid);
        $this->SetXY($r1 + 16, $y1 + 1);
        $this->Cell(40, 4, "Transaction ID", '', '', "C");
        $this->SetFont("Arial", "", 10);
        $this->SetXY($r1 + 16, $y1 + 5);
        $this->Cell(40, 5, $txn, '', '', "C");
    }
    function addCols($tab)
    {
        global $columns;

        $r1  = 10;
        $r2  = $this->w - ($r1 * 2);
        $y1  = 100;
        $y2  = $this->h - 50 - $y1;
        $this->SetXY($r1, $y1);
        $this->Rect($r1, $y1, $r2, $y2, "D");
        $this->Line($r1, $y1 + 6, $r1 + $r2, $y1 + 6);
        $colX = $r1;
        $columns = $tab;
        foreach ($tab as $lib => $pos) {
            $this->SetXY($colX, $y1 + 2);
            $this->Cell($pos, 1, $lib, 0, 0, "C");
            $colX += $pos;
            $this->Line($colX, $y1, $colX, $y1 + $y2);
        }
    }

    function addLineFormat($tab)
    {
        global $format, $columns;

        foreach ($columns as $lib => $pos) {
            if (isset($tab["$lib"]))
                $format[$lib] = $tab["$lib"];
        }
    }

    function lineVert($tab)
    {
        global $columns;

        reset($columns);
        $maxSize = 0;
        foreach ($columns as $lib => $pos) {
            $text = $tab[$lib];
            $longCell  = $pos - 2;
            $size = $this->sizeOfText($text, $longCell);
            if ($size > $maxSize)
                $maxSize = $size;
        }
        return $maxSize;
    }

    function addLine($line, $tab)
    {
        global $columns, $format;

        $ordered     = 10;
        $maxSize      = $line;

        reset($columns);
        foreach ($columns as $lib => $pos) {
            $longCell  = $pos - 2;
            $text     = $tab[$lib];
            $formText  = $format[$lib];
            $this->SetXY($ordered, $line - 1);
            $this->MultiCell($longCell, 4, $text, 0, $formText);
            if ($maxSize < ($this->GetY()))
                $maxSize = $this->GetY();
            $ordered += $pos;
        }
        return ($maxSize - $line);
    }

    // add a watermark
    function watermark($texte)
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(203, 203, 203);
        $this->Rotate(45, 55, 190);
        $this->Text(55, 190, $texte);
        $this->Rotate(0);
        $this->SetTextColor(0, 0, 0);
    }
}
