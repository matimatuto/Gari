<?php
namespace TrabajoSube;

class TarjetaFranquiciaParcial extends Tarjeta{
    public $tipo;
    public $habilitada = true;
    public $viajesHoy = 0;
    public $tiempoUltimoViaje;
    public $fechaUltimoViaje;


    public function __construct($saldoInicial,$tipoDeTarjeta = "Estudiantil") {
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
            if($this->viajesHoy >= 4){
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

   
    private function verificarHabilitada($tiempo) {
        $dia = date("N",$tiempo);
        $hora = date("G",$tiempo);

        if($this->tiempoUltimoViaje==null || ($this->tiempoUltimoViaje - $tiempo >= 300 && $dia >= 1 && $dia <= 5 && $hora >= 6 && $hora <= 22)) {
            $this->habilitada = true;
            return $this->habilitada;
        }
        else {
            $this->habilitada = false;
            return $this->habilitada;
        }
    }
}
?>