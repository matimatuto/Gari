<?php
namespace TrabajoSube;

class Colectivo {
    public $linea;
    public $tarifa = 120;
    public $mitadTarifa;
    public $sinTarifa = 0;
    
    public function __construct($lineaUsada = 0) {
        $this->linea = $lineaUsada;
        $this->mitadTarifa = $this->tarifa / 2;
    }

    public function pagarCon($tarjeta,$boleto) {
        if ($tarjeta instanceof TarjetaFranquiciaCompleta){
            $boleto->actualizarBoleto($this->linea,$this->sinTarifa,$tarjeta->saldo,$tarjeta->tipo);

            return $boleto;
        }
        elseif($tarjeta instanceof TarjetaFranquiciaParcial){
            if($tarjeta->saldo >= $this->tarifa) {
            $tarjeta->descargarSaldo($this->mitadTarifa);
            $boleto->actualizarBoleto($this->linea,$this->mitadTarifa,$tarjeta->saldo,$tarjeta->tipo);

            return $boleto;
            }
            elseif($tarjeta->saldo - $this->mitadTarifa > -211.84 && $tarjeta->plus > 0) {
                $tarjeta->descargarSaldo($this->tarifa);
                $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->saldo,$tarjeta->tipo);
                $tarjeta->plus --;
                
                return $boleto;
            }

            return false;
            
        }elseif ($tarjeta->saldo >= $this->tarifa) {
            $tarjeta->descargarSaldo($this->tarifa);
            $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->saldo,$tarjeta->tipo);
            
            return $boleto;
        }elseif ($tarjeta->saldo - $this->tarifa > -211.84 && $tarjeta->plus > 0) {
            $tarjeta->descargarSaldo($this->tarifa);
            $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->saldo,$tarjeta->tipo);
            $tarjeta->plus --;
            
            return $boleto;
        }
            return false;
    }
    }
?>