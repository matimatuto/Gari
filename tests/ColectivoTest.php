<?php
namespace TrabajoSube;
use PHPUnit\Framework\TestCase;

class ColectivoTest extends TestCase {
    
    public function testPagarBoleto(){
        $tarjeta1 = new Tarjeta(400);
        $colectivo1 = new Colectivo(10);
        $boleto1 = new Boleto();
        $tiempoFalso = new TiempoFalso();

        $colectivo1->pagarCon($tarjeta1,$boleto1,$tiempoFalso);

        $this->assertInstanceOf(Boleto::class, $boleto1);
        $this->assertEquals($colectivo1->linea, $boleto1->lineaUsada);
        $this->assertEquals($colectivo1->tarifa, $boleto1->tarifaUsada);
        $this->assertEquals($tarjeta1->saldo, $boleto1->saldoRestante);
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

        $this->assertEquals(1,$tarjeta3->plus);
    }

    public function testFranquiciaCompleta(){
        $tarjeta4 = new TarjetaFranquiciaCompleta(0);
        $colectivo4 = new Colectivo(10);
        $boleto4 = new Boleto();
        $colectivo4->pagarCon($tarjeta4,$boleto4);

        $this->assertInstanceOf(Boleto::class, $boleto4);
    }

    public function testFranquiciaParcial(){
        $tarjeta5 = new TarjetaFranquiciaParcial(121);
        $colectivo5 = new Colectivo(10);
        $boleto5 = new Boleto();
        $colectivo5->pagarCon($tarjeta5,$boleto5);

        $this->assertEquals($colectivo5->mitadTarifa,$boleto5->tarifaUsada);

    }
    public function testDistintosBoletos() {

        $tarjeta1 = new Tarjeta(200);
        $tarjeta2 = new TarjetaFranquiciaCompleta(200);
        $tarjeta3 = new TarjetaFranquiciaParcial(200);
        $tarjeta4 = new TarjetaFranquiciaParcial(200,"Ejemplo");
        $colectivo1 = new Colectivo(10);
        $boleto1 = new Boleto();


        $colectivo1->pagarCon($tarjeta1,$boleto1);
        $this->assertEquals("Normal", $boleto1->tipoTarjeta);

        $colectivo1->pagarCon($tarjeta2,$boleto1);
        $this->assertEquals("Jubilados", $boleto1->tipoTarjeta);

        $colectivo1->pagarCon($tarjeta3,$boleto1);
        $this->assertEquals("Estudiantil", $boleto1->tipoTarjeta);

        $colectivo1->pagarCon($tarjeta4,$boleto1);
        $this->assertEquals("Ejemplo", $boleto1->tipoTarjeta);
    }

    public function testParcialHabilitada() {
        $tarjeta5 = new TarjetaFranquiciaParcial(6600);
        $colectivo2 = new Colectivo(10);
        $boleto2 = new Boleto();
        $tiempoFalso2 = new TiempoFalso(0);
    
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,$tiempoFalso2->time());
        $tiempoFalso2->avanzar(120);
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,$tiempoFalso2->time());
        $this->assertEquals($colectivo2->tarifa,$boleto2->tarifaUsada);
        $tiempoFalso2->avanzar(300);
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,$tiempoFalso2->time());
        $this->assertEquals($colectivo2->mitadTarifa,$boleto2->tarifaUsada);
        $tiempoFalso2->avanzar(500);
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,$tiempoFalso2->time());
        $tiempoFalso2->avanzar(500);
        $boleto2 = $colectivo2->pagarCon($tarjeta5,$boleto2,$tiempoFalso2->time());
        $this->assertEquals($colectivo2->tarifa,$boleto2->tarifaUsada);
    }
    

    public function testCompletaHabilitada() {
        $tarjeta6 = new TarjetaFranquiciaCompleta(6600);
        $colectivo3 = new Colectivo(10);
        $boleto3 = new Boleto();
        $tiempoFalso3 = new TiempoFalso(0);
    
        $this->assertEquals('TrabajoSube\TarjetaFranquiciaCompleta',get_class($tarjeta6));
        $boleto3 = $colectivo3->pagarCon($tarjeta6,$boleto3,$tiempoFalso3->time());
        $boleto3 = $colectivo3->pagarCon($tarjeta6,$boleto3,$tiempoFalso3->time());
        $this->assertEquals($colectivo3->sinTarifa,$boleto3->tarifaUsada);
        $boleto3 = $colectivo3->pagarCon($tarjeta6,$boleto3,$tiempoFalso3->time());
        $this->assertEquals($colectivo3->tarifa,$boleto3->tarifaUsada);
    }
    

    public function testSaldoExtra() {
        $tarjeta7 = new TarjetaFranquiciaCompleta(6100);
        $colectivo4 = new Colectivo(10);
        $boleto4 = new Boleto();
        $tiempoFalso4 = new TiempoFalso();


        $tarjeta7->cargarTarjeta(620);

        $this->assertEquals(6600,$tarjeta7->saldo);
        $this->assertEquals(120,$tarjeta7->saldoExtra);
        
        $colectivo4->pagarCon($tarjeta7,$boleto4,$tiempoFalso4);
        $this->assertEquals(6600,$tarjeta7->saldo);
        $this->assertEquals(0,$tarjeta7->saldoExtra);
    }
}
?>