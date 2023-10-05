<?php

namespace App\Contracts;

interface PokemonClientInterface {
    public function getAllPokemons();
    public function getPokemonImageByName(string $nameGiven);
}