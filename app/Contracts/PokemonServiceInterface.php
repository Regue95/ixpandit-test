<?php

namespace App\Contracts;

interface PokemonServiceInterface {
    public function getAllPokemons();
    public function searchPokemonByName(string $nameGiven);
}