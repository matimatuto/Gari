<?php
namespace TrabajoSube;

class TarjetaFranquiciaParcial extends Tarjeta{
    public $tipo;

    public function __construct($saldoInicial,$tipoDeTarjeta = "Estudiantil") {
        parent::__construct($saldoInicial);
        $this->tipo = $tipoDeTarjeta;
    }
}
?>