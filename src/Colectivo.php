<?php
namespace TrabajoSube;

class Colectivo {
    private $linea;
    private $tarifa = 120;
    private $tarifaModificada;
    private $lineasIterurbanas = [1000,1001,1002];

    public function __construct($lineaUsada = 0) {
        $this->linea = $lineaUsada;
    }

    public function pagarCon($tarjeta,$boleto,$tiempo=0){
        $boletoDevuelto = false;
        $this->actualizarTarifa($tarjeta);

        switch(get_class($tarjeta)) {
            case 'TrabajoSube\TarjetaFranquiciaCompleta':
                if($tarjeta->verificarHabilitada($tiempo)) {
                    $this->actualizarTarifa($tarjeta);
                    $tarjeta->descargarSaldo($this->tarifaModificada);
                    $tarjeta->registrarViaje($tiempo);
                    $boleto->actualizarBoleto($this->linea,$this->tarifaModificada,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo(),$tarjeta->obtenerID());
    
                    $boletoDevuelto = true;
                    return $boleto;
                }
                break;
            case 'TrabajoSube\TarjetaFranquiciaParcial':
                if(!$boletoDevuelto) {
                    if($tarjeta->verificarHabilitada($tiempo)) {
                        if($tarjeta->obtenerSaldo() >= $this->obtenerTarifaModificada()) {
                            $this->actualizarTarifa($tarjeta);
                            $tarjeta->descargarSaldo($this->tarifaModificada);
                            $tarjeta->registrarViaje($tiempo);
                            $boleto->actualizarBoleto($this->linea,$this->tarifaModificada,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo(),$tarjeta->obtenerID());
    
                            $boletoDevuelto = true;
                            return $boleto;
                        }
                    }
                }
                break;
            default:
                if(!$boletoDevuelto) {
                    if($tarjeta->obtenerSaldo() > $this->tarifaModificada) {
                        $this->actualizarDias($tarjeta,$tiempo);
                        $this->actualizarTarifa($tarjeta);
                        $tarjeta->descargarSaldo($this->tarifaModificada);
                        $boleto->actualizarBoleto($this->linea,$this->tarifaModificada,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo(),$tarjeta->obtenerID());
    
                        return $boleto;
                    }
                    elseif($tarjeta->obtenerSaldo() - $this->tarifaModificada > -211.84 && $tarjeta->obtenerPlus() > 0) {
                        $tarjeta->descargarSaldo($this->tarifaModificada);
                        $boleto->actualizarBoleto($this->linea,$this->tarifaModificada,$tarjeta->obtenerSaldo(),$tarjeta->obtenerTipo(),$tarjeta->obtenerID());
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

    public function obtenerTarifaModificada(){
        return $this->tarifaModificada;
    }


    
    public function actualizarTarifa($tarjeta){
        if(in_array($this->linea,$this->lineasIterurbanas)) {
            $this->tarifa = 184;
        }
        else {
            $this->tarifa = 120;
        }

        if(get_class($tarjeta) == 'TrabajoSube\TarjetaFranquiciaCompleta' && $tarjeta->obtenerHabilitada()) {
            $this->tarifaModificada = 0;
        }
        elseif(get_class($tarjeta) == 'TrabajoSube\TarjetaFranquiciaParcial' && $tarjeta->obtenerHabilitada()) {
            $this->tarifaModificada = $this->tarifa * 0.5;
        }
        elseif(get_class($tarjeta) == 'TrabajoSube\Tarjeta') {
            if($tarjeta->obtenerVecesUsadaMes() < 30) {
                $this->tarifaModificada = $this->tarifa;
            }
            elseif($tarjeta->obtenerVecesUsadaMes() < 80) {
                $this->tarifaModificada = $this->tarifa * 0.8;
            }
            else {
                $this->tarifaModificada = $this->tarifa * 0.75;
            }
        }
        else {
            $this->tarifaModificada = $this->tarifa;
        }
    }

    public function actualizarDias($tarjeta,$tiempo) {
        if(get_class($tarjeta) == 'TrabajoSube\Tarjeta') {
            $tarjeta->sumarVecesUsadas();
            $mes = date("m",$tiempo);
            $tarjeta->actualizarMes($mes);
        }
    }
    }
?>