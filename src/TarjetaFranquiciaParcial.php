<?php
namespace TrabajoSube;

class TarjetaFranquiciaCompleta extends Tarjeta{
    public $tipo;

    public function __construct($saldoInicial,$tipoDeTarjeta = "Estudiantil") {
        parent::__construct($saldoInicial);
        $this->tipo = $tipoDeTarjeta;
    }
}
?>