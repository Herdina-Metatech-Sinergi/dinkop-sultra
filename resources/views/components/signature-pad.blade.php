<div x-data="{
    signaturePadId: $id('signature'),
    signaturePad: null,
    signature: null,
    ratio: null,
    init() {
        this.resizeCanvas(); // resize canvas before initializing
        this.signaturePad = new SignaturePad(this.$refs.canvas);
        if (this.signature) {
            // pass ratio when loading a saved signature
            this.signaturePad.fromDataURL(this.signature, { ratio: this.ratio });
        }
    },
    save() {
        this.signature = this.signaturePad.toDataURL();
        this.$dispatch('signature-saved', this.signaturePadId);
    },
    clear() {
        this.signaturePad.clear();
        this.signature = null;
    },
    // The resize canvas function https://github.com/szimek/signature_pad#tips-and-tricks﻿
    resizeCanvas() {
        this.ratio = Math.max(window.devicePixelRatio || 1, 1);
        this.$refs.canvas.width = this.$refs.canvas.offsetWidth * this.ratio;
        this.$refs.canvas.height = this.$refs.canvas.offsetHeight * this.ratio;
        this.$refs.canvas.getContext('2d').scale(this.ratio, this.ratio);
    }
}" @resize.window="resizeCanvas">


    <canvas x-ref="canvas" height="200px" width="400px"
        class="border-2 border-gray-300 border-dashed rounded-md "></canvas>

    <div class="flex mt-2 space-x-2">
        <a href="#" x-on:click.prevent="clear()" class="text-sm font-medium text-gray-700 underline">
            Clear
        </a>
        <a href="#" x-on:click.prevent="save()" class="text-sm font-medium text-gray-700 underline">
            Save
        </a>

        <span x-data="{
            open: false,
            saved(e) {
                if (e.detail != this.signaturePadId) {
                    return;
                }
                this.open = true;
                setTimeout(() => { this.open = false }, 900);
            }
        }" x-show="open" @signature-saved.window="saved" x-transition
            class="text-sm font-medium text-green-700 " style="display:none">
            Saved !
        </span>

    </div>

</div>

@pushonce('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
@endpushonce
