<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Config;
use App\Contracts\PokemonCacheInterface;
use App\Services\PokemonService;
use App\Contracts\PokemonClientInterface;
use Tests\TestCase;

class PokemonServiceTest extends TestCase
{
    protected $testImage = "iVBORw0KGgoAAAANSUhEUgAAAdsAAAHbCAYAAACDejA0AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAA4BpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/";

    /** @test */
    public function getAllPokemonsSuccess()
    {
        $pokemonClientMock = $this->getMockBuilder(PokemonClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pokemonCacheMock = $this->getMockBuilder(PokemonCacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $jsonResponse = '{
            "results": [
                {
                    "name": "bulbasaur",
                    "url": "https://pokeapi.co/api/v2/pokemon/1/"
                }
            ]
        }';

        $pokemonResponse = json_decode($jsonResponse, true);

        $pokemonClientMock->expects($this->once())
            ->method('getAllPokemons')
            ->willReturn($pokemonResponse);

        $service = new PokemonService($pokemonClientMock, $pokemonCacheMock);

        $pokemons = $service->getAllPokemons();

        $this->assertEquals($pokemonResponse, $pokemons);
    }

    /** @test */
    public function searchPokemonByNameSuccess()
    {
        $pokemonClientMock = $this->getMockBuilder(PokemonClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pokemonCacheMock = $this->getMockBuilder(PokemonCacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $expected[] = [
            'name' => "Pikachu",
            'image' => $this->testImage,
        ];

        $pokemonClientMock->expects($this->once())
            ->method('getAllPokemons')
            ->willReturn(['Pikachu']);

        $pokemonClientMock->expects($this->once())
            ->method('getPokemonImageByName')
            ->with('Pikachu')
            ->willReturn($this->testImage);

        $service = new PokemonService($pokemonClientMock, $pokemonCacheMock);

        $actual = $service->searchPokemonByName('Pikachu');

        $this->assertEquals($expected, $actual);
    }

    /** @test */
       public function searchPokemonByNameMissMatching()
    {
        $pokemonClientMock = $this->getMockBuilder(PokemonClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pokemonCacheMock = $this->getMockBuilder(PokemonCacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $expected = [];

        $pokemonClientMock->expects($this->once())
            ->method('getAllPokemons')
            ->willReturn(['Pikachu']);

        $service = new PokemonService($pokemonClientMock, $pokemonCacheMock);

        $actual = $service->searchPokemonByName('MissMatching');

        $this->assertEquals($expected, $actual);
    }

    /** @test */
      public function setImageForPokemonSuccess()
    {
        $pokemonClientMock = $this->getMockBuilder(PokemonClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $pokemonCacheMock = $this->getMockBuilder(PokemonCacheInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $expected = $this->testImage;

        $pokemonClientMock->expects($this->once())
            ->method('getPokemonImageByName')
            ->with('Pikachu')
            ->willReturn($this->testImage);

        $service = new PokemonService($pokemonClientMock, $pokemonCacheMock);

        $actual = $service->setImageForPokemon('Pikachu');

        $this->assertEquals($expected, $actual);
    }

        /** @test */
        public function setImageForPokemonImageNotFound()
        {
            $pokemonClientMock = $this->getMockBuilder(PokemonClientInterface::class)
                ->disableOriginalConstructor()
                ->getMock();
    
            $pokemonCacheMock = $this->getMockBuilder(PokemonCacheInterface::class)
                ->disableOriginalConstructor()
                ->getMock();
    
            $expected = "Image not found";
    
            $pokemonClientMock->expects($this->once())
                ->method('getPokemonImageByName')
                ->with('Pikachu Starter')
                ->willReturn("Image not found");
    
            $service = new PokemonService($pokemonClientMock, $pokemonCacheMock);
    
            $actual = $service->setImageForPokemon('Pikachu Starter');
    
            $this->assertEquals($expected, $actual);
        }
}
