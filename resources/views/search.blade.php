@extends('layouts.app')

@section('content')
    <div class="container-fluid mt-5 mb-5">
        <div class="row mt-5 mb-3">
            <h1 class="mt-0">Search results</h1>
            @if (count($pokemons) > 0)
                <div class="row">
                    @foreach ($pokemons as $pokemon)
                        <div class="col-md-3 mb-3">
                            <div class="card border-primary" style="width: 100%; height: 100%;">
                                <div class="card-header border-primary text-sm">{{ $pokemon['name'] }}</div>
                                <div class="card-body d-flex justify-content-center align-items-center"
                                    style="height: 200px;">
                                    <div style="width: 100%; height: 100%;">
                                        @if ($pokemon['image'] !== 'Image not found')
                                            <img src="data:image/png;base64,{{ $pokemon['image'] }}" class="img-fluid"
                                                style="width: 100%; height: 100%; object-fit: contain;"
                                                alt="{{ $pokemon['image'] }}">
                                        @else
                                            <p class="text-muted">Image not found</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="container-fluid">
                    <div class="alert alert-info mt-4">
                        No Pokemon found.
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection