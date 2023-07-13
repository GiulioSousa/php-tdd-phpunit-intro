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
}
