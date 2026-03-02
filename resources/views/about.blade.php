<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Me') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-4 border-b pb-2">Biodata Mahasiswa</h3>
                    <ul class="space-y-2">
                        <li><strong>Nama:</strong> Hafiz Zada Maulana</li>
                        <li><strong>NIM:</strong> 20230140016</li>
                        <li><strong>Program Studi:</strong> Teknologi Informasi (UMY)</li>
                        <li><strong>Hobi:</strong> Modif Motor</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>