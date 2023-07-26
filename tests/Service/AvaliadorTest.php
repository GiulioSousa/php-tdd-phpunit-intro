<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use DomainException;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    /** @var Avaliador */
    private $leiloeiro;

    protected function setUp(): void
    {
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
        //Act
        $this->leiloeiro->avaliar($leilao);

        $maiorValor = $this->leiloeiro->getMaiorValor();

        //Assert
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
        static::assertCount(3, $maioresLances);
        static::assertEquals(8000, $maioresLances[0]->getValor());
        static::assertEquals(7000, $maioresLances[1]->getValor());
        static::assertEquals(6000, $maioresLances[2]->getValor());
    }

    public function testLeilaoVazioNaoPodeSerAvaliado()
    {
        /* try {
            $leilao = new Leilao('Nissan Frontier');
            $this->leiloeiro->avaliar($leilao);
            
            static::fail('Exceção deveria ter sido lançada');
        } catch (DomainException $exception) {
            static::assertEquals(
                'Não é possível avaliar um leilão vazio.',
                $exception->getMessage()
            );
        } */
       
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Não é possível avaliar um leilão vazio.');
        $leilao = new Leilao('Nissan Frontier');
        $this->leiloeiro->avaliar($leilao);
        
    }
    
    public function testLeilaoFinalizadoNaoPodeSerAvaliado () 
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Leilão Já foi finalizado!');

        $leilao = new Leilao('Nissan Frontier');
        $jose = new Usuario('José');
        $leilao->recebeLance(new Lance($jose, 8000));
        $leilao->finalizar();

        $this->leiloeiro->avaliar($leilao);
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

        return [
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
}
