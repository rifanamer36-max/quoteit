{{-- Quote card generator: the image is made in the browser (html2canvas) --}}
<div x-show="card.open" x-cloak x-transition.opacity.duration.250ms
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
    <div class="max-h-[90vh] w-full max-w-md overflow-y-auto rounded-3xl bg-white p-5 shadow-2xl">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-xl font-bold text-tuwaiq-purple">Quote card</h2>
            <button @click="card.open = false" class="text-xl text-gray-400 hover:text-gray-700">✕</button>
        </div>

        {{-- The card that becomes an image --}}
        <div x-ref="cardPreview" class="flex aspect-square w-full flex-col justify-between rounded-2xl p-8"
             :style="`background:${card.bg}; color:${card.fg}; font-family:${card.font}`">
            <span class="text-5xl font-black" style="color:#8b6fd6">!</span>
            <p class="text-2xl leading-relaxed" x-text="'“' + card.text + '”'"></p>
            <div>
                <div class="flex items-end justify-between">
                    <span class="text-sm opacity-80" x-text="'— ' + card.author"></span>
                    <span class="text-lg font-bold">إدراك<span style="color:#8b6fd6">!</span></span>
                </div>
                <div x-show="card.stamp" class="mt-3 flex items-center justify-between border-t pt-3"
                     :style="`border-color:${card.fg}33`">
                    <span class="text-xs opacity-70" dir="rtl">سطورٌ تشرح ما تشعر به</span>
                    <img x-show="card.qr" :src="card.qr" alt="QR" class="h-12 w-12">
                </div>
            </div>
        </div>

        <div class="mt-4 flex items-center gap-2">
            <template x-for="c in colors" :key="c.bg">
                <button type="button" @click="card.bg = c.bg; card.fg = c.fg"
                        class="h-8 w-8 rounded-full border-2" :style="`background:${c.bg}`"
                        :class="card.bg === c.bg ? 'border-tuwaiq-orange' : 'border-gray-300'"></button>
            </template>
            <select x-model="card.font" class="ml-auto rounded-lg border py-1 pl-2 pr-8 text-sm text-tuwaiq-purple">
                <option value="Georgia, serif">Serif</option>
                <option value="Arial, sans-serif">Sans</option>
                <option value="'Courier New', monospace">Mono</option>
            </select>
        </div>

        <label class="mt-3 flex items-center gap-2 text-sm text-tuwaiq-purple">
            <input type="checkbox" x-model="card.stamp"> Add stamp (tagline + QR)
        </label>

        <button type="button" @click="downloadCard()" class="btn-primary mt-4 w-full">Download PNG</button>
    </div>
</div>
