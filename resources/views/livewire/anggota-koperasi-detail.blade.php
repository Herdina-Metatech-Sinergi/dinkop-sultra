<div>
    {{-- Success is as dangerous as failure. --}}

<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}


    <div class="mt-5">
        {{ $this->formHeader }}
        <p><br></p>

    </div>

    {{-- TABS --}}
    <div class="mt-5">
        <x-tab.tab tab="tabAnggota" defaultTab="tabcon-simpanan-pokok">
            <x-slot:navButton>
                <x-tab.nav-button tab="tabAnggota" id="tabcon-simpanan-pokok">
                    Simpanan Pokok
                </x-tab.nav-button>
                <x-tab.nav-button tab="tabAnggota" id="tabcon-simpanan-wajib">
                    Simpanan Wajib
                </x-tab.nav-button>
                <x-tab.nav-button tab="tabAnggota" id="tabcon-simpanan-sukarela">
                    Simpanan Sukarela
                </x-tab.nav-button>

            </x-slot:navButton>
            <x-slot:tabContainer>
                <x-tab.tab-container tab="tabAnggota" id="tabcon-simpanan-pokok">
                    <form wire:submit="create">
                        {{ $this->formSimpananPokok }}

                        <p><br></p>
                        <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
                            wire:click="submitSimpananPokok()">
                            <x-slot:custom_svg>
                                <x-button.svg.save />
                            </x-slot:custom_svg>
                            Simpan
                        </x-button.button>
                    </form>
                    <x-table-sm.table title="" subtitle="Simpanan Pokok" customClass='mt-5'>

                        <x-slot:th>
                            <x-table-sm.table-th>
                                Tanggal
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Nominal
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
                                    <x-table-sm.table-td customClass='text-right'>
                                        {{ @$data['nominal'] }}
                                        @php
                                            $total += $data['nominal'];
                                        @endphp
                                    </x-table-sm.table-td>

                                    <x-table-sm.table-td>
                                        <x-button.button-only-edit color="warning"
                                            wire:click="goUbahItemSimpananPokok({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-edit>
                                        <x-button.button-only-delete color="danger"
                                            onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                            wire:click="goHapusItemSimpananPokok({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-delete>
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
                                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                    Total
                                </x-table-sm.table-td>
                                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                    {{$total}}
                                </x-table-sm.table-td>
                            </x-table-sm.table-tr>
                        </x-slot:row>
                    </x-table-sm.table>
                </x-tab.tab-container>

                <x-tab.tab-container tab="tabAnggota" id="tabcon-simpanan-wajib">
                    <form wire:submit="create">
                        {{ $this->formSimpananWajib }}

                        <p><br></p>
                        <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
                            wire:click="submitSimpananWajib()">
                            <x-slot:custom_svg>
                                <x-button.svg.save />
                            </x-slot:custom_svg>
                            Simpan
                        </x-button.button>
                    </form>
                    <x-table-sm.table title="" subtitle="Simpanan Wajib" customClass='mt-5'>

                        <x-slot:th>
                            <x-table-sm.table-th>
                                Tanggal
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Nominal
                            </x-table-sm.table-th>

                            <x-table-sm.table-th>
                                Aksi
                            </x-table-sm.table-th>

                        </x-slot:th>
                        <x-slot:row>

                            @forelse ($simpanan_wajib ?? [] as $data)

                                <x-table-sm.table-tr>
                                    <x-table-sm.table-td>
                                        {{ @$data['tanggal'] }}
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td>
                                        {{ @$data['nominal'] }}
                                    </x-table-sm.table-td>

                                    <x-table-sm.table-td>
                                        <x-button.button-only-edit color="warning"
                                            wire:click="goUbahItemSimpananWajib({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-edit>
                                        <x-button.button-only-delete color="danger"
                                            onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                            wire:click="goHapusItemSimpananWajib({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-delete>
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
                                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                    Total
                                </x-table-sm.table-td>
                                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                    {{-- {{}} --}}
                                </x-table-sm.table-td>
                            </x-table-sm.table-tr>
                        </x-slot:row>
                    </x-table-sm.table>
                </x-tab.tab-container>

                <x-tab.tab-container tab="tabAnggota" id="tabcon-simpanan-sukarela">
                    <form wire:submit="create">
                        {{ $this->formSimpananSukarela }}

                        <p><br></p>
                        <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
                            wire:click="submitSimpananSukarela()">
                            <x-slot:custom_svg>
                                <x-button.svg.save />
                            </x-slot:custom_svg>
                            Simpan
                        </x-button.button>
                    </form>
                    <x-table-sm.table title="" subtitle="Simpanan Sukarela" customClass='mt-5'>

                        <x-slot:th>
                            <x-table-sm.table-th>
                                Tanggal
                            </x-table-sm.table-th>
                            <x-table-sm.table-th>
                                Nominal
                            </x-table-sm.table-th>

                            <x-table-sm.table-th>
                                Aksi
                            </x-table-sm.table-th>

                        </x-slot:th>
                        <x-slot:row>

                            @forelse ($simpanan_sukarela ?? [] as $data)

                                <x-table-sm.table-tr>
                                    <x-table-sm.table-td>
                                        {{ @$data['tanggal'] }}
                                    </x-table-sm.table-td>
                                    <x-table-sm.table-td>
                                        {{ @$data['nominal'] }}
                                    </x-table-sm.table-td>

                                    <x-table-sm.table-td>
                                        <x-button.button-only-edit color="warning"
                                            wire:click="goUbahItemSimpananSukarela({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-edit>
                                        <x-button.button-only-delete color="danger"
                                            onclick="confirm('Hapus item?') || event.stopImmediatePropagation()"
                                            wire:click="goHapusItemSimpananSukarela({{ $data['id'] }})"
                                            wire:loading.attr="disabled"
                                            wire:loading.class.delay="opacity-70 cursor-wait">
                                        </x-button.button-only-delete>
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
                                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                    Total
                                </x-table-sm.table-td>
                                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                                    {{-- {{}} --}}
                                </x-table-sm.table-td>
                            </x-table-sm.table-tr>
                        </x-slot:row>
                    </x-table-sm.table>
                </x-tab.tab-container>

            </x-slot:tabContainer>
        </x-tab.tab>
    </div>


</div>

</div>
