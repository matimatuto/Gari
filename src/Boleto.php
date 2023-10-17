<?php
namespace TrabajoSube;

class Boleto {
    private $lineaUsada;
    private $tarifaUsada;
    private $saldoRestante;
    private $tipoTarjeta;

    public function actualizarBoleto($linea,$tarifa,$saldo,$tipoDeTarjeta) {
        $this->lineaUsada = $linea;
        $this->tarifaUsada = $tarifa;
        $this->saldoRestante = $saldo;
        $this->tipoTarjeta = $tipoDeTarjeta;
    }

    public function obtenerLineaUsada() {
        return $this->lineaUsada;
    }
    public function obtenerTarifaUsada() {
        return $this->tarifaUsada;
    }
    public function obtenerSaldoRestante() {
        return $this->saldoRestante;
    }
    public function obtenerTipoTarjeta() {
        return $this->tipoTarjeta;
    }
}
?>