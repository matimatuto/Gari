<?php
namespace TrabajoSube;
class Tarjeta{
    private $saldo;
    private $plus = 2;
    private $ID;

    public function __construct($saldoInicial = 0, $IDTarjeta = 0) {
        $this->saldo = $saldoInicial;
        $this->ID = $IDTarjeta;
    }

    public function cargarSaldo($agregar) {
        if(($this->saldo + $agregar) < 6600 && in_array($agregar, [150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000])) {
            $this->saldo += $agregar;
            if($this->saldo > 0) {
                $this->plus = 2;
            }
            return true;
        }
        return false;
    }

    public function descontarPlus() {
        $this->plus -= 1;
    }

    public function descargarSaldo($quitar) {
        $this->saldo -= $quitar;
    }

    public function obtenerSaldo() {
        return $this->saldo;
    }

    public function obtenerVPlus() {
        return $this->plus;
    }

    public function obtenerID() {
        return $this->ID;
    }

}

class TarjetaParcial extends Tarjeta {
    public function __construct($saldoInicial = 0, $IDTarjeta = 0) {
        parent::__construct($saldoInicial, $IDTarjeta);
    }

    public function descargarSaldo($quitar) {
        $this->saldo -= ($quitar / 2);
    }
}


class TarjetaCompleta extends Tarjeta {
    public function __construct($saldoInicial = 0,$IDTarjeta = 0) {
        parent::__construct($saldoInicial,$IDTarjeta);
    }

    public function descargarSaldo($quitar) {
        $this->saldo -= 0;
    }
}
?>