<?php
namespace TrabajoSube;

class TarjetaFranquiciaCompleta extends Tarjeta{
    private $tipo;

    public function __construct($saldoInicial,$tipoDeTarjeta = "Jubilados") {
        parent::__construct($saldoInicial);
        $this->tipo = $tipoDeTarjeta;
    }
}
?>