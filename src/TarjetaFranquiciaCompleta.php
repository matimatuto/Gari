<?php
namespace TrabajoSube;

class TarjetaFranquiciaCompleta extends Tarjeta{
    public $tipo;
    public $habilitada = true;
    public $viajesHoy = 0;
    public $fechaUltimoViaje;

    public function __construct($saldoInicial,$tipoDeTarjeta = "Jubilados") {
        parent::__construct($saldoInicial);
        $this->tipo = $tipoDeTarjeta;
    }

    public function registrarViaje($tiempo) {
        $this->viajesHoy++;
        $this->tiempoUltimoViaje = $tiempo;
        $this->actualizarHabilitacion($tiempo);
        $this->fechaUltimoViaje = date("Y-m-d", $tiempo);
    }

    public function actualizarHabilitacion($tiempo) {
        if ($this->fechaUltimoViaje === date("Y-m-d",$tiempo)) {
            if($this->viajesHoy >= 2) {
                $this->habilitada = false;
            }
            else {
                $this->habilitada = true;
            }
        } else {
            $this->viajesHoy = 1;
            $this->habilitada = true;
        }
    }
}
?>