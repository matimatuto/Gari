<?php
namespace TrabajoSube;

class Boleto {
    public $lineaUsada;
    public $tarifaUsada;
    public $saldoRestante;

    
    public function actualizarBoleto($linea,$tarifa,$saldo) {
        $this->lineaUsada = $linea;
        $this->tarifaUsada = $tarifa;
        $this->saldoRestante = $saldo;
    }
}
?>