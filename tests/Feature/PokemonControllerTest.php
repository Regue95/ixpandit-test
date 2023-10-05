<?php

namespace Tests\Feature;

use App\Contracts\PokemonServiceInterface;
use App\Http\Controllers\PokemonController;
use App\Http\Requests\PokemonSearchRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Tests\TestCase;

class PokemonControllerTest extends TestCase
{
    protected $testImage = "iVBORw0KGgoAAAANSUhEUgAAAdsAAAHbCAYAAACDejA0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4BpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/";

    /** @test */
    public function testGetAllPokemonsSucess()
    {
        $pokemonServiceMock = $this->getMockBuilder(PokemonServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pokemonServiceMock->expects($this->once())
            ->method('getAllPokemons')
            ->willReturn(['Bulbasaur', 'Ivysaur', 'Venusaur']);

        $controller = new PokemonController($pokemonServiceMock);

        $response = $controller->getAllPokemons();

        $this->assertInstanceOf(JsonResponse::class, $response);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals(['Bulbasaur', 'Ivysaur', 'Venusaur'], $data);
    }

    /** @test */
    public function testGetAllPokemonsEmpty()
    {
        $pokemonServiceMock = $this->getMockBuilder(PokemonServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pokemonServiceMock->expects($this->once())
            ->method('getAllPokemons')
            ->willReturn([]);

        $controller = new PokemonController($pokemonServiceMock);

        $response = $controller->getAllPokemons();

        $this->assertInstanceOf(JsonResponse::class, $response);

        $data = json_decode($response->getContent(), true);

        $this->assertEquals([], $data);
    }

    /** @test */
    public function testSearchPokemonByNameSucess()
    {
        $pokemonFound[] = [
            'name' => "Pikachu",
            'image' => $this->testImage,
        ];

        $pokemonServiceMock = $this->getMockBuilder(PokemonServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pokemonServiceMock->expects($this->once())
            ->method('searchPokemonByName')
            ->with('Pikachu')
            ->willReturn($pokemonFound);

        $controller = new PokemonController($pokemonServiceMock);

        $request = PokemonSearchRequest::create('/search', 'GET', ['search' => 'Pikachu']);

        $response = $controller->searchPokemon($request);

        $this->assertInstanceOf(View::class, $response);

        $viewData = $response->getData();

        $this->assertEquals($pokemonFound, $viewData['pokemons']);
    }

    /** @test */
    public function testSearchPokemonByNameMissMatching()
    {
        $pokemonServiceMock = $this->getMockBuilder(PokemonServiceInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pokemonServiceMock->expects($this->once())
            ->method('searchPokemonByName')
            ->with('MissMatching')
            ->willReturn([]);

        $controller = new PokemonController($pokemonServiceMock);

        $request = PokemonSearchRequest::create('/search', 'GET', ['search' => 'MissMatching']);

        $response = $controller->searchPokemon($request);

        $this->assertInstanceOf(View::class, $response);

        $viewData = $response->getData();

        $this->assertEquals([], $viewData['pokemons']);
    }
}
