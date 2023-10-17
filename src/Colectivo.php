<?php
namespace TrabajoSube;

class Colectivo {
    public $linea;
    public $tarifa = 120;
    public $tarifaModificada;
    public $lineasIterurbanas = [1000,1001,1002];

    public function __construct($lineaUsada = 0) {
        $this->linea = $lineaUsada;
    }

    public function pagarCon($tarjeta,$boleto,$tiempo=0){
        $boletoDevuelto = false;
        switch(get_class($tarjeta)) {
            case 'TrabajoSube\TarjetaFranquiciaCompleta':
                if($tarjeta->verificarHabilitada($tiempo)) {
                    $tarjeta->descargarSaldo($this->tarifaModificada);
                    $tarjeta->registrarViaje($tiempo);
                    $boleto->actualizarBoleto($this->linea,$this->tarifaModificada,$tarjeta->saldo,$tarjeta->tipo,$tarjeta->ID);
    
                    $boletoDevuelto = true;
                    return $boleto;
                }
                break;
            case 'TrabajoSube\TarjetaFranquiciaParcial':
                if(!$boletoDevuelto) {
                    if($tarjeta->verificarHabilitada($tiempo)) {
                        if($tarjeta->saldo >= $this->tarifaModificada) {
                            $tarjeta->descargarSaldo($this->tarifaModificada);
                            $tarjeta->registrarViaje($tiempo);
                            $boleto->actualizarBoleto($this->linea,$this->tarifaModificada,$tarjeta->saldo,$tarjeta->tipo,$tarjeta->ID);
    
                            $boletoDevuelto = true;
                            return $boleto;
                        }
                    }
                }
                break;
            default:
                if(!$boletoDevuelto) {
                    if($tarjeta->saldo > $this->tarifa) {
                        $this->actualizarDias($tarjeta,$tiempo);
                            $this->actualizarTarifa($tarjeta);
                        $tarjeta->descargarSaldo($this->tarifa);
                        $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->saldo,$tarjeta->tipo,$tarjeta->ID);
    
                        return $boleto;
                    }
                    elseif($tarjeta->saldo - $this->tarifa > -211.84 && $tarjeta->plus > 0) {
                        $tarjeta->descargarSaldo($this->tarifa);
                        $boleto->actualizarBoleto($this->linea,$this->tarifa,$tarjeta->saldo,$tarjeta->tipo,$tarjeta->ID);
                        $tarjeta->plus --;
    
                        return $boleto;
                    }
    
                    return false;
                }
        }
    }
    public function actualizarTarifa($tarjeta){
        if(in_array($this->linea,$this->lineasIterurbanas)) {
            $this->tarifa = 184;
        }

        if(get_class($tarjeta) == 'TrabajoSube\TarjetaFranquiciaCompleta' && $tarjeta->habilitada) {
            $this->tarifaModificada = 0;
        }
        elseif(get_class($tarjeta) == 'TrabajoSube\TarjetaFranquiciaParcial' && $tarjeta->habilitada) {
            $this->tarifaModificada = $this->tarifa * 0.5;
        }
        elseif(get_class($tarjeta) == 'TrabajoSube\Tarjeta') {
            if($tarjeta->vecesUsadaMes < 30) {
                $this->tarifaModificada = $this->tarifa;
            }
            elseif($tarjeta->vecesUsadaMes < 80) {
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
            $tarjeta->vecesUsadaMes++;
            $mes = date("m",$tiempo);
            $tarjeta->actualizarMes($mes);
        }
    }
    }
?>