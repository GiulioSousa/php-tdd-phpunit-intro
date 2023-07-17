<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    public function testAvaliadorMaiorValorOrdemCrescente()
    {
        //Arrange
        $leilao = new Leilao('Fiat Punto');

        $jose = new Usuario('Jose');
        $marta = new Usuario('Marta');

        $leilao->recebeLance(new Lance($jose, 3000));
        $leilao->recebeLance(new Lance($marta, 3500));

        $leiloeiro = new Avaliador();

        //Act
        $leiloeiro->avaliar($leilao);

        $maiorValor = $leiloeiro->getMaiorValor();

        //Assert
        // $this->assertEquals(3500, $maiorValor);
        Self::assertEquals(3500, $maiorValor);
    }

    public function testAvaliadorMaiorValorOrdemDecrescente()
    {
        //Arrange
        $leilao = new Leilao('Fiat Punto');

        $jose = new Usuario('Jose');
        $marta = new Usuario('Marta');

        $leilao->recebeLance(new Lance($marta, 3500));
        $leilao->recebeLance(new Lance($jose, 3000));

        $leiloeiro = new Avaliador();

        //Act
        $leiloeiro->avaliar($leilao);

        $maiorValor = $leiloeiro->getMaiorValor();

        //Assert
        // $this->assertEquals(3500, $maiorValor);
        Self::assertEquals(3500, $maiorValor);
    }

    public function testAvaliadorMenorValorOrdemCrescente()
    {
        //Arrange
        $leilao = new Leilao('Fiat Punto');

        $jose = new Usuario('Jose');
        $marta = new Usuario('Marta');

        $leilao->recebeLance(new Lance($marta, 3500));
        $leilao->recebeLance(new Lance($jose, 3000));

        $leiloeiro = new Avaliador();

        //Act
        $leiloeiro->avaliar($leilao);

        $menorValor = $leiloeiro->getMenorValor();

        //Assert
        // $this->assertEquals(3500, $maiorValor);
        Self::assertEquals(3000, $menorValor);
    }

    public function testAvaliadorMenorValorOrdemDecrescente()
    {
        //Arrange
        $leilao = new Leilao('Fiat Punto');

        $jose = new Usuario('Jose');
        $marta = new Usuario('Marta');

        $leilao->recebeLance(new Lance($jose, 3000));
        $leilao->recebeLance(new Lance($marta, 3500));

        $leiloeiro = new Avaliador();

        //Act
        $leiloeiro->avaliar($leilao);

        $menorValor = $leiloeiro->getMenorValor();

        //Assert
        // $this->assertEquals(3500, $maiorValor);
        Self::assertEquals(3000, $menorValor);
    }

    public function testAvaliadorBuscar3MaioresLances()
    {
        //Arrange
        $leilao = new Leilao('Fiat Grand Siena 1.6');

        $jose = new Usuario('José');
        $amanda = new Usuario("Amanda");
        $julia = new Usuario('Júlia');
        $romulo = new Usuario('Rômulo');

        $leilao->recebeLance(new Lance($jose, 5000));
        $leilao->recebeLance(new Lance($amanda, 7000));
        $leilao->recebeLance(new Lance($julia, 6000));
        $leilao->recebeLance(new Lance($romulo, 8000));

        $leiloeiro = new Avaliador();

        //act
        $leiloeiro->avaliar($leilao);
        $maioresLances = $leiloeiro->getMaioresLances();

        //assert
        // Self::assertEquals(3, count($maioresLances));
        static::assertCount(3, $maioresLances);
        static::assertEquals(8000, $maioresLances[0]->getValor());
        static::assertEquals(7000, $maioresLances[1]->getValor());
        static::assertEquals(6000, $maioresLances[2]->getValor());
    }
}
