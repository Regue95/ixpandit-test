<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Client\RequestException;
use App\Contracts\PokemonCacheInterface;
use App\Contracts\PokemonClientInterface;
use App\Contracts\PokemonServiceInterface;

class PokemonService implements PokemonServiceInterface
{
    protected $client;
    protected $cache;
    
    // TODO: Implement Redis
    
    /**
     * Constructor.
     *
     * @param PokemonClientInterface $client.
     * @param PokemonCacheInterface $cache.
     */
    public function __construct(PokemonClientInterface $client, PokemonCacheInterface $cache)
    {
        $this->client = $client;
        $this->cache = $cache;
    }

    /**
     * Gets and caches the complete list of Pokemon names.
     *
     * Cache for 24hs.
     *
     * @return array List of Pokemon names.
     */
    public function getAllPokemons()
    {
        try {
            $pokemons = $this->client->getAllPokemons();
            $this->cache->set(Config::get('constants.POKEMONS_CACHE_KEY'), $pokemons, 86400);
        } catch (RequestException $e) {
            Log::error('[PokemonService - getAllPokemons] Error en la solicitud HTTP: ' . $e->getMessage());
        }
        return $pokemons;
    }

    /**
     * Search for Pokemon by name and return matching results.
     *
     * This method searches for Pokemon names that contain the given name and returns an array of
     * matching Pokemon, including their name and associated image.
     *
     * @param string $nameGiven The name to search for among Pokemon names.
     * @return array An array of matching Pokemon, each containing 'name' and 'image' keys.
     */
    public function searchPokemonByName(string $nameGiven)
    {
        $pokemonFound = [];
        $images = [];

        $pokemons = $this->checkCachePokemons();
        foreach ($pokemons as $pokemon) {
            if (stripos($pokemon, $nameGiven) !== false) {
                $images[$pokemon] = $this->setImageForPokemon($pokemon);
            }
        }

        foreach ($images as $pokemon => $image) {
            $pokemonFound[] = [
                'name' => ucwords(str_replace('-', ' ', $pokemon)),
                'image' => $image
            ];
        }
        return $pokemonFound;
    }

    /**
     * Set the image for a Pokemon by its name.
     *
     * This method retrieves an image for a Pokemon by its name and returns the image data
     * as a base64-encoded string.
     *
     * @param string $name Name of the Pokemon.
     * @return string A base64-encoded string representing the Pokemon's image.
     */
    public function setImageForPokemon(string $name)
    {
        $cacheKey = Config::get('IMAGES_CACHE_KEY') . $name;
        $cachedImage = $this->cache->get($cacheKey);
        if ($cachedImage !== null){
            return $cachedImage;
        }
        try {
            $image = $this->client->getPokemonImageByName($name);
            $this->cache->set($cacheKey, $image, 86400);
        } catch (RequestException $e) {
            Log::error('[PokemonService - setImageForPokemon] Error en la solicitud HTTP: ' . $e->getMessage());
        }
        return $image;
    }

    /**
     * Check and retrieve Pokemon data from the cache, or fetch it if not present.
     *
     * This method checks if Pokemon data is present in the cache. If not, it fetches all Pokemon data and stores
     * it in the cache for future use. If data is present in the cache, it is returned directly.
     *
     * @return array An array containing Pokemon names retrieved from the cache or fetched from the Pokemon API.
     */
    public function checkCachePokemons()
    {
        return ($this->cache->get(Config::get('constants.POKEMONS_CACHE_KEY')) === null) ? $this->getAllPokemons() : $this->cache->get(Config::get('constants.POKEMONS_CACHE_KEY'));
    }
}
