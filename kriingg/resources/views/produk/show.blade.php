@extends('layouts.app')

@section('content')
    <div class="container">
        <style>
            /* Hide spinners in Chrome, Safari, Edge, Opera */
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        
            /* Hide spinners in Firefox */
            input[type="number"] {
                -moz-appearance: textfield;
            }
        </style>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Product Details Card -->
                <div class="card mb-4">
                    <div class="card-header fs-5 fw-bold">{{ $produk['name'] }}</div>
                    <div class="card-body text-center">
                        <img src="{{ 'http://localhost:6060/storage/' . $produk['image'] }}" class="img-fluid mb-4"
                            style="max-height: 300px; object-fit: cover;">
                        <p class="fs-4 fw-bold">Rp. {{ number_format($produk['price'], 0, ',', '.') }}</p>
                        <p class="fs-5">{{ $produk['description'] }}</p>
                    </div>
                </div>

                <!-- Order Form -->
                <div class="card">
                    <div class="card-header">{{ __('Beli Produk') }}</div>
                    <div class="card-body">
                        {{-- <form action="{{ route('order.store', $produk['id']) }}" method="POST"> --}}
                        @csrf
                        <div class="col-2">
                            <div class="mb-3">
                                <label class="form-label" for="quantity" class="fw-bolder">{{ __('Jumlah') }}</label>

                                <!-- Quantity Input with Buttons -->
                                <div class="input-group">
                                    <button type="button" class="btn btn-outline-secondary"
                                        id="decreaseQuantity">-</button>
                                    <input type="number" id="quantity" name="quantity" class="form-control text-center"
                                        min="1" value="1" required>
                                    <button type="button" class="btn btn-outline-secondary"
                                        id="increaseQuantity">+</button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="address" class="fw-bolder">{{ __('Alamat') }}</label><br>
                            <textarea id="address" name="address" class="form-control" placeholder="Enter your address" required>{{ $user->address ?? '' }}</textarea>
                            <span class="ms-1" style="font-size: 12px">Alamat yang tertera adalah alamat pada profile, jika ingin merubah
                                silahkan inputkan kembali.</span>
                        </div>

                        <!-- Delivery Fee and Total Cost Calculation -->
                        @php
                            $delivery_fee = 15000; // Fixed delivery fee (example)
                            $total = $produk['price'] + $delivery_fee;
                        @endphp

                        <hr>
                        <div class="container">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="fw-bolder">Detail Pembayaran</h5>
                                    <hr>
                                    <p class="fs-6">Harga Produk: <strong>Rp.
                                            {{ number_format($produk['price'], 0, ',', '.') }}</strong></p>
                                    <p class="fs-6">Detail Produk: <strong id="jumlah">1 X </strong><strong>Rp.
                                            {{ number_format($produk['price'], 0, ',', '.') }}</strong></p>
                                    <p class="fs-6">Total: <strong id="total">Rp.
                                            {{ number_format($produk['price'], 0, ',', '.') }}</strong></p>
                                    <p class="fs-6">Biaya Pengiriman: <strong>Rp.
                                            {{ number_format($delivery_fee, 0, ',', '.') }}</strong></p>
                                    <hr>
                                    <div class="text-end">
                                        <p class="fs-5 fw-bold">Total Pembayaran: <strong>Rp. <span
                                                    id="totalPrice">{{ number_format($total, 0, ',', '.') }}</span></strong>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <p><b>NB:</b> Pembayaran dilakukan dengan metode COD, dan estimasi pengantaran selama 3-7 hari.</p>

                        <button type="submit" class="btn btn-primary">{{ __('Pesan Sekarang') }}</button>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // JavaScript to dynamically calculate total cost based on quantity
        document.getElementById('quantity').addEventListener('input', updateTotalPrice);

        // Add event listeners for increment and decrement buttons
        document.getElementById('increaseQuantity').addEventListener('click', function() {
            const quantityInput = document.getElementById('quantity');
            quantityInput.value = parseInt(quantityInput.value) + 1;
            updateTotalPrice();
        });

        document.getElementById('decreaseQuantity').addEventListener('click', function() {
            const quantityInput = document.getElementById('quantity');
            if (parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                updateTotalPrice();
            }
        });

        function updateTotalPrice() {
            const price = {{ $produk['price'] }};
            const deliveryFee = {{ $delivery_fee }};
            const quantity = document.getElementById('quantity').value;

            // Calculate total cost
            const totalPrice = (price * quantity) + deliveryFee;

            document.getElementById('jumlah').innerText = quantity + ' x ';

            document.getElementById('total').innerText = 'Rp. ' + (price * quantity).toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).replace('IDR', 'Rp');

            // Format the total price
            document.getElementById('totalPrice').innerText = totalPrice.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).replace('IDR', 'Rp');
        }
    </script>
@endsection
