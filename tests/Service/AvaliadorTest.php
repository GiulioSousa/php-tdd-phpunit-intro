<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private $leiloeiro;

    // public function novoAvaliador()
    protected function setUp(): void
    {
        // return new Avaliador();
        $this->leiloeiro = new Avaliador();
    }

    /** 
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    // * @dataProvider gerarLeiloes
    public function testAvaliadorMaiorValorDeLances(Leilao $leilao)
    {
        //Arrange
        // $leilao = $this->leilaoEmOrdemCrescente();

        // $leiloeiro = new Avaliador();
        //// $this->novoAvaliador();

        //Act
        // $leiloeiro->avaliar($leilao);
        $this->leiloeiro->avaliar($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        //Assert
        // $this->assertEquals(3500, $maiorValor);
        Self::assertEquals(8000, $maiorValor);
    }

    /** 
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorMenorValor(Leilao $leilao)
    {
        //Act
        $this->leiloeiro->avaliar($leilao);

        $menorValor = $this->leiloeiro->getMenorValor();

        //Assert
        Self::assertEquals(5000, $menorValor);
    }

    /** 
     * @dataProvider leilaoEmOrdemCrescente
     * @dataProvider leilaoEmOrdemDecrescente
     * @dataProvider leilaoEmOrdemAleatoria
     */
    public function testAvaliadorBuscar3MaioresLances(Leilao $leilao)
    {
        //act
        $this->leiloeiro->avaliar($leilao);
        $maioresLances = $this->leiloeiro->getMaioresLances();

        //assert
        // Self::assertEquals(3, count($maioresLances));
        static::assertCount(3, $maioresLances);
        static::assertEquals(8000, $maioresLances[0]->getValor());
        static::assertEquals(7000, $maioresLances[1]->getValor());
        static::assertEquals(6000, $maioresLances[2]->getValor());
    }

    /*-------------------DADOS------------------*/
    public static function leilaoEmOrdemCrescente()
    {
        $leilao = new Leilao('Fiat Grand Siena 1.6');

        $jose = new Usuario('José');
        $amanda = new Usuario("Amanda");
        $julia = new Usuario('Júlia');
        $romulo = new Usuario('Rômulo');

        $leilao->recebeLance(new Lance($romulo, 5000));
        $leilao->recebeLance(new Lance($amanda, 6000));
        $leilao->recebeLance(new Lance($julia, 7000));
        $leilao->recebeLance(new Lance($jose, 8000));

        // return $leilao;
        return [
            // [$leilao]
            'ordem-crescente' => [$leilao]
        ];
    }

    public static function leilaoEmOrdemDecrescente()
    {
        $leilao = new Leilao('Fiat Grand Siena 1.6');

        $jose = new Usuario('José');
        $amanda = new Usuario("Amanda");
        $julia = new Usuario('Júlia');
        $romulo = new Usuario('Rômulo');

        $leilao->recebeLance(new Lance($jose, 8000));
        $leilao->recebeLance(new Lance($julia, 7000));
        $leilao->recebeLance(new Lance($amanda, 6000));
        $leilao->recebeLance(new Lance($romulo, 5000));

        return [
            'ordem-decrescente' => [$leilao]
        ];
    }

    public static function leilaoEmOrdemAleatoria()
    {
        $leilao = new Leilao('Fiat Grand Siena 1.6');

        $jose = new Usuario('José');
        $amanda = new Usuario("Amanda");
        $julia = new Usuario('Júlia');
        $romulo = new Usuario('Rômulo');

        $leilao->recebeLance(new Lance($julia, 7000));
        $leilao->recebeLance(new Lance($jose, 8000));
        $leilao->recebeLance(new Lance($amanda, 6000));
        $leilao->recebeLance(new Lance($romulo, 5000));

        return [
            'ordem-aleatoria' => [$leilao]
        ];
    }

    /* public static function gerarLeiloes() 
    {
        $avaliadorTest = new AvaliadorTest("AvaliadorTest");

        return [
            [$avaliadorTest->leilaoEmOrdemCrescente()],
            [$avaliadorTest->leilaoEmOrdemDecrescente()],
            [$avaliadorTest->leilaoEmOrdemAleatoria()]
        ];
    } */
}
