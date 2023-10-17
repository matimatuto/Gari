<?php
namespace TrabajoSube;
class Tarjeta{
    private $saldo;


    public function __construct($saldoInicial = 0) {
        $this->saldo = $saldoInicial;
    }

    public function cargarSaldo($agregar) {
        if(($this->saldo + $agregar) < 6600 && in_array($agregar, [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000])) {
            $this->saldo += $agregar;

            return true;
        }
        return false;
    }

    public function descargarSaldo($quitar) {
        $this->saldo -= $quitar;
    }

    public function obtenerSaldo() {
        return $this->saldo;
    }
}
?>