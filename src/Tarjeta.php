<?php
namespace TrabajoSube;

class Tarjeta {
    protected $tipo = "Normal";
    protected $ID;
    protected $saldo;
    protected $saldoExtra;
    protected $plus = 2;
    protected $historialSaldo = [];
    private $vecesUsadaMes = 0;
    private $ultimoMes;

    public function __construct($saldoInicial = 0, $IDTarjeta = 0) {
        $this->saldo = $saldoInicial;
        $this->ID = $IDTarjeta;
        $this->historialSaldo[] = $saldoInicial;
    }

    public function cargarTarjeta($cargarSaldo) {
    if (in_array($cargarSaldo,[150, 200, 250, 300, 350, 400, 450, 500, 600, 700, 800, 900, 1000, 1100, 1200, 1300, 1400, 1500, 2000, 2500, 3000, 3500, 4000])) {
        if($this->saldo + $cargarSaldo <= 6600){
            $this->saldo += $cargarSaldo;
            if ($this->saldo > 0) {
                $this->plus = 2;
            }
        
            return true;
        }
        else {
            $excess = $this->saldo + $cargarSaldo - 6600;
            $this->saldo = 6600;
            $this->saldoExtra = $excess;

            return true;
        }
    }
    else {
        return false;
    }
}


    public function descargarSaldo($restarSaldo) {
        $this->historialSaldo[] = $this->saldo;
        $this->saldo -= $restarSaldo;
    }

    public function agregarSaldoExtra() {
        if($this->saldo < 6600 && $this->saldo + $this->saldoExtra > 6600) {
            $this->saldoExtra -= (6600 - $this->saldo);
            $this->saldo = 6600;
        }
        elseif($this->saldo + $this->saldoExtra <= 6600) {
            $this->saldo += $this->saldoExtra;
            $this->saldoExtra = 0;
        }
    }



    public function descargarPlus(){
        $this->plus--;
    }

    public function obtenerSaldo() {
        return $this->saldo;
    }
    public function obtenerTipo() {
        return $this->tipo;
    }
    public function obtenerPlus() {
        return $this->plus;
    }
    public function obtenerID() {
        return $this->ID;
    }
    public function obtenerSaldoExtra() {
        return $this->saldoExtra;
    }
    public function obtenerVecesUsadaMes() {
        return $this->vecesUsadaMes;
    }
    
    public function actualizarMes($mes) {
        if($this->ultimoMes == $mes || $this->ultimoMes == null){
            $this->ultimoMes = $mes;
        }
        else {
            $this->vecesUsadaMes = 0;
            $this->ultimoMes = $mes;
        }
    }

    public function sumarVecesUsadas() {
        $this->vecesUsadaMes++;
    }

    public function establecerDias($dias){
        $this->vecesUsadaMes = $dias;
    }
}


?>