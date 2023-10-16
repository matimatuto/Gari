<?php
namespace TrabajoSube;

class Colectivo {
    public $linea;
    public $tarifa = 120;
    public $mitadTarifa;
    public $sinTarifa = 0;
    
    public function __construct($lineaUsada = 0) {
        $this->linea = $lineaUsada;
        $this->mitadTarifa = $this->tarifa/2;
    }

    public function pagarCon($tarjeta, $boleto, $tiempo = 0) {
        $boletoDevuelto = false;
    
        switch (get_class($tarjeta)) {
            case 'TrabajoSube\TarjetaFranquiciaCompleta':
                if ($tarjeta->habilitada) {
                    $tarjeta->descargarSaldo($this->sinTarifa);
                    $tarjeta->registrarViaje($tiempo);
                    $boleto->actualizarBoleto($this->linea, $this->sinTarifa, $tarjeta->saldo, $tarjeta->tipo, $tarjeta->ID);
    
                    $boletoDevuelto = true;
                    break;
                }
            case 'TrabajoSube\TarjetaFranquiciaParcial':
                if (!$boletoDevuelto && $tarjeta->verificarHabilitada($tiempo)) {
                    if ($tarjeta->saldo > $this->mitadTarifa) {
                        $tarjeta->descargarSaldo($this->mitadTarifa);
                        $tarjeta->registrarViaje($tiempo);
                        $boleto->actualizarBoleto($this->linea, $this->mitadTarifa, $tarjeta->saldo, $tarjeta->tipo, $tarjeta->ID);
    
                        $boletoDevuelto = true;
                        break;
                    }
                }
            default:
                if (!$boletoDevuelto) {
                    if ($tarjeta->saldo > $this->tarifa) {
                        $tarjeta->descargarSaldo($this->tarifa);
                        $boleto->actualizarBoleto($this->linea, $this->tarifa, $tarjeta->saldo, $tarjeta->tipo, $tarjeta->ID);
    
                        return $boleto;
                    } elseif ($tarjeta->saldo - $this->tarifa > -211.84 && $tarjeta->plus > 0) {
                        $tarjeta->descargarSaldo($this->tarifa);
                        $boleto->actualizarBoleto($this->linea, $this->tarifa, $tarjeta->saldo, $tarjeta->tipo, $tarjeta->ID);
                        $tarjeta->plus--;
    
                        return $boleto;
                    }
    
                    return false;
                }
        }
    }
    }
?>