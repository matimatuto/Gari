<?php
namespace TrabajoSube;

class Boleto {
    public $lineaUsada;
    public $tarifaUsada;
    public $saldoRestante;
    public $tipoTarjeta;

    public function actualizarBoleto($linea,$tarifa,$saldo,$tipoDeTarjeta) {
        $this->lineaUsada = $linea;
        $this->tarifaUsada = $tarifa;
        $this->saldoRestante = $saldo;
        $this->tipoTarjeta = $tipoDeTarjeta;
    }
}
?>