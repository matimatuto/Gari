<?php
namespace TrabajoSube;

class Colectivo {
    private $linea;
    private $tarifa = 120;
    private $mitadTarifa;
    private $sinTarifa = 0;
    
    public function __construct($lineaUsada = 0) {
        $this->linea = $lineaUsada;
        $this->mitadTarifa = $this->tarifa/2;
    }

    public function pagarCon($tarjeta,$boleto) {
        if ($tarjeta instanceof TarjetaFranquiciaCompleta){
            $boleto->actualizarBoleto($this->linea,$this->sinTarifa,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo());

            return $boleto;
        }
        elseif($tarjeta instanceof TarjetaFranquiciaParcial){
            if($tarjeta->obtenerSaldo() >= $this->mitadTarifa) {
            $tarjeta->descargarSaldo($this->mitadTarifa);
            $boleto->actualizarBoleto($this->linea,$this->mitadTarifa,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo());

            return $boleto;
            }
            elseif($tarjeta->obtenerSaldo() - $this->mitadTarifa > -211.84 && $tarjeta->obtenerPlus() > 0) {
                $tarjeta->descargarSaldo($this->tarifa);
                $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->saldo,$tarjeta->tipo);
                $tarjeta->descargarPlus();
                
                return $boleto;
            }

            return false;
            
        }elseif ($tarjeta->obtenerSaldo() >= $this->tarifa) {
            $tarjeta->descargarSaldo($this->tarifa);
            $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo());
            
            return $boleto;
        }elseif ($tarjeta->obtenerSaldo() - $this->tarifa > -211.84 && $tarjeta->obtenerPlus() > 0) {
            $tarjeta->descargarSaldo($this->tarifa);
            $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo());
            $tarjeta->descargarPlus();
            
            return $boleto;
        }
            return false;
    }

    public function obtenerLinea(){
        return $this->linea;
    }
    public function obtenerTarifa(){
        return $this->tarifa;
    }
    public function obtenerMitadTarifa(){
        return $this->mitadTarifa;
    }

    }
?>