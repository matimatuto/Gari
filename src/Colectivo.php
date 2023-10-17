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

    public function pagarCon($tarjeta,$boleto,$tiempo=0){
        $boletoDevuelto = false;
        switch(get_class($tarjeta)) {
            case 'TrabajoSube\TarjetaFranquiciaCompleta':
                if($tarjeta->verificarHabilitada()) {
                    $tarjeta->descargarSaldo($this->sinTarifa);
                    $tarjeta->registrarViaje($tiempo);
                    $boleto->actualizarBoleto($this->linea,$this->sinTarifa,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo(),$tarjeta->obtenerID());
    
                    $boletoDevuelto = true;
                    return $boleto;
                }
                break;
            case 'TrabajoSube\TarjetaFranquiciaParcial':
                if(!$boletoDevuelto) {
                    if($tarjeta->verificarHabilitada($tiempo)) {
                        if($tarjeta->obtenerSaldo() >= $this->mitadTarifa) {
                            $tarjeta->descargarSaldo($this->mitadTarifa);
                            $tarjeta->registrarViaje($tiempo);
                            $boleto->actualizarBoleto($this->linea,$this->mitadTarifa,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo(),$tarjeta->obtenerID());
    
                            $boletoDevuelto = true;
                            return $boleto;
                        }
                    }
                }
                break;
            default:
                if(!$boletoDevuelto) {
                    if($tarjeta->obtenerSaldo() > $this->tarifa) {
                        $tarjeta->descargarSaldo($this->tarifa);
                        $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo(),$tarjeta->obtenerID());
    
                        return $boleto;
                    }
                    elseif($tarjeta->obtenerSaldo() - $this->tarifa > -211.84 && $tarjeta->obtenerPlus() > 0) {
                        $tarjeta->descargarSaldo($this->tarifa);
                        $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo(),$tarjeta->obtenerID());
                        $tarjeta->descargarPlus();
    
                        return $boleto;
                    }
    
                    return false;
                }
        }
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