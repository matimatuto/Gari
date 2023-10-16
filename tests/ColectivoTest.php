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
        $this->assertEquals($colectivo1->linea, $boleto1->lineaUsada);
        $this->assertEquals($colectivo1->tarifa, $boleto1->tarifaUsada);
        $this->assertEquals($tarjeta1->saldo, $boleto1->saldoRestante);
    }

    public function testPagarBoletoErroneo(){
        $tarjeta2 = new Tarjeta(100);
        $colectivo2 = new Colectivo(10);
        $boleto2 = new Boleto();

        $this->assertFalse($colectivo2->pagarCon($tarjeta2,$boleto2));
    }
}
?>