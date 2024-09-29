@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('BANNER PLAIN.png') }}" class="d-block w-100" alt="banner">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('BANNER PLAIN.png') }}" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('BANNER PLAIN.png') }}" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card d-flex justify-content-center align-items-center">
                    <img src="{{ asset('logo.png') }}" alt="logo" class="mt-2 mb-2" width="100">
                    <span class="fs-5 fw-bolder mb-2">Kringg Kaki Lima</span>
                </div>
            </div>
            <div class="col">
                <div class="card d-flex justify-content-center align-items-center">
                    <img src="{{ asset('logo.png') }}" alt="logo" class="mt-2 mb-2" width="100">
                    <span class="fs-5 fw-bolder mb-2">Kringg Kaki Lima</span>
                </div>
            </div>
            <div class="col">
                <div class="card d-flex justify-content-center align-items-center">
                    <img src="{{ asset('logo.png') }}" alt="logo" class="mt-2 mb-2" width="100">
                    <span class="fs-5 fw-bolder mb-2">Kringg Kaki Lima</span>
                </div>
            </div>
            <div class="col">
                <div class="card d-flex justify-content-center align-items-center">
                    <img src="{{ asset('logo.png') }}" alt="logo" class="mt-2 mb-2" width="100">
                    <span class="fs-5 fw-bolder mb-2">Kringg Kaki Lima</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col">
                <h3 class="fw-bold">Produk</h3>
            </div>
            <div class="col-3">
                <input type="text" class="form-control" placeholder="Search..." name="" id="">
            </div>
        </div>
        {{-- @dd($produk) --}}
        @if (count($produk) == 0)
            <div class="alert alert-danger mt-4" role="alert">
                Produk tidak ditemukan
            </div>
        @endif
        <div class="row mt-4">
            @foreach ($produk as $item)
                <div class="col-md-4 mb-4">
                    <a href="/produk/{{$item['id']}}" style="text-decoration: none">
                        <div class="card d-flex justify-content-center align-items-center">
                            <img src="{{ 'http://localhost:6060/storage/'.$item['image'] }}" alt="{{ $item['name'] }}" class="mt-2 mb-2" width="200" height="200" style="object-fit: cover">
                            <span class="fs-5 fw-bolder mb-2">{{ $item['name'] }}</span>
                            <span class="fs-6 mb-2">Rp. {{ $item['price'] }}</span>
                        </div>
                    </a>
                </div>

                @if ($loop->iteration % 3 == 0)
        </div>
        <div class="row mt-4">
            @endif
            @endforeach
        </div>
    </div>
@endsection
