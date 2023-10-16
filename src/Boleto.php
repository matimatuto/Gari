<?php
namespace TrabajoSube;

class Boleto {
    public $lineaUsada;
    public $tarifaUsada;
    public $saldoRestante;
    public $tipoTarjeta;
    public $IDTarjetaUsada;
    public $saldoAnterior;

    public function actualizarBoleto($linea,$tarifa,$saldo,$tipoDeTarjeta,$IDTarjeta) {
        $this->lineaUsada = $linea;
        $this->tarifaUsada = $tarifa;
        $this->saldoRestante = $saldo;
        $this->tipoTarjeta = $tipoDeTarjeta;
        $this->IDTarjetaUsada = $IDTarjeta;
    }
    public function mostrarBoleto($tarjeta) {
        $this->saldoAnterior = end($tarjeta->historialSaldo);
        printf("Linea: %s\n", $this->lineaUsada);
        printf("Tarifa: %s\n", $this->tarifaUsada);
        if ($this->saldoAnterior < 0 && $this->saldoRestante > 0) {
            printf("Tu saldo ya no es negativo\n");
        }
        printf("Saldo Restante: %s\n", $this->saldoRestante);
        printf("Tipo de Tarjeta: %s\n", $this->tipoTarjeta);
        printf("ID de Tarjeta Usada: %s\n", $this->IDTarjetaUsada);
    }
}
?>