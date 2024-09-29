<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wallet & Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Wallet Details -->
            <div class="bg-white shadow-xl sm:rounded-lg mb-6">
                <div class="px-6 py-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Wallet Details</h3>
                    <p class="mt-2 text-sm text-gray-500">Wallet ID: {{ $wallet->id }}</p>
                    <p class="mt-2 text-sm text-gray-500">Current Balance: <span class="font-bold text-xl text-green-500">{{ $wallet->balance }}</span></p>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="bg-white shadow-xl sm:rounded-lg mb-6">
                <div class="px-6 py-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Transaction History</h3>
                </div>
                <div class="overflow-x-auto px-6 py-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $transaction->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->amount }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->date }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if ($transaction->status === 'completed')
                                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Completed</span>
                                        @elseif ($transaction->status === 'pending')
                                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">Pending</span>
                                        @else
                                            <span class="inline-flex px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Failed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Create Transaction Form -->
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="px-6 py-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Create Transaction</h3>
                </div>
                <div class="px-6 py-4">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Transaction Type</label>
                            <select id="type" name="type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="deposit">Deposit</option>
                                <option value="withdraw">Withdraw</option>
                                <option value="transfer">Transfer</option>
                                <option value="payment">Payment</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <input type="number" name="amount" id="amount" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Transaction Date</label>
                            <input type="date" name="date" id="date" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="recipient_wallet_id" class="block text-sm font-medium text-gray-700">Recipient Wallet ID (for transfers)</label>
                            <input type="text" name="recipient_wallet_id" id="recipient_wallet_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <input type="hidden" name="wallet_id" value="{{ $wallet->id }}">

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 disabled:opacity-25 transition">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
