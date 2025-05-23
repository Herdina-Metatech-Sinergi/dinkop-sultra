<div>
    {{-- Success is as dangerous as failure. --}}

    <div>
        {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}


        <div class="mt-5">
            @if (auth()->user())
                {{ $this->formHeader }}
            @endif
            @if (auth()->user())
                <x-button.button color="primary" wire:loading.attr="disabled"
                    wire:loading.class.delay="opacity-70 cursor-wait" wire:click="prosesAnggotaKeluar()"
                    onclick="confirm('Proses keluar, tindakan tidak dapat dibatalkan?') || event.stopImmediatePropagation()">
                    <x-slot:custom_svg>
                        <x-button.svg.delete />
                    </x-slot:custom_svg>
                    Proses Anggota Keluar
                </x-button.button>
            @endif
            <p><br></p>


        </div>

        <x-table-sm.table title="" subtitle="" customClass=''>

            <x-slot:row>

                @foreach ($porto as $key => $item)
                    <x-table-sm.table-tr>

                        <x-table-sm.table-th customClass='text-center'>
                            {{ $key }}
                        </x-table-sm.table-th>
                        <x-table-sm.table-td>
                            {{ App\Http\Controllers\Controller::rupiah(@$item) }}
                        </x-table-sm.table-td>
                    </x-table-sm.table-tr>
                @endforeach

            </x-slot:row>

            {{-- </x-slot:th>
        <x-slot:th>


        </x-slot:th> --}}
        </x-table-sm.table>

        <p><br></p>
        {{-- TABS --}}
        <div class="mt-5">
            <x-tab.tab tab="tabAnggota" defaultTab="tabcon-simpanan">
                <x-slot:navButton>
                    <!-- Main Menu -->
                    <x-tab.nav-button tab="tabAnggota" id="tabcon-simpanan">
                        Simpan
                    </x-tab.nav-button>
                    <x-tab.nav-button tab="tabAnggota" id="tabcon-kredit">
                        Pinjam
                    </x-tab.nav-button>
                </x-slot:navButton>

                <x-slot:tabContainer>
                    <!-- Simpanan Section -->
                    <x-tab.tab-container tab="tabAnggota" id="tabcon-simpanan">
                        <x-tab.tab tab="tabSimpanan" defaultTab="tabcon-simpanan-modal">
                            <x-slot:navButton>
                                <!-- Submenus under Simpanan -->
                                <x-tab.nav-button tab="tabSimpanan" id="tabcon-simpanan-modal">
                                    Simpanan Modal
                                </x-tab.nav-button>
                                <x-tab.nav-button tab="tabSimpanan" id="tabcon-simpanan-lainnya">
                                    {{ $identitas_koperasi->nama_simpanan_lainnya ?? 'Simpanan Lainnya' }}
                                </x-tab.nav-button>
                                <x-tab.nav-button tab="tabSimpanan" id="tabcon-simpanan-non-modal">
                                    Simpanan Non Modal
                                </x-tab.nav-button>
                            </x-slot:navButton>

                            <x-slot:tabContainer>
                                <!-- Simpanan Modal (Simpanan Pokok and Simpanan Wajib) -->
                                <x-tab.tab-container tab="tabSimpanan" id="tabcon-simpanan-modal">
                                    <x-tab.tab tab="tabModal" defaultTab="tabcon-simpanan-pokok">
                                        <x-slot:navButton>
                                            <x-tab.nav-button tab="tabModal" id="tabcon-simpanan-pokok">
                                                Simpanan Pokok
                                            </x-tab.nav-button>
                                            <x-tab.nav-button tab="tabModal" id="tabcon-simpanan-wajib">
                                                Simpanan Wajib
                                            </x-tab.nav-button>
                                        </x-slot:navButton>

                                        <x-slot:tabContainer>
                                            <!-- Simpanan Pokok Form and Table -->
                                            <x-tab.tab-container tab="tabModal" id="tabcon-simpanan-pokok">
                                                <form wire:submit.prevent="submitSimpananPokok">
                                                    @if (auth()->user())
                                                        {{ $this->formSimpananPokok }}
                                                    @endif
                                                    <p><br></p>
                                                    @if (auth()->user())
                                                        <x-button.button color="primary" wire:loading.attr="disabled"
                                                            wire:loading.class.delay="opacity-70 cursor-wait"
                                                            wire:click="submitSimpananPokok()">
                                                            <x-slot:custom_svg>
                                                                <x-button.svg.save />
                                                            </x-slot:custom_svg>
                                                            Simpan
                                                        </x-button.button>
                                                    @endif
                                                </form>
                                                <x-table-sm.table title="" subtitle="Simpanan Pokok"
                                                    customClass='mt-5'>

                                                    <x-slot:th>
                                                        <x-table-sm.table-th>
                                                            Tanggal
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Deskripsi
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Debet
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Kredit
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Saldo
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Aksi
                                                        </x-table-sm.table-th>

                                                    </x-slot:th>
                                                    <x-slot:row>

                                                        @php
                                                            $total = 0;
                                                        @endphp
                                                        @forelse ($simpanan_pokok ?? [] as $data)
                                                            <x-table-sm.table-tr>
                                                                <x-table-sm.table-td>
                                                                    {{ @$data['tanggal'] }}
                                                                </x-table-sm.table-td>
                                                                <x-table-sm.table-td>
                                                                    {{ @$data['deskripsi'] }}
                                                                </x-table-sm.table-td>
                                                                <x-table-sm.table-td customClass='text-right'>
                                                                    @if ($data['d_k'] == 'Debet')
                                                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}
                                                                    @endif
                                                                </x-table-sm.table-td>

                                                                <x-table-sm.table-td customClass='text-right'>
                                                                    @if ($data['d_k'] == 'Kredit')
                                                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}
                                                                    @endif
                                                                </x-table-sm.table-td>
                                                                <x-table-sm.table-td customClass='text-right'>
                                                                    @if ($data['d_k'] == 'Debet')
                                                                        @php
                                                                            $total += $data['nominal'];

                                                                        @endphp
                                                                    @endif
                                                                    @if ($data['d_k'] == 'Kredit')
                                                                        @php
                                                                            $total -= $data['nominal'];

                                                                        @endphp
                                                                    @endif
                                                                    {{ App\Http\Controllers\Controller::rupiah(@$total) }}

                                                                </x-table-sm.table-td>

                                                                <x-table-sm.table-td>
                                                                    @if (auth()->user())
                                                                        <x-button.button-only-edit color="warning"
                                                                            wire:click="goUbahItemSimpananPokok({{ $data['id'] }})"
                                                                            wire:loading.attr="disabled"
                                                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                                                        </x-button.button-only-edit> Ubah
                                                                        <x-button.button-only-delete color="danger"
                                                                            onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                                                            wire:click="goHapusItemSimpananPokok({{ $data['id'] }})"
                                                                            wire:loading.attr="disabled"
                                                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                                                        </x-button.button-only-delete> Hapus
                                                                    @endif
                                                                </x-table-sm.table-td>
                                                            </x-table-sm.table-tr>
                                                        @empty
                                                            <x-table-sm.table-tr>
                                                                <x-table-sm.table-td-full-colspan>
                                                                    Data kosong
                                                                </x-table-sm.table-td-full-colspan>
                                                            </x-table-sm.table-tr>
                                                        @endforelse

                                                        <x-table-sm.table-tr>
                                                            <x-table-sm.table-td colspan='4'
                                                                customClass='border-0 text-right font-bold'>
                                                                Total
                                                            </x-table-sm.table-td>
                                                            <x-table-sm.table-td colspan='1'
                                                                customClass='border-0 text-right font-bold'>
                                                                {{ App\Http\Controllers\Controller::rupiah($total) }}
                                                            </x-table-sm.table-td>
                                                        </x-table-sm.table-tr>
                                                    </x-slot:row>
                                                </x-table-sm.table>
                                            </x-tab.tab-container>

                                            <!-- Simpanan Wajib Form and Table -->
                                            <x-tab.tab-container tab="tabModal" id="tabcon-simpanan-wajib">
                                                <form wire:submit.prevent="submitSimpananWajib">
                                                    @if (auth()->user())
                                                        {{ $this->formSimpananWajib }}
                                                    @endif
                                                    <p><br></p>
                                                    @if (auth()->user())
                                                        <x-button.button color="primary" wire:loading.attr="disabled"
                                                            wire:loading.class.delay="opacity-70 cursor-wait"
                                                            wire:click="submitSimpananWajib()">
                                                            <x-slot:custom_svg>
                                                                <x-button.svg.save />
                                                            </x-slot:custom_svg>
                                                            Simpan
                                                        </x-button.button>
                                                    @endif
                                                </form>
                                                <x-table-sm.table title="" subtitle="Simpanan Wajib"
                                                    customClass='mt-5'>

                                                    <x-slot:th>
                                                        <x-table-sm.table-th>
                                                            Tanggal
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Deskripsi
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Debet
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Kredit
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Saldo
                                                        </x-table-sm.table-th>
                                                        <x-table-sm.table-th>
                                                            Aksi
                                                        </x-table-sm.table-th>

                                                    </x-slot:th>
                                                    <x-slot:row>
                                                        @php
                                                            $total_simwa = 0;
                                                        @endphp
                                                        @forelse ($simpanan_wajib ?? [] as $data)
                                                            <x-table-sm.table-tr>
                                                                <x-table-sm.table-td>
                                                                    {{ @$data['tanggal'] }}
                                                                </x-table-sm.table-td>
                                                                <x-table-sm.table-td>
                                                                    {{ @$data['deskripsi'] }}
                                                                </x-table-sm.table-td>
                                                                <x-table-sm.table-td customClass='text-right'>
                                                                    @if ($data['d_k'] == 'Debet')
                                                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}
                                                                    @endif
                                                                </x-table-sm.table-td>

                                                                <x-table-sm.table-td customClass='text-right'>
                                                                    @if ($data['d_k'] == 'Kredit')
                                                                        {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}
                                                                    @endif
                                                                </x-table-sm.table-td>
                                                                <x-table-sm.table-td customClass='text-right'>
                                                                    @if ($data['d_k'] == 'Debet')
                                                                        @php
                                                                            $total_simwa += $data['nominal'];

                                                                        @endphp
                                                                    @endif
                                                                    @if ($data['d_k'] == 'Kredit')
                                                                        @php
                                                                            $total_simwa -= $data['nominal'];

                                                                        @endphp
                                                                    @endif
                                                                    {{ App\Http\Controllers\Controller::rupiah(@$total_simwa) }}

                                                                </x-table-sm.table-td>

                                                                <x-table-sm.table-td>
                                                                    @if (auth()->user())
                                                                        <x-button.button-only-edit color="warning"
                                                                            wire:click="goUbahItemSimpananWajib({{ $data['id'] }})"
                                                                            wire:loading.attr="disabled"
                                                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                                                        </x-button.button-only-edit> Ubah
                                                                        <x-button.button-only-delete color="danger"
                                                                            onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                                                            wire:click="goHapusItemSimpananWajib({{ $data['id'] }})"
                                                                            wire:loading.attr="disabled"
                                                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                                                        </x-button.button-only-delete> Hapus
                                                                    @endif
                                                                </x-table-sm.table-td>
                                                            </x-table-sm.table-tr>
                                                        @empty
                                                            <x-table-sm.table-tr>
                                                                <x-table-sm.table-td-full-colspan>
                                                                    Data kosong
                                                                </x-table-sm.table-td-full-colspan>
                                                            </x-table-sm.table-tr>
                                                        @endforelse

                                                        <x-table-sm.table-tr>
                                                            <x-table-sm.table-td colspan='4'
                                                                customClass='border-0 text-right font-bold'>
                                                                Total
                                                            </x-table-sm.table-td>
                                                            <x-table-sm.table-td colspan='1'
                                                                customClass='border-0 text-right font-bold'>
                                                                {{ App\Http\Controllers\Controller::rupiah($total_simwa) }}
                                                            </x-table-sm.table-td>
                                                        </x-table-sm.table-tr>
                                                    </x-slot:row>
                                                </x-table-sm.table>
                                            </x-tab.tab-container>
                                        </x-slot:tabContainer>
                                    </x-tab.tab>
                                </x-tab.tab-container>

                                <x-tab.tab-container tab="tabSimpanan" id="tabcon-simpanan-lainnya">
                                    <!-- Input untuk menambahkan menu baru -->
                                    <form wire:submit.prevent="submitSimpananLainnya">
                                        @if (auth()->user())
                                            {{ $this->formSimpananLainnya }}
                                        @endif
                                        <p><br></p>
                                        @if (auth()->user())
                                            <x-button.button color="primary" wire:loading.attr="disabled"
                                                wire:loading.class.delay="opacity-70 cursor-wait"
                                                wire:click="submitSimpananLainnya()">
                                                <x-slot:custom_svg>
                                                    <x-button.svg.save />
                                                </x-slot:custom_svg>
                                                Simpan
                                            </x-button.button>
                                        @endif
                                    </form>
                                    <x-table-sm.table title=""
                                        subtitle="{{ $identitas_koperasi->nama_simpanan_lainnya ?? 'Simpanan Lainnya' }}"
                                        customClass='mt-5'>

                                        <x-slot:th>
                                            <x-table-sm.table-th>
                                                Tanggal
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th>
                                                Deskripsi
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th>
                                                Debet
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th>
                                                Kredit
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th>
                                                Saldo
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th>
                                                Aksi
                                            </x-table-sm.table-th>

                                        </x-slot:th>
                                        <x-slot:row>

                                            @php
                                                $total = 0;
                                            @endphp
                                            @forelse ($simpanan_lainnya ?? [] as $data)
                                                <x-table-sm.table-tr>
                                                    <x-table-sm.table-td>
                                                        {{ @$data['tanggal'] }}
                                                    </x-table-sm.table-td>
                                                    <x-table-sm.table-td>
                                                        {{ @$data['deskripsi'] }}
                                                    </x-table-sm.table-td>
                                                    <x-table-sm.table-td customClass='text-right'>
                                                        @if ($data['d_k'] == 'Debet')
                                                            {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}
                                                        @endif
                                                    </x-table-sm.table-td>

                                                    <x-table-sm.table-td customClass='text-right'>
                                                        @if ($data['d_k'] == 'Kredit')
                                                            {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}
                                                        @endif
                                                    </x-table-sm.table-td>
                                                    <x-table-sm.table-td customClass='text-right'>
                                                        @if ($data['d_k'] == 'Debet')
                                                            @php
                                                                $total += $data['nominal'];

                                                            @endphp
                                                        @endif
                                                        @if ($data['d_k'] == 'Kredit')
                                                            @php
                                                                $total -= $data['nominal'];

                                                            @endphp
                                                        @endif
                                                        {{ App\Http\Controllers\Controller::rupiah(@$total) }}

                                                    </x-table-sm.table-td>

                                                    <x-table-sm.table-td>
                                                        @if (auth()->user())
                                                            <x-button.button-only-edit color="warning"
                                                                wire:click="goUbahItemSimpananLainnya({{ $data['id'] }})"
                                                                wire:loading.attr="disabled"
                                                                wire:loading.class.delay="opacity-70 cursor-wait">
                                                            </x-button.button-only-edit> Ubah
                                                            <x-button.button-only-delete color="danger"
                                                                onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                                                wire:click="goHapusItemSimpananLainnya({{ $data['id'] }})"
                                                                wire:loading.attr="disabled"
                                                                wire:loading.class.delay="opacity-70 cursor-wait">
                                                            </x-button.button-only-delete> Hapus
                                                        @endif
                                                    </x-table-sm.table-td>
                                                </x-table-sm.table-tr>
                                            @empty
                                                <x-table-sm.table-tr>
                                                    <x-table-sm.table-td-full-colspan>
                                                        Data kosong
                                                    </x-table-sm.table-td-full-colspan>
                                                </x-table-sm.table-tr>
                                            @endforelse

                                            <x-table-sm.table-tr>
                                                <x-table-sm.table-td colspan='4'
                                                    customClass='border-0 text-right font-bold'>
                                                    Total
                                                </x-table-sm.table-td>
                                                <x-table-sm.table-td colspan='1'
                                                    customClass='border-0 text-right font-bold'>
                                                    {{ App\Http\Controllers\Controller::rupiah($total) }}
                                                </x-table-sm.table-td>
                                            </x-table-sm.table-tr>
                                        </x-slot:row>
                                    </x-table-sm.table>
                                </x-tab.tab-container>
                                <!-- Simpanan Non Modal Section -->
                                <x-tab.tab-container tab="tabSimpanan" id="tabcon-simpanan-non-modal">
                                    <!-- Input untuk menambahkan menu baru -->
                                    @if (auth()->user())
                                        <div class="flex items-center mt-5">
                                            <x-input.input-sm wire:model="new_menu_name"
                                                placeholder="Nama Menu Baru" />
                                            <x-button.button wire:click="addNewMenu" color="primary"
                                                wire:loading.class.delay="opacity-70 cursor-wait">Tambah
                                                Menu</x-button.button>
                                        </div>
                                    @endif
                                    <x-tab.tab tab="tabNonModal"
                                        defaultTab="tabcon-{{ $non_modal_menus[0]->id ?? '-' }}">

                                        <x-slot:navButton>
                                            @foreach ($non_modal_menus as $menu)
                                                <x-tab.nav-button tab="tabNonModal" id="tabcon-{{ $menu->id }}"
                                                    wire:click='setMenu({{ $menu->id }})'>
                                                    {{ $menu->nama_menu }}
                                                </x-tab.nav-button>
                                            @endforeach
                                        </x-slot:navButton>

                                        <x-slot:tabContainer>

                                            @foreach ($non_modal_menus as $menu)
                                                <x-tab.tab-container tab="tabNonModal"
                                                    id="tabcon-{{ $menu->id }}">
                                                    <form>
                                                        <!-- Tampilkan formulir yang dihasilkan sesuai dengan menu -->
                                                        @if (auth()->user())
                                                            {{ $this->formSimpananSukarela ?? '' }}
                                                        @endif
                                                        <p><br></p>
                                                        @if (auth()->user())
                                                            <x-button.button color="primary"
                                                                wire:loading.attr="disabled"
                                                                wire:loading.class.delay="opacity-70 cursor-wait"
                                                                wire:click="submitSimpananNonModal()">
                                                                Simpan
                                                            </x-button.button>
                                                        @endif
                                                        <p><br></p>

                                                        <hr>
                                                        <p><br></p>

                                                        <h3>Hitung Jasa</h3>
                                                        @if (auth()->user())
                                                            {{ $this->formSimpananSukarelaJasa ?? '' }}
                                                        @endif
                                                        <p><br></p>
                                                        @if (auth()->user())
                                                            <x-button.button color="primary"
                                                                wire:loading.attr="disabled"
                                                                wire:loading.class.delay="opacity-70 cursor-wait"
                                                                wire:click="submitSimpananNonModalJasa()">
                                                                Simpan
                                                            </x-button.button>
                                                        @endif

                                                        <p><br></p>
                                                        <hr>
                                                        <p><br></p>

                                                        <h3>Administrasi Perbulan</h3>
                                                        @if (auth()->user())
                                                            {{ $this->formSimpananSukarelaAdmin ?? '' }}
                                                        @endif
                                                        <p><br></p>
                                                        @if (auth()->user())
                                                            <x-button.button color="primary"
                                                                wire:loading.attr="disabled"
                                                                wire:loading.class.delay="opacity-70 cursor-wait"
                                                                wire:click="submitSimpananNonModalAdmin()">
                                                                Simpan
                                                            </x-button.button>
                                                        @endif

                                                    </form>

                                                    <x-table-sm.table title="" subtitle="{{ $menu->name }}"
                                                        customClass='mt-5'>

                                                        <x-slot:th>
                                                            <x-table-sm.table-th>
                                                                Tanggal
                                                            </x-table-sm.table-th>
                                                            <x-table-sm.table-th>
                                                                Deskripsi
                                                            </x-table-sm.table-th>
                                                            <x-table-sm.table-th>
                                                                Debet
                                                            </x-table-sm.table-th>
                                                            <x-table-sm.table-th>
                                                                Kredit
                                                            </x-table-sm.table-th>
                                                            <x-table-sm.table-th>
                                                                Saldo
                                                            </x-table-sm.table-th>
                                                            <x-table-sm.table-th>
                                                                Aksi
                                                            </x-table-sm.table-th>

                                                        </x-slot:th>
                                                        <x-slot:row>
                                                            @php
                                                                $total_simsuk = 0;
                                                            @endphp
                                                            @forelse ($simpanan_sukarela ?? [] as $data)
                                                                <x-table-sm.table-tr>
                                                                    <x-table-sm.table-td>
                                                                        {{ @$data['tanggal'] }}
                                                                    </x-table-sm.table-td>
                                                                    <x-table-sm.table-td>
                                                                        {{ @$data['deskripsi'] }}
                                                                    </x-table-sm.table-td>
                                                                    <x-table-sm.table-td customClass='text-right'>
                                                                        @if ($data['d_k'] == 'Debet')
                                                                            {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}
                                                                        @endif
                                                                    </x-table-sm.table-td>

                                                                    <x-table-sm.table-td customClass='text-right'>
                                                                        @if ($data['d_k'] == 'Kredit')
                                                                            {{ App\Http\Controllers\Controller::rupiah(@$data['nominal']) }}
                                                                        @endif
                                                                    </x-table-sm.table-td>
                                                                    <x-table-sm.table-td customClass='text-right'>
                                                                        @if ($data['d_k'] == 'Debet')
                                                                            @php
                                                                                $total_simsuk += $data['nominal'];

                                                                            @endphp
                                                                        @endif
                                                                        @if ($data['d_k'] == 'Kredit')
                                                                            @php
                                                                                $total_simsuk -= $data['nominal'];

                                                                            @endphp
                                                                        @endif
                                                                        {{ App\Http\Controllers\Controller::rupiah(@$total_simsuk) }}

                                                                    </x-table-sm.table-td>

                                                                    <x-table-sm.table-td>
                                                                        @if (auth()->user())
                                                                            <x-button.button-only-edit color="warning"
                                                                                wire:click="goUbahItemSimpananSukarela({{ $data['id'] }})"
                                                                                wire:loading.attr="disabled"
                                                                                wire:loading.class.delay="opacity-70 cursor-wait">
                                                                            </x-button.button-only-edit> Ubah
                                                                            <x-button.button-only-delete color="danger"
                                                                                onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                                                                wire:click="goHapusItemSimpananSukarela({{ $data['id'] }})"
                                                                                wire:loading.attr="disabled"
                                                                                wire:loading.class.delay="opacity-70 cursor-wait">
                                                                            </x-button.button-only-delete> Hapus
                                                                        @endif
                                                                    </x-table-sm.table-td>
                                                                </x-table-sm.table-tr>
                                                            @empty
                                                                <x-table-sm.table-tr>
                                                                    <x-table-sm.table-td-full-colspan>
                                                                        Data kosong
                                                                    </x-table-sm.table-td-full-colspan>
                                                                </x-table-sm.table-tr>
                                                            @endforelse

                                                            <x-table-sm.table-tr>
                                                                <x-table-sm.table-td colspan='4'
                                                                    customClass='border-0 text-right font-bold'>
                                                                    Total
                                                                </x-table-sm.table-td>
                                                                <x-table-sm.table-td colspan='1'
                                                                    customClass='border-0 text-right font-bold'>
                                                                    {{ App\Http\Controllers\Controller::rupiah($total_simsuk) }}
                                                                </x-table-sm.table-td>
                                                            </x-table-sm.table-tr>
                                                        </x-slot:row>
                                                    </x-table-sm.table>
                                                </x-tab.tab-container>
                                            @endforeach


                                        </x-slot:tabContainer>
                                    </x-tab.tab>
                                </x-tab.tab-container>


                            </x-slot:tabContainer>
                        </x-tab.tab>
                    </x-tab.tab-container>

                    <!-- Kredit Section -->
                    <x-tab.tab-container tab="tabAnggota" id="tabcon-kredit">
                        <x-tab.tab tab="tabPinjaman" defaultTab="tabcon-flat">
                            <x-slot:navButton>
                                <!-- Submenus under Simpanan -->
                                <x-tab.nav-button tab="tabPinjaman" id="tabcon-flat">
                                    Flat
                                </x-tab.nav-button>
                                <x-tab.nav-button tab="tabPinjaman" id="tabcon-efektif">
                                    Konvensional
                                </x-tab.nav-button>
                            </x-slot:navButton>

                            <x-slot:tabContainer>

                                <x-tab.tab-container tab="tabPinjaman" id="tabcon-flat">
                                    <form wire:submit.prevent="submitKredit">
                                        @if (auth()->user())
                                            {{ $this->formKredit }}
                                        @endif
                                        <p><br></p>
                                        @if (auth()->user())
                                            <x-button.button color="primary" wire:loading.attr="disabled"
                                                wire:loading.class.delay="opacity-70 cursor-wait"
                                                wire:click="submitKredit()">
                                                <x-slot:custom_svg>
                                                    <x-button.svg.save />
                                                </x-slot:custom_svg>
                                                Submit
                                            </x-button.button>
                                        @endif
                                    </form>
                                    <x-table-sm.table title="" subtitle="" customClass=''>
                                        <x-slot:th>
                                            <x-table-sm.table-th customClass='text-center'>
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th customClass='text-center'>
                                                Kredit
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th customClass='text-center'>
                                                No Pinjaman
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th customClass='text-right'>
                                                Nominal Pinjaman
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th customClass='text-right'>
                                                Agunan
                                            </x-table-sm.table-th>

                                            <x-table-sm.table-th customClass='text-right'>
                                                Nominal Dibayarkan
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th customClass='text-right'>
                                                Suku Jasa per Bulan (%)
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th customClass='text-right'>
                                                Angsuran/Bulan
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th customClass='text-center'>
                                                Tenor (bulan)
                                            </x-table-sm.table-th>
                                            <x-table-sm.table-th customClass='text-center'>
                                                Aksi
                                            </x-table-sm.table-th>

                                        </x-slot:th>
                                        <x-slot:row>
                                            @forelse ($kredit ?? [] as $data)
                                                <div>
                                                    <x-table-sm.table-tr>
                                                        <x-table-sm.table-td customClass="text-center">
                                                            <x-button.button-text color="gray"
                                                                wire:click="goToggleShowKredit({{ $data['id'] }})">
                                                                <x-slot:custom_svg>
                                                                    @if (in_array($data['id'], $index_open_kredit))
                                                                        <x-button.svg.minus customClass="ml-0" />
                                                                    @else
                                                                        <x-button.svg.plus customClass="ml-0" />
                                                                    @endif
                                                                </x-slot:custom_svg>
                                                            </x-button.button-text>
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td>
                                                            {{ $data['kredit'] }}
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td customClass="text-center">
                                                            {{ $data['keterangan'] }}
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td>
                                                            {{ App\Http\Controllers\Controller::rupiah(@$data['nominal_pinjaman']) }}
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td customClass="text-center">
                                                            {{ $data['agunan'] }}
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td>
                                                            {{ App\Http\Controllers\Controller::rupiah(@$data['nominal_bayar']) }}
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td>
                                                            {{ @$data['interest_rate'] }} %
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td>
                                                            {{ App\Http\Controllers\Controller::rupiah(@$data['angsuran_bulan']) }}
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td>
                                                            {{ @$data['num_installments'] }}
                                                        </x-table-sm.table-td>
                                                        <x-table-sm.table-td>
                                                            @if (auth()->user())
                                                                <x-button.button-only-edit color="warning"
                                                                    wire:click="goUbahItemKredit({{ $data['id'] }})"
                                                                    wire:loading.attr="disabled"
                                                                    wire:loading.class.delay="opacity-70 cursor-wait">
                                                                </x-button.button-only-edit> Ubah
                                                                <x-button.button-only-delete color="danger"
                                                                    onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                                                    wire:click="goHapusItemKredit({{ $data['id'] }})"
                                                                    wire:loading.attr="disabled"
                                                                    wire:loading.class.delay="opacity-70 cursor-wait">
                                                                </x-button.button-only-delete> Hapus
                                                            @endif
                                                        </x-table-sm.table-td>
                                                    </x-table-sm.table-tr>

                                                    @php
                                                        $_is_hidden = 'hidden';
                                                        if (in_array($data['id'], $index_open_kredit)) {
                                                            $_is_hidden = '';
                                                        }
                                                    @endphp
                                                    <x-table-sm.table-tr customClass="{{ $_is_hidden }}"
                                                        wire:key="{{ 'tabDetailKredit' . @$data['id'] }}">
                                                        <x-table-sm.table-td colspan='999'
                                                            customStyle='background-color: rgba(30, 136, 229, 0.3);'>

                                                            <x-table-sm.table title="" subtitle=""
                                                                customClass='mt-0'>
                                                                <x-slot:th>
                                                                    <x-table-sm.table-th customClass='text-center'>
                                                                        Tgl
                                                                    </x-table-sm.table-th>
                                                                    <x-table-sm.table-th customClass='text-center'>
                                                                        Angsuran
                                                                    </x-table-sm.table-th>
                                                                    <x-table-sm.table-th customClass='text-center'>
                                                                        Angsuran Pokok
                                                                    </x-table-sm.table-th>
                                                                    <x-table-sm.table-th customClass='text-center'>
                                                                        Status Pokok
                                                                    </x-table-sm.table-th>
                                                                    <x-table-sm.table-th customClass='text-center'>
                                                                        Angsuran Jasa
                                                                    </x-table-sm.table-th>
                                                                    <x-table-sm.table-th customClass='text-center'>
                                                                        Status Bunga
                                                                    </x-table-sm.table-th>
                                                                    <x-table-sm.table-th customClass='text-center'>
                                                                        Baki Debet
                                                                    </x-table-sm.table-th>
                                                                    <x-table-sm.table-th customClass='text-center'>
                                                                        Aksi
                                                                    </x-table-sm.table-th>
                                                                </x-slot:th>

                                                                <x-slot:row>
                                                                    @php
                                                                        $total_kredit = 0;
                                                                        $total_kredit_lunas = 0;
                                                                    @endphp
                                                                    @forelse ($data['kredit_angsuran'] ?? [] as $data2)
                                                                        <x-table-sm.table-tr>
                                                                            <x-table-sm.table-td>
                                                                                @if (auth()->user())
                                                                                    @if (@$data2['status_pokok'] == 'Belum Lunas')
                                                                                        <x-input.input-sm
                                                                                            type="date"
                                                                                            wire:model="angsuran.{{ $data2['id'] }}.tanggal_jatuh_tempo"
                                                                                            value="{{ @$data2['tanggal_jatuh_tempo'] }}"
                                                                                            class="form-input w-full text-center"
                                                                                            wire:change="updateAngsuran({{ $data2['id'] }}, 'tanggal_jatuh_tempo')" />
                                                                                    @else
                                                                                        {{ @$data2['tanggal_jatuh_tempo'] }}
                                                                                    @endif
                                                                                @else
                                                                                    {{ @$data2['tanggal_jatuh_tempo'] }}
                                                                                @endif
                                                                            </x-table-sm.table-td>

                                                                            <x-table-sm.table-td>
                                                                                {{ @$data2['angsuran_ke'] }}
                                                                            </x-table-sm.table-td>

                                                                            <x-table-sm.table-td class='text-right'>
                                                                                @if (auth()->user())
                                                                                    @if (@$data2['status_pokok'] == 'Belum Lunas')
                                                                                        <x-input.input-sm
                                                                                            type="number"
                                                                                            value="{{ @$data2['nominal_pokok'] }}"
                                                                                            wire:model="angsuran.{{ $data2['id'] }}.nominal_pokok"
                                                                                            class="form-input w-full text-right"
                                                                                            wire:change="updateAngsuran({{ $data2['id'] }}, 'nominal_pokok')" />
                                                                                    @else
                                                                                        {{ App\Http\Controllers\Controller::rupiah(@$data2['nominal_pokok']) }}
                                                                                    @endif
                                                                                @else
                                                                                    {{ App\Http\Controllers\Controller::rupiah(@$data2['nominal_pokok']) }}
                                                                                @endif
                                                                            </x-table-sm.table-td>

                                                                            <x-table-sm.table-td>
                                                                                {{ @$data2['status_pokok'] }}
                                                                                @php
                                                                                    if (
                                                                                        $data2['status_pokok'] ==
                                                                                        'Lunas'
                                                                                    ) {
                                                                                        $total_kredit_lunas +=
                                                                                            $data2['nominal_pokok'];
                                                                                    }
                                                                                    $total_kredit +=
                                                                                        $data2['nominal_pokok'];
                                                                                @endphp
                                                                            </x-table-sm.table-td>

                                                                            <x-table-sm.table-td class='text-right'>
                                                                                {{ App\Http\Controllers\Controller::rupiah(@$data2['nominal_bunga']) }}
                                                                            </x-table-sm.table-td>

                                                                            <x-table-sm.table-td>
                                                                                {{ @$data2['status_bunga'] }}
                                                                                @php
                                                                                    if (
                                                                                        $data2['status_bunga'] ==
                                                                                        'Lunas'
                                                                                    ) {
                                                                                        $total_kredit_lunas +=
                                                                                            $data2['nominal_bunga'];
                                                                                    }
                                                                                    $total_kredit +=
                                                                                        $data2['nominal_bunga'];
                                                                                @endphp
                                                                            </x-table-sm.table-td>

                                                                            <x-table-sm.table-td class='text-right'>
                                                                                {{ App\Http\Controllers\Controller::rupiah($data2['baki_debet']) }}
                                                                            </x-table-sm.table-td>

                                                                            <x-table-sm.table-td class='text-center'>
                                                                                @if (auth()->user())
                                                                                    @if ($data2['status_pokok'] != 'Lunas')
                                                                                        <x-button.button-only-add
                                                                                            color="danger"
                                                                                            onclick="confirm('Bayar angsuran pokok?') || event.stopImmediatePropagation()"
                                                                                            wire:click="goBayarAngsuranPokok({{ $data2['id'] }})"
                                                                                            wire:loading.attr="disabled"
                                                                                            wire:loading.class.delay="opacity-70 cursor-wait">

                                                                                        </x-button.button-only-add>
                                                                                        Bayar Pokok
                                                                                    @endif

                                                                                    @if ($data2['status_bunga'] != 'Lunas')
                                                                                        <x-button.button-only-add
                                                                                            color="danger"
                                                                                            onclick="confirm('Bayar angsuran Jasa?') || event.stopImmediatePropagation()"
                                                                                            wire:click="goBayarAngsuranJasa({{ $data2['id'] }})"
                                                                                            wire:loading.attr="disabled"
                                                                                            wire:loading.class.delay="opacity-70 cursor-wait">

                                                                                        </x-button.button-only-add>
                                                                                        Bayar Bunga
                                                                                    @endif
                                                                                @endif
                                                                            </x-table-sm.table-td>
                                                                        </x-table-sm.table-tr>
                                                                    @empty
                                                                        <x-table-sm.table-tr>
                                                                            <x-table-sm.table-td-full-colspan>
                                                                                Data kosong
                                                                            </x-table-sm.table-td-full-colspan>
                                                                        </x-table-sm.table-tr>
                                                                    @endforelse

                                                                    <x-table-sm.table-tr>
                                                                        <x-table-sm.table-td colspan='6'
                                                                            customClass='border-0 text-right font-bold'>
                                                                            Total
                                                                        </x-table-sm.table-td>
                                                                        <x-table-sm.table-td colspan='1'
                                                                            customClass='border-0 text-right font-bold'>
                                                                            {{ App\Http\Controllers\Controller::rupiah($total_kredit) }}
                                                                        </x-table-sm.table-td>
                                                                    </x-table-sm.table-tr>

                                                                    <x-table-sm.table-tr>
                                                                        <x-table-sm.table-td colspan='6'
                                                                            customClass='border-0 text-right font-bold'>
                                                                            Total Lunas
                                                                        </x-table-sm.table-td>
                                                                        <x-table-sm.table-td colspan='1'
                                                                            customClass='border-0 text-right font-bold'>
                                                                            {{ App\Http\Controllers\Controller::rupiah($total_kredit_lunas) }}
                                                                        </x-table-sm.table-td>
                                                                    </x-table-sm.table-tr>

                                                                    <x-table-sm.table-tr>
                                                                        <x-table-sm.table-td colspan='6'
                                                                            customClass='border-0 text-right font-bold'>
                                                                            Total Hutang
                                                                        </x-table-sm.table-td>
                                                                        <x-table-sm.table-td colspan='1'
                                                                            customClass='border-0 text-right font-bold'>
                                                                            {{ App\Http\Controllers\Controller::rupiah($total_kredit - $total_kredit_lunas) }}
                                                                        </x-table-sm.table-td>
                                                                    </x-table-sm.table-tr>

                                                                    @if ($total_kredit - $total_kredit_lunas != 0)
                                                                        <x-table-sm.table-tr>
                                                                            <x-table-sm.table-td colspan='6'
                                                                                customClass='border-0 text-right font-bold'>
                                                                                Jadikan Hutang Baru (TopUp)
                                                                            </x-table-sm.table-td>
                                                                            <x-table-sm.table-td colspan='1'
                                                                                customClass='border-0 text-right font-bold'>
                                                                                @if (auth()->user())

                                                                                <x-button.button color="primary"
                                                                                    wire:loading.attr="disabled"
                                                                                    wire:loading.class.delay="opacity-70 cursor-wait"
                                                                                    wire:click="buatHutangBaru('{{ $total_kredit - $total_kredit_lunas }}')">
                                                                                    <x-slot:custom_svg>
                                                                                        <x-button.svg.plus />
                                                                                    </x-slot:custom_svg>
                                                                                    Buat
                                                                                </x-button.button>

                                                                                @endif
                                                                            </x-table-sm.table-td>
                                                                        </x-table-sm.table-tr>
                                                                    @endif

                                                                </x-slot:row>
                                                            </x-table-sm.table>


                                                        </x-table-sm.table-td>
                                                    </x-table-sm.table-tr>
                                                </div>
                                            @empty
                                                <x-table-sm.table-tr>
                                                    <x-table-sm.table-td-full-colspan>
                                                        Data kosong
                                                    </x-table-sm.table-td-full-colspan>
                                                </x-table-sm.table-tr>
                                            @endforelse

                                        </x-slot:row>
                                    </x-table-sm.table>
                                </x-tab.tab-container>

                                <x-tab.tab-container tab="tabPinjaman" id="tabcon-efektif">
                                    @livewire('anggota-koperasi-detail.kredit-konvensional', ['anggota_id' => $anggota_id, 'index_open_kredit' => $index_open_kredit])

                                </x-tab.tab-container>


                            </x-slot:tabContainer>
                        </x-tab.tab>
                    </x-tab.tab-container>
                </x-slot:tabContainer>
            </x-tab.tab>
        </div>


    </div>
</div>

@push('scripts')
    <script>
        function updateAngsuranJS(id, field, value) {
            console.log(id);
            console.log(field);
            console.log(value);
        }
    </script>
@endpush
