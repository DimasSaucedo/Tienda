<?php

use App\Models\Cat_Menu;
use App\Models\Cat_SubMenu;
use App\Models\View_notas_detalle;
use Illuminate\Support\Facades\Auth;

function menu()
{
    if (Auth::check()) {
        $Menu = Cat_Menu::where('estado', 1)->get();
    } 


    return $Menu;
}

function submenu($idmenu)
{
    $subMenu = Cat_SubMenu::where('id_menu', $idmenu)->get();
    return $subMenu;
}

function redondear($valor)
{
    $mod = $valor % 50;
    if ($mod == 0) {
        return $valor;
    } elseif ($mod <= 25) {
        return $valor - $mod + 50;
    } else {
        return $valor - $mod + 50;
    }
}

function formatearNumero($number)
{
    if ($number != null) {
        return '$' . number_format($number, 2, '.', ',');
    } else {
        return '$ 0.00';
    }
}

function metodo_de_pago($pago)
{
    $nombre = "";
    if ($pago == 1) {
        $nombre = "Tarjeta de credito";
    }
    if ($pago == 2) {
        $nombre = "Tarjeta de debito";
    }
    if ($pago == 3) {
        $nombre = "Tarjeta de transferencia";
    }
    if ($pago == 4) {
        $nombre = "Efectivo";
    }
    return $nombre;
}

function notas_detalle($id_nota)
{
    $detalle_nota = View_notas_detalle::where('id_nota', $id_nota)->first();

    return $detalle_nota;
}
