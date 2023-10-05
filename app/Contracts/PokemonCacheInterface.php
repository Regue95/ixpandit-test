<?php

namespace App\Contracts;

interface PokemonCacheInterface {
    public function set(string $cacheKey, $value, int $ttl);
    public function get(string $cacheKey);
    public function delete(string $cacheKey);
    public function clear();
}