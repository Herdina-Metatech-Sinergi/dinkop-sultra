<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}
        <p style="font-size: 12px">
            Jika mengalami kendala, silakan <a href="https://wa.me/6285186060059" target="_blank">hubungi admin via WhatsApp disini</a>.
        </p>
        @if ($data['identitas'])
        <div class="p-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow-md">
            <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">Selamat datang, Koperasi {{ $data['identitas']->nama_koperasi }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Untuk melengkapi data dan melihat identitas koperasi, silahkan kunjungi
                <a href="{{url('admin/identitas-koperasis/'.$data['identitas']->id.'/edit')}}"
                   class="text-yellow-300 hover:text-yellow-400 underline dark:text-yellow-500 dark:hover:text-yellow-600 transition duration-300">
                   link berikut.
                </a>
            </p>
            <p><br></p>
            <p class="text-sm text-gray-500 dark:text-gray-400">Status Koperasi : @if (@$data['identitas']->status == 'Menunggu')
                {{-- <x-badge color="warning"> --}}
                    Menunggu Verifikasi
                {{-- </x-badge> --}}
            @elseif (@$data['identitas']->status == 'Setujui')
                {{-- <x-badge color="success"> --}}
                    Verifikasi Disetujui
                {{-- </x-badge> --}}
            @else
                {{-- <x-badge color="danger"> --}}
                    Verifikasi Ditolak
                {{-- </x-badge> --}}
            @endif

            </p>
        </div>
        @endif

        @if (auth()->user()->hasRole(['Admin Dinkop']))
        <div class="p-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg shadow-md">
            <h2 class="grid flex-1 text-base font-semibold leading-6 text-gray-950 dark:text-white">Selamat datang, Admin Dinkop </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Untuk menverifikasi identitas koperasi, silahkan kunjungi
                <a href="{{url('admin/identitas-koperasis/')}}"
                   class="text-yellow-300 hover:text-yellow-400 underline dark:text-yellow-500 dark:hover:text-yellow-600 transition duration-300">
                   link berikut.
                </a>
            </p>
        </div>
        @endif

        <img src="https://hartanahgroup.com/wp-content/uploads/2021/11/Koperasi_Digital-3335425.jpg" alt="">
    </x-filament::section>
</x-filament-widgets::widget>
