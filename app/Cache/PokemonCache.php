<?php

namespace App\Cache;

use App\Contracts\PokemonCacheInterface;

class PokemonCache implements PokemonCacheInterface
{
    private $cache = [];
    
    public function set($key, $value, $ttl) {
        $expirationTime = time() + $ttl;
        $this->cache[$key] = ['value' => $value, 'expires_at' => $expirationTime];
    }
    
    public function get($key) {
        if (isset($this->cache[$key]) && $this->cache[$key]['expires_at'] >= time()) {
            return $this->cache[$key]['value'];
        } else {
            return null;
        }
    }
    
    public function delete($key) {
        if (isset($this->cache[$key])) {
            unset($this->cache[$key]);
        }
    }
    
    public function clear() {
        $this->cache = [];
    }
}
