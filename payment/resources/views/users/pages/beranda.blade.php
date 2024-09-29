@extends('users.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="centered-container">
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="card" style="background-color: rgba(0, 0, 0, 0.45); height: 100%;">
                            <div class="card-body">
                                <h4><img src="./debit-card.png" alt="logo" class="me-3" width="35px"> E-Bayarin</h4>
                                <hr>
                                <a class="btn btn-transparent active w-100 text-start mb-2"><i
                                        class="ms-1 me-2 bi bi-house-door"></i>
                                    Beranda</a>
                                <a class="btn btn-transparent w-100 text-start mb-2"><i class="ms-1 me-2 bi bi-person"></i>
                                    Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card" style="background-color: rgba(0, 0, 0, 0.45);">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col d-flex align-items-center" style="font-size: 20px;">
                                        <img src="./debit-card.png" alt="logo" class="me-3" width="60px">
                                        <span class="me-2">Rp. </span>
                                        <span id="hiddenBalance" class="hiddenBalance">****</span>
                                        <span id="balance" class="balance hidden">1.000.000</span>
                                        <button class="btn" id="showBalanceBtn"><i class="bi bi-eye-fill"></i></button>
                                        <button class="btn hidden" id="hideBalanceBtn"><i
                                                class="bi bi-eye-slash-fill"></i></button>
                                    </div>
                                    <div class="col text-end">
                                        <button class="btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <i class="bi bi-cash fs-2"></i>
                                            <h6 style="font-size: 11px;">Isi Saldo</h6>
                                        </button>
                                        <button class="btn">
                                            <i class="bi bi-arrow-down-square fs-2"></i>
                                            <h6 style="font-size: 11px;">Minta</h6>
                                        </button>
                                        <button class="btn">
                                            <i class="bi bi-arrow-up-square fs-2"></i>
                                            <h6 style="font-size: 11px;">Kirim</h6>
                                        </button>
                                    </div>
                                </div>
                                <div class="card scrollable-content mt-3"
                                    style="background-color: rgba(0, 0, 0, 0.50); height: 450px;">
                                    <div class="container mt-5 mb-5 ms-3 me-3">
                                        <div class="row">
                                            <div class="col">
                                                <!-- <h4 class="ms-3">Kartu</h4> -->
                                                <div class="container d-flex align-items-center"
                                                    style="width: 400px; height: 200px; background-color: rgba(0, 0, 0, 0.50); border-radius: 20px;">
                                                    <div class="container">
                                                        <img src="./debit-card.png" alt="logo" class="me-3"
                                                            width="35px">
                                                        <span class="fs-4">Virtual Card</span>
                                                        <hr class="mb-4">
                                                        <div class="ms-2">
                                                            <!-- Card Number -->
                                                            <span class="fs-6" id="hiddenCardNumber"
                                                                style="letter-spacing: 10px;">************</span>
                                                            <span class="fs-6 hidden" id="cardNumber"
                                                                style="letter-spacing: 7px;">081234567890</span>

                                                            <!-- Toggle Buttons -->
                                                            <button class="btn" id="showCardBtn"><i
                                                                    class="bi bi-eye-fill"></i></button>
                                                            <button class="btn hidden" id="hideCardBtn"><i
                                                                    class="bi bi-eye-slash-fill"></i></button>

                                                            <p style="letter-spacing: 5px; font-size: 12px;">Rifky Aryo</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="container">
                                                    <p>Transaksi Terbaru</p>
                                                    <hr style="width: 350px;">
                                                    <div class="card mb-3"
                                                        style="background-color: #ffffff30; border-radius: 10px; width: 350px;">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5>ok</h5>
                                                                </div>
                                                                <div class="col text-end">
                                                                    <h6>- 10000</h6>
                                                                </div>
                                                            </div>
                                                            <span style="font-size: 13px;">1 september 2024</span>
                                                        </div>
                                                    </div>
                                                    <div class="card mb-3"
                                                        style="background-color: #ffffff30; border-radius: 10px; width: 350px;">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <h5>ok</h5>
                                                                </div>
                                                                <div class="col text-end">
                                                                    <h6>- 10000</h6>
                                                                </div>
                                                            </div>
                                                            <span style="font-size: 13px;">1 september 2024</span>
                                                        </div>
                                                    </div>
                                                    <a href="" class="btn">Cek Selengkapnya</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="background-color: rgba(0, 0, 0, 0.45);">
                    <div class="modal-header" style="border: none;">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                    </div>
                    <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Understood</button>
                        </div> -->
                </div>
            </div>
        </div>
    @endsection
