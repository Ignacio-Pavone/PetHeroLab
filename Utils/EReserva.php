<?php
namespace Utils;


enum EReserva : string {
    case Pendiente = "Pendiente";
    case Confirmado = "Confirmado";
    case Rechazado  = "Rechazado";
    case Completo = "Completo";
}

?>