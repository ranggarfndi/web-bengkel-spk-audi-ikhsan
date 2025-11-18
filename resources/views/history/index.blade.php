<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Prediksi Perawatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan (Pelanggan)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gejala</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hasil Prediksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rekomendasi #1</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            
                            @forelse ($histories as $history)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $history->created_at->format('d-m-Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium">{{ $history->vehicle->no_polisi ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">{{ $history->vehicle->customer->nama_pelanggan ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ Str::limit($history->input_gejala, 50) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">
                                        {{ $history->hasil_kelas_prediksi }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(!empty($history->hasil_rekomendasi_copras[0]['nama']))
                                            {{ $history->hasil_rekomendasi_copras[0]['nama'] }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        Belum ada riwayat prediksi.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $histories->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>