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
        $tiempoFalso2 = new TiempoFalso();

        $colectivo2->pagarCon($tarjeta2,$boleto2,$tiempoFalso2);

        $this->assertFalse($colectivo2->pagarCon($tarjeta2,$boleto2,$tiempoFalso2));
    }

    public function testDescuentoViajesPlus(){
        $tarjeta3 = new Tarjeta(0);
        $colectivo3 = new Colectivo(10);
        $boleto3 = new Boleto();
        $colectivo3->pagarCon($tarjeta3,$boleto3,);

        $this->assertEquals(1,$tarjeta3->obtenerPlus());
    }

    public function testFranquiciaCompleta(){
        $tarjeta4 = new TarjetaFranquiciaCompleta(0);
        $colectivo4 = new Colectivo(10);
        $boleto4 = new Boleto();
        $boleto4 = $colectivo4->pagarCon($tarjeta4,$boleto4,25200);

        $this->assertInstanceOf(Boleto::class, $boleto4);
    }

    public function testFranquiciaParcial(){
        $tarjeta5 = new TarjetaFranquiciaParcial(120);
        $colectivo5 = new Colectivo(10);
        $boleto5 = new Boleto();
        $colectivo5->pagarCon($tarjeta5,$boleto5,25200);

        $this->assertEquals($colectivo5->obtenerTarifaModificada(),$boleto5->obtenerTarifaUsada());

    }
    public function testDistintosBoletos() {

        $tarjeta1 = new Tarjeta(200);
        $tarjeta2 = new TarjetaFranquiciaCompleta(200);
        $tarjeta3 = new TarjetaFranquiciaParcial(200);
        $tarjeta4 = new TarjetaFranquiciaParcial(200,"Ejemplo");
        $colectivo1 = new Colectivo(10);
        $boleto1 = new Boleto();


        $boleto1 = $colectivo1->pagarCon($tarjeta1,$boleto1);
        $this->assertEquals("Normal", $boleto1->obtenerTipoTarjeta());

        $boleto1 = $colectivo1->pagarCon($tarjeta2,$boleto1,25200);
        $this->assertEquals("Jubilados", $boleto1->obtenerTipoTarjeta());

        $boleto1 = $colectivo1->pagarCon($tarjeta3,$boleto1,25200);
        $this->assertEquals("Estudiantil", $boleto1->obtenerTipoTarjeta());

        $boleto1 = $colectivo1->pagarCon($tarjeta4,$boleto1,25200);
        $this->assertEquals("Ejemplo", $boleto1->obtenerTipoTarjeta());
    }

    public function testParcialHabilitada() {
        $tarjeta5 = new TarjetaFranquiciaParcial(6600);
        $colectivo2 = new Colectivo(10);
        $boleto2 = new Boleto();
        $tiempoFalso2 = new TiempoFalso(0);
    
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,25200);
        $tiempoFalso2->avanzar(120);
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,55200);
        $this->assertEquals($colectivo2->obtenerTarifaModificada(),$boleto2->obtenerTarifaUsada());
        $tiempoFalso2->avanzar(300);
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,25200);
        $tiempoFalso2->avanzar(500);
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,25200);
        $tiempoFalso2->avanzar(500);
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,25200);
    }
    

    public function testCompletaHabilitada() {
        $tarjeta6 = new TarjetaFranquiciaCompleta(6600);
        $colectivo3 = new Colectivo(10);
        $boleto3 = new Boleto();
        $tiempoFalso3 = new TiempoFalso(0);
    
        $this->assertEquals('TrabajoSube\TarjetaFranquiciaCompleta',get_class($tarjeta6));
        $boleto3 = $colectivo3->pagarCon($tarjeta6,$boleto3,25200);
        $boleto3 = $colectivo3->pagarCon($tarjeta6,$boleto3,25300);
        $this->assertEquals($colectivo3->obtenerTarifaModificada(),$boleto3->obtenerTarifaUsada());
        $boleto3 = $colectivo3->pagarCon($tarjeta6,$boleto3,55200);
        $this->assertEquals(null,$boleto3->obtenerTarifaUsada());
    }
    

    public function testSaldoExtra() {
        $tarjeta7 = new Tarjeta(6100);
        $colectivo4 = new Colectivo(10);
        $boleto4 = new Boleto();
        $tiempoFalso4 = new TiempoFalso();
    
        $tarjeta7->cargarTarjeta(700);
        $tarjeta7->agregarSaldoExtra();
    
        $this->assertEquals(6600,$tarjeta7->obtenerSaldo());
        $this->assertEquals(200,$tarjeta7->obtenerSaldoExtra());
        
        $boleto4 = $colectivo4->pagarCon($tarjeta7,$boleto4,$tiempoFalso4->time());
        $tarjeta7->agregarSaldoExtra();
        $this->assertEquals(6600,$tarjeta7->obtenerSaldo());
        $this->assertEquals(80,$tarjeta7->obtenerSaldoExtra());
    }
    public function testDescuentos() {
        $tarjeta1 = new Tarjeta(600);
        $colectivo1 = new Colectivo(10);
        $boleto1 = new Boleto();
        $tiempoFalso1 = new TiempoFalso(0);

        $tarjeta1->establecerDias(2);
        $colectivo1->pagarCon($tarjeta1,$boleto1,$tiempoFalso1->time());
        $this->assertEquals($colectivo1->obtenerTarifa(), $colectivo1->obtenerTarifaModificada());
        $tarjeta1->establecerDias(32);
        $colectivo1->pagarCon($tarjeta1,$boleto1,$tiempoFalso1->time());
        $this->assertEquals($colectivo1->obtenerTarifa() * 0.8, $colectivo1->obtenerTarifaModificada());
        $tarjeta1->establecerDias(82);
        $colectivo1->pagarCon($tarjeta1,$boleto1,$tiempoFalso1->time());
        $this->assertEquals($colectivo1->obtenerTarifa() * 0.75, $colectivo1->obtenerTarifaModificada());
    }

    public function testDias() {
        $tarjeta1 = new TarjetaFranquiciaCompleta(600);
        $tarjeta2 = new TarjetaFranquiciaParcial(600);
        $colectivo1 = new Colectivo(10);
        $boleto1 = new Boleto();
        $tiempoFalso1 = new TiempoFalso(0);

        $tiempoFalso1->avanzar(518400);
        $colectivo1->pagarCon($tarjeta1,$boleto1,$tiempoFalso1->time());
        $this->assertEquals(false, $tarjeta1->obtenerHabilitada());

        $colectivo1->pagarCon($tarjeta2,$boleto1,$tiempoFalso1->time());
        $this->assertEquals(false, $tarjeta2->obtenerHabilitada());

        
    }
}
?>