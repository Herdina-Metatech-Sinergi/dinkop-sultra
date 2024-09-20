<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}
        @if ($data['identitas'])
        <div class="p-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow-md">
            <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">Selamat datang, Koperasi {{ $data['identitas']->nama_koperasi }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Untuk melengkapi data dan melihat identitas koperasi, silahkan kunjungi
                <a href="{{url('admin/identitas-koperasis/'.$data['identitas']->id.'/edit')}}"
                   class="text-yellow-300 hover:text-yellow-400 underline dark:text-yellow-500 dark:hover:text-yellow-600 transition duration-300">
                   link berikut.
                </a>
            </p>
        </div>
        @endif

    </x-filament::section>
</x-filament-widgets::widget>
