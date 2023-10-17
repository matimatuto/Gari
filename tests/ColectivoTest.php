<?php
namespace TrabajoSube;
use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    
    public function testPagarBoleto(){
        $tarjeta1 = new Tarjeta(400);
        $colectivo1 = new Colectivo(10);
        $boleto1 = new Boleto();

        $colectivo1->pagarCon($tarjeta1,$boleto1);

        $this->assertInstanceOf(Boleto::class, $boleto1);
        $this->assertEquals($colectivo1->obtenerLinea(), $boleto1->obtenerLineaUsada());
        $this->assertEquals($colectivo1->obtenerTarifa(), $boleto1->obtenerTarifaUsada());
        $this->assertEquals($tarjeta1->obtenerSaldo(), $boleto1->obtenerSaldoRestante());
    }

    public function testPagarBoletoErroneo(){
        $tarjeta2 = new Tarjeta(-200);
        $colectivo2 = new Colectivo(10);
        $boleto2 = new Boleto();

        $colectivo2->pagarCon($tarjeta2,$boleto2);

        $this->assertFalse($colectivo2->pagarCon($tarjeta2,$boleto2));
    }

    public function testDescuentoViajesPlus(){
        $tarjeta3 = new Tarjeta(0);
        $colectivo3 = new Colectivo(10);
        $boleto3 = new Boleto();
        $colectivo3->pagarCon($tarjeta3,$boleto3);

        $this->assertEquals(1,$tarjeta3->obtenerPlus());
    }

    public function testFranquiciaCompleta(){
        $tarjeta4 = new TarjetaFranquiciaCompleta(0);
        $colectivo4 = new Colectivo(10);
        $boleto4 = new Boleto();
        $colectivo4->pagarCon($tarjeta4,$boleto4);

        $this->assertInstanceOf(Boleto::class, $boleto4);
    }

    public function testFranquiciaParcial(){
        $tarjeta5 = new TarjetaFranquiciaParcial(60);
        $colectivo5 = new Colectivo(10);
        $boleto5 = new Boleto();
        $colectivo5->pagarCon($tarjeta5,$boleto5);
        $this->assertEquals($colectivo5->obtenerMitadTarifa(),$boleto5->obtenertarifaUsada());

    }
}
?>