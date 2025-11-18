<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pelanggan') }}: {{ $customer->nama_pelanggan }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                        @csrf
                        @method('PUT') <div>
                            <label for="nama_pelanggan" class="block font-medium text-sm text-gray-700">Nama
                                Pelanggan</label>
                            <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('nama_pelanggan') border-red-500 @enderror"
                                value="{{ old('nama_pelanggan', $customer->nama_pelanggan) }}" required autofocus>

                            @error('nama_pelanggan')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="no_telepon" class="block font-medium text-sm text-gray-700">No. Telepon</label>
                            <input type="text" id="no_telepon" name="no_telepon"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('no_telepon') border-red-500 @enderror"
                                value="{{ old('no_telepon', $customer->no_telepon) }}">

                            @error('no_telepon')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="alamat" class="block font-medium text-sm text-gray-700">Alamat</label>
                            <textarea id="alamat" name="alamat" rows="4"
                                class="block mt-1 w-full rounded-md shadow-sm border-gray-300 @error('alamat') border-red-500 @enderror">{{ old('alamat', $customer->alamat) }}</textarea>

                            @error('alamat')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4 space-x-2">
                            <a href="{{ route('customers.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
