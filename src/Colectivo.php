<?php
namespace TrabajoSube;

class Colectivo {
    private $linea;
    private $tarifa = 120;


    public function __construct($lineaUsada = 0) {
        $this->linea = $lineaUsada;
    }

    public function pagarCon($tarjeta,$boleto) {
        if ($tarjeta->obtenerSaldo() >= $this->tarifa) {
            $tarjeta->restarSaldo($this->tarifa);
            $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->obtenerSaldo());
            
            return $boleto;
        }
        else {
            return false;
        }
    }
}


?>