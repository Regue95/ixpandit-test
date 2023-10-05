@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-6">
                <h1 class="mt-0">Pokemon Finder</h1>
                <form action="{{ route('search-pokemon') }}" method="GET">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="search">Enter the name of the Pokemon</label>
                        <input type="text-primary" class="form-control border border-primary" id="search" name="search" placeholder="Name">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>

                @if ($errors->any())
                    <div class="alert alert-danger alert-sm mt-3">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection