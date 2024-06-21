<?php
use App\Models\Cat_Menu;
use App\Models\Cat_SubMenu;

function menu()
{
    $Menu = Cat_Menu::where('estado', 1)->get();

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

?>