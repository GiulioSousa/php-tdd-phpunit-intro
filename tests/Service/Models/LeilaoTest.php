<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        $ana = new Usuario('Ana');
        $leilao = new Leilao('Gol');
        $leilao->recebeLance(new Lance($ana, 6000));
        $leilao->recebeLance(new Lance($ana, 7000));
        
        static::assertCount(1, $leilao->getLances());
        static::assertEquals(6000, $leilao->getLances()[0]->getValor());
    }
    
    public function testLeilaoNaoDeveAceitarMaisDe5LancesPorUsuario()
    {
        $leilao = new Leilao('New Civic');
        $ana = new Usuario('Ana');
        $pedro = new Usuario('Pedro');

        $leilao->recebeLance(new Lance($ana, 6000));
        $leilao->recebeLance(new Lance($pedro, 7000));
        $leilao->recebeLance(new Lance($ana, 8000));
        $leilao->recebeLance(new Lance($pedro, 9000));
        $leilao->recebeLance(new Lance($ana, 10000));
        $leilao->recebeLance(new Lance($pedro, 11000));
        $leilao->recebeLance(new Lance($ana, 12000));
        $leilao->recebeLance(new Lance($pedro, 13000));
        $leilao->recebeLance(new Lance($ana, 14000));
        $leilao->recebeLance(new Lance($pedro, 15000));

        $leilao->recebeLance(new Lance($ana, 16000));
        $leilao->recebeLance(new Lance($pedro, 17000));
        
        static::assertCount(10, $leilao->getLances());
        static::assertEquals(15000, $leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
    }

    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(
        int $qtdLances,
        Leilao $leilao,
        array $valores
    ) {
        static::assertCount($qtdLances, $leilao->getLances());

        foreach ($valores as $i => $valorEsperado) {
            static::assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
        }

        /* static::assertEquals(4000, $leilao->getLances()[0]->getValor());
        static::assertEquals(5000, $leilao->getLances()[1]->getValor()); */
    }

    public static function geraLances()
    {
        $ana = new Usuario('Ana');
        $pedro = new Usuario('Pedro');

        $leilaoCom2Lances = new Leilao('Wolkswagen Voyage');
        $leilaoCom2Lances->recebeLance(new Lance($ana, 4000));
        $leilaoCom2Lances->recebeLance(new Lance($pedro, 5000));

        $leilaoCom1Lance = new Leilao('Chevrolet Agile');
        $leilaoCom1Lance->recebeLance(new Lance($ana, 4000));

        return [
            '2-Lances' => [2, $leilaoCom2Lances, [4000, 5000]],
            '1-Lance' =>[1, $leilaoCom1Lance, [4000]]
        ];
    }
}
