<?php
namespace TrabajoSube;

class Tarjeta {
    private $tipo = "Normal";
    private $saldo;
    private $plus = 2;


    public function __construct($saldoInicial) {
        $this->saldo = $saldoInicial;
    }

    public function cargarTarjeta($cargarSaldo) {
        if ($this->saldo + $cargarSaldo < 6600 && in_array($cargarSaldo,[150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000])) {
            $this->saldo += $cargarSaldo;
            if ($this->saldo > 0) {
                $this->saldo = 2;
            }
            return true;
        }
        else {
            return false;
        }
    }

    public function descargarSaldo($restarSaldo) {
        $this->saldo -= $restarSaldo;
    }

}


?>