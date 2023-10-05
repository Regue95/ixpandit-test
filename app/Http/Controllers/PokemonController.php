<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Contracts\PokemonServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\PokemonSearchRequest;
use GuzzleHttp\Exception\RequestException;

class PokemonController extends Controller
{
    protected $pokemonService;

    /**
     * Constructor.
     *
     * @param PokemonServiceInterface $pokemonService.
     */
    public function __construct(PokemonServiceInterface $pokemonService)
    {
        $this->pokemonService = $pokemonService;
    }

    /**
     * Gets the complete list of Pokemon names.
     *
     * @return JsonResponse List of Pokemon names.
     * or a JSON error response
     */
    public function getAllPokemons()
    {
        try {
            $pokemons = $this->pokemonService->getAllPokemons();
            return new JsonResponse($pokemons);
        } catch (RequestException $e) {
            $json = json_decode($e->getMessage());
            return response()->json([
                'message' => $json->error->message,
                'reason' => $json->error->errors[0]->reason,
                'code' => $json->error->code,
            ]);
        }
    }

    /**
     * Search for Pokemon by name and return matching results or error response.
     *
     * @param PokemonSearchRequest $request.
     * @return View.
     * or a JSON error response
     */
    public function searchPokemon(PokemonSearchRequest $request)
    {
        $nameGiven = $request->input('search');
        try {
            $pokemons = $this->pokemonService->searchPokemonByName($nameGiven);
            return view('search', compact('pokemons'));
        } catch (RequestException $e) {
            $json = json_decode($e->getMessage());
            return response()->json([
                'message' => $json->error->message,
                'reason' => $json->error->errors[0]->reason,
                'code' => $json->error->code,
            ]);
        }
    }
}
