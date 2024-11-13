<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <div class="flex flex-row justify-center mt-5">
        <div class="px-2">
            <x-button.button color="primary" wire:loading.attr="disabled" wire:loading.class.delay="opacity-70 cursor-wait"
            wire:click="downloadPDF()">
                <x-slot:custom_svg>
                    <x-button.svg.print />
                </x-slot:custom_svg>
                Cetak
            </x-button.button>
        </div>

    </div>

    <br>

    <x-table-sm.table title="" subtitle="" customClass='mt-0'>
        <x-slot:th>
            <x-table-sm.table-th customClass='text-center'>
                No Anggota
            </x-table-sm.table-th>
            <x-table-sm.table-th customClass='text-center'>
                Nama
            </x-table-sm.table-th>


            @foreach ($menu as $men)
            <x-table-sm.table-th customClass='text-center'>
                {{$men}}
            </x-table-sm.table-th>
            @endforeach




        </x-slot:th>

        <x-slot:row>

            @forelse ($anggota as $data2)
                <x-table-sm.table-tr>
                    <x-table-sm.table-td>
                        {{ @$data2['no_anggota'] }}
                    </x-table-sm.table-td>

                    <x-table-sm.table-td>
                        {{ @$data2['nama'] }}
                    </x-table-sm.table-td>

                    @foreach ($menu as $men)
                    <x-table-sm.table-td>
                        {{ App\Http\Controllers\Controller::rupiah(@$data2->porto[$men]) }}
                    </x-table-sm.table-td>
                    @endforeach


                </x-table-sm.table-tr>
            @empty
                <x-table-sm.table-tr>
                    <x-table-sm.table-td-full-colspan>
                        Data kosong
                    </x-table-sm.table-td-full-colspan>
                </x-table-sm.table-tr>
            @endforelse


            {{-- <x-table-sm.table-tr>
                <x-table-sm.table-td colspan='9' customClass='border-0 text-left font-bold'>
                    Total
                </x-table-sm.table-td>
                <x-table-sm.table-td colspan='1' customClass='border-0 text-right font-bold'>
                </x-table-sm.table-td>
            </x-table-sm.table-tr> --}}

        </x-slot:row>
    </x-table-sm.table>

</div>
@push('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

<script>
    function downloadPDF() {
        const { jsPDF } = window.jspdf || window.jspdf.jsPDF;
        const doc = new jsPDF();

        // Pilih elemen tabel berdasarkan id
        const dataTable = document.getElementById("dataTable");

        // Tambahkan judul ke PDF
        doc.text("Data Anggota", 10, 10);

        // Gunakan autoTable untuk men-generate tabel ke dalam PDF
        doc.autoTable({
            html: '#dataTable',
            startY: 20, // Posisi awal tabel pada halaman PDF
            styles: {
                fontSize: 8,
                cellPadding: 3,
                halign: 'center', // Align teks di tengah
                valign: 'middle',
            },
            theme: 'grid' // Tampilan tabel sebagai grid
        });

        // Unduh file PDF
        doc.save('data-anggota.pdf');
    }
</script>
@endpush
