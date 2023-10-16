<?php
namespace TrabajoSube;

class Boleto {
    private $lineaUsada;
    private $tarifaUsada;
    private $saldoRestante;

    
    public function actualizarBoleto($linea,$tarifa,$saldo) {
        $this->lineaUsada = $linea;
        $this->tarifaUsada = $tarifa;
        $this->saldoRestante = $saldo;
    }
}
?>