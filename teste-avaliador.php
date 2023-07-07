<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';

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
$valorEsperado = 3500;

if ($valorEsperado == $maiorValor) {
    echo "TESTE: SUCESSO";
} else {
    echo "TESTE: FALHA";
}