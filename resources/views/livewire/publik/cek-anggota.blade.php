<div class="w-full">
    {{-- Do your work, then step back. --}}

    @if (session()->has('message'))
        <div class="alert alert-info">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="stroke-current shrink-0 w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span> {{ session('message') }}
            </span>
        </div>
    @endif

    <div class="form-control  w-full max-w-lg">
        <label for="" class="label">Masukkan Nomor Anggota</label>
        <input type="number" class="input input-bordered w-full max-w-lg" wire:model='no_anggota' required>

        <label for="" class="label">Masukkan NIK</label>
        <input type="number" class="input input-bordered w-full max-w-lg" wire:model='nik' required>

        <p><br></p>
        <button class="btn btn-sm" wire:click='prosesNomor()'>Proses</button>
    </div>


    @if ($flag)
    @livewire('anggota-koperasi-detail',['anggota_id' => $anggotaId])

    @endif


</div>
