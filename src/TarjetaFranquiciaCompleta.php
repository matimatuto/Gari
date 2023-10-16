<?php
namespace TrabajoSube;

class TarjetaFranquiciaCompleta extends Tarjeta{
    public $tipo;

    public function __construct($saldoInicial,$tipoDeTarjeta = "Jubilados") {
        parent::__construct($saldoInicial);
        $this->tipo = $tipoDeTarjeta;
    }
}
?>