<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body,
        html {
            font-family: 'Poppins';
            height: 100%;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/jpeg;base64,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');
            background-size: cover;
            background-attachment: fixed;
            filter: blur(10px);
            z-index: -1;
        }

        .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            width: 100%;
        }

        .hidden {
            display: none;
        }

        .btn-transparent {
            background-color: rgba(0, 0, 0, 0.1);
            /* Initial transparent background */
            border: none;
            /* Remove border */
            color: #fff;
            /* Text color */
            padding: 10px;
            /* Padding for click area */
            font-size: 1rem;
            /* Font size */
            cursor: pointer;
            /* Pointer cursor */
            transition: background-color 0.2s;
            /* Smooth transition for hover and active effects */
        }

        .btn-transparent:hover {
            background-color: rgba(255, 255, 255, 0.05);
            /* Lighter background on hover */
        }

        .btn-transparent.active {
            background-color: rgba(0, 0, 0, 0.3);
            /* Darker background for active state */
            transform: scale(0.98);
            /* Slight scale down to simulate a press effect */
        }

        .scrollable-content {
            overflow-y: auto;
            /* Enables vertical scrolling */
            overflow-x: hidden;
            /* Hides horizontal scrollbar if any */
            padding-right: 15px;
            /* Adds space for scrollbar to prevent content hiding */
        }
    </style>

</head>

<body data-bs-theme="dark">

    @yield('content')

    <script>
        const showCardBtn = document.getElementById('showCardBtn');
        const hideCardBtn = document.getElementById('hideCardBtn');
        const cardNumber = document.getElementById('cardNumber');
        const hiddenCardNumber = document.getElementById('hiddenCardNumber');

        let isCardInfoVisible = true;

        showCardBtn.addEventListener('click', () => {
            if (isCardInfoVisible) {
                hiddenCardNumber.classList.add('hidden'); // Hide censored number
                cardNumber.classList.remove('hidden'); // Show full number

                showCardBtn.classList.add('hidden'); // Hide the show button
                hideCardBtn.classList.remove('hidden'); // Show the hide button

                isCardInfoVisible = false;
            }
        });

        hideCardBtn.addEventListener('click', () => {
            if (!isCardInfoVisible) {
                hiddenCardNumber.classList.remove('hidden'); // Show censored number
                cardNumber.classList.add('hidden'); // Hide full number

                hideCardBtn.classList.add('hidden'); // Hide the hide button
                showCardBtn.classList.remove('hidden'); // Show the show button

                isCardInfoVisible = true;
            }
        });

        const showBtn = document.getElementById('showBalanceBtn');
        const hideBtn = document.getElementById('hideBalanceBtn');
        const balance = document.getElementById('balance');
        const hiddenBalance = document.getElementById('hiddenBalance');

        let isBalanceVisible = true;

        showBtn.addEventListener('click', () => {
            if (isBalanceVisible) {
                hiddenBalance.classList.add('hidden');
                balance.classList.remove('hidden');
                showBtn.classList.add('hidden');
                hideBtn.classList.remove('hidden');
                isBalanceVisible = false;
            }
        });

        hideBtn.addEventListener('click', () => {
            if (!isBalanceVisible) {
                hiddenBalance.classList.remove('hidden');
                balance.classList.add('hidden');
                hideBtn.classList.add('hidden');
                showBtn.classList.remove('hidden');
                isBalanceVisible = true;
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
