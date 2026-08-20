@extends('layouts.admin')

@section('page-title', 'Payment Transactions')

@section('content')
    <div class="p-6 space-y-6">
        <div class="grid gap-6 md:grid-cols-5">
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Total</p>
                <p class="text-2xl font-semibold text-[#384551] mt-2">{{ $summary['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Success</p>
                <p class="text-2xl font-semibold text-green-600 mt-2">{{ $summary['success'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Pending</p>
                <p class="text-2xl font-semibold text-yellow-600 mt-2">{{ $summary['pending'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Failed</p>
                <p class="text-2xl font-semibold text-red-600 mt-2">{{ $summary['failed'] }}</p>
            </div>
            <div class="bg-white rounded-xl border border-[#e4e6e8] p-6 sneat-card">
                <p class="text-sm font-medium text-[#91979f]">Revenue</p>
                <p class="text-2xl font-semibold text-[#384551] mt-2">₦{{ number_format($summary['revenue'], 2) }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-[#e4e6e8] sneat-card">
            <div class="p-6 border-b border-[#e4e6e8]">
                <h2 class="text-lg font-semibold text-[#384551]">Recent Transactions</h2>
                <p class="text-sm text-[#91979f] mt-1">Monitor payment activity across the platform.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Reference</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Course</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#91979f] uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e4e6e8]">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-[#384551]">{{ $payment->reference }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#384551]">{{ $payment->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#646e78]">{{ $payment->course->title ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-[#384551]">₦{{ number_format($payment->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium
                                        {{ $payment->status === 'success' ? 'bg-green-100 text-green-800' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-[#91979f]">{{ $payment->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-[#91979f]">No payments yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-[#e4e6e8]">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
@endsection
