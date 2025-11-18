<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kendaraan') }}: {{ $vehicle->no_polisi }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="customer_id" class="block font-medium text-sm text-gray-700">Pemilik Kendaraan</label>
                            <select id="customer_id" name="customer_id" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('customer_id') border-red-500 @enderror" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', $vehicle->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->nama_pelanggan }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('customer_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="no_polisi" class="block font-medium text-sm text-gray-700">No. Polisi</label>
                            <input type="text" id="no_polisi" name="no_polisi" 
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('no_polisi') border-red-500 @enderror" 
                                   value="{{ old('no_polisi', $vehicle->no_polisi) }}" required>
                            @error('no_polisi')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="merek_motor" class="block font-medium text-sm text-gray-700">Merek Motor (Mis: Honda, Yamaha)</label>
                            <input type="text" id="merek_motor" name="merek_motor" 
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('merek_motor') border-red-500 @enderror"
                                   value="{{ old('merek_motor', $vehicle->merek_motor) }}" required>
                            @error('merek_motor')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="tipe_motor" class="block font-medium text-sm text-gray-700">Tipe Motor (Mis: Beat, Vario 125)</label>
                            <input type="text" id="tipe_motor" name="tipe_motor" 
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('tipe_motor') border-red-500 @enderror"
                                   value="{{ old('tipe_motor', $vehicle->tipe_motor) }}" required>
                            @error('tipe_motor')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="tahun_pembuatan" class="block font-medium text-sm text-gray-700">Tahun Pembuatan</label>
                            <input type="number" id="tahun_pembuatan" name="tahun_pembuatan" 
                                   class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('tahun_pembuatan') border-red-500 @enderror"
                                   value="{{ old('tahun_pembuatan', $vehicle->tahun_pembuatan) }}">
                            @error('tahun_pembuatan')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('vehicles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>