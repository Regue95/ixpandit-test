<?php

namespace App\Client;

use Illuminate\Support\Facades\Config;
use GuzzleHttp\Client;
use App\Contracts\PokemonClientInterface;

class PokemonClient implements PokemonClientInterface
{
    private $httpClient;

    /**
     * Constructor.
     *
     * @param Client $client.
     */
    public function __construct(Client $client)
    {
        // Initialize the Guzzle client
        $this->httpClient = $client;
    }

    /**
     * Gets and caches the complete list of Pokemon names.
     *
     * @return array List of Pokemon names.
     */
    public function getAllPokemons()
    {
        $pokemons = [];
        $response = $this->httpClient->get(Config::get('constants.URL_BASE_POKEMON') . '?offset=0&limit=99999');
        $data = json_decode($response->getBody(), true);
        foreach ($data['results'] as $pokemon) {
            $pokemons[] = $pokemon['name'];
        }
        return $pokemons;
    }

    /**
     * Get the image for a Pokemon by its name.
     *
     * @param string $nameGiven Name of the Pokemon.
     * @return string A base64-encoded string representing the Pokemon's image.
     */
    public function getPokemonImageByName(string $nameGiven)
    {
        $image = "Image not found";
        $response = $this->httpClient->get(Config::get('constants.URL_BASE_POKEMON') . $nameGiven);
        $data = json_decode($response->getBody(), true);
        if (isset($data['sprites']['front_default'])) {
            $image = base64_encode(file_get_contents($data['sprites']['front_default']));
        }
        return $image;
    }
}
