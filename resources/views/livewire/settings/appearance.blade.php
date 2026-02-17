<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="size-8 bg-purple-500/10 rounded-lg flex items-center justify-center text-purple-500">
                    <i data-lucide="palette" class="size-5"></i>
                </div>
                <span class="text-[10px] font-black text-purple-500 uppercase tracking-widest">Kustomisasi UI</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Tampilan Sistem</h1>
            <p class="text-pos-secondary font-medium mt-1">Sesuaikan kenyamanan visual antarmuka sistem POS Anda.</p>
        </div>
    </div>

    <!-- Theme Selection -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8" x-data>
        <!-- Light Mode Card -->
        <button @click="$flux.appearance = 'light'" 
            class="group relative flex flex-col p-8 rounded-[40px] bg-white dark:bg-pos-card-grey border-2 transition-all text-left"
            :class="$flux.appearance === 'light' ? 'border-primary-blue shadow-2xl shadow-primary-blue/10' : 'border-pos-border dark:border-zinc-800 hover:border-pos-secondary/30 dark:hover:border-zinc-700 shadow-sm'">
            
             <div class="size-16 rounded-[24px] bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center mb-10 group-hover:scale-110 transition-transform">
                <i data-lucide="sun" class="size-8" :class="$flux.appearance === 'light' ? 'text-primary-blue' : 'text-pos-secondary'"></i>
            </div>
            
            <h3 class="font-black text-xl text-pos-foreground tracking-tight">Terang (Light)</h3>
            <p class="text-xs text-pos-secondary font-medium mt-2 leading-relaxed">Tampilan klasik yang bersih dan jernih untuk lingkungan kerja terang.</p>
            
             <div class="mt-8 size-8 rounded-full border-2 flex items-center justify-center transition-all"
                :class="$flux.appearance === 'light' ? 'bg-primary-blue border-primary-blue text-white' : 'border-pos-border dark:border-zinc-800 text-transparent'">
                <i data-lucide="check" class="size-4 font-black"></i>
            </div>
            
            <div x-show="$flux.appearance === 'light'" class="absolute -top-3 -right-3 px-4 py-1.5 bg-primary-blue text-white text-[10px] font-black rounded-xl shadow-lg uppercase tracking-widest">Aktif</div>
        </button>

         <!-- Dark Mode Card -->
        <button @click="$flux.appearance = 'dark'" 
            class="group relative flex flex-col p-8 rounded-[40px] bg-pos-foreground dark:bg-pos-muted border-2 transition-all text-left shadow-lg shadow-black/20"
            :class="$flux.appearance === 'dark' ? 'border-primary-blue shadow-2xl shadow-primary-blue/20' : 'border-zinc-800 hover:border-zinc-700 shadow-sm'">
            
            <div class="size-16 rounded-[24px] bg-white/5 flex items-center justify-center mb-10 group-hover:scale-110 transition-transform">
                <i data-lucide="moon" class="size-8" :class="$flux.appearance === 'dark' ? 'text-primary-blue' : 'text-zinc-500'"></i>
            </div>
            
            <h3 class="font-black text-xl text-white tracking-tight">Gelap (Dark)</h3>
            <p class="text-xs text-zinc-400 font-medium mt-2 leading-relaxed">Tampilan rileks untuk mengurangi kelelahan mata di pencahayaan minim.</p>
            
            <div class="mt-8 size-8 rounded-full border-2 flex items-center justify-center transition-all"
                :class="$flux.appearance === 'dark' ? 'bg-primary-blue border-primary-blue text-white' : 'border-zinc-800 text-transparent'">
                <i data-lucide="check" class="size-4 font-black"></i>
            </div>
 
            <div x-show="$flux.appearance === 'dark'" class="absolute -top-3 -right-3 px-4 py-1.5 bg-primary-blue text-white text-[10px] font-black rounded-xl shadow-lg uppercase tracking-widest">Aktif</div>
        </button>

         <!-- System Mode Card -->
        <button @click="$flux.appearance = 'system'" 
            class="group relative flex flex-col p-8 rounded-[40px] bg-white dark:bg-pos-card-grey border-2 border-dashed transition-all text-left"
            :class="$flux.appearance === 'system' ? 'border-primary-blue bg-primary-blue/5 dark:bg-primary-blue/5 shadow-2xl shadow-primary-blue/10' : 'border-pos-border dark:border-zinc-800 hover:border-pos-secondary/30 dark:hover:border-zinc-700 shadow-sm'">
            
             <div class="size-16 rounded-[24px] bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center mb-10 group-hover:scale-110 transition-transform">
                <i data-lucide="monitor" class="size-8" :class="$flux.appearance === 'system' ? 'text-primary-blue' : 'text-pos-secondary'"></i>
            </div>
            
            <h3 class="font-black text-xl text-pos-foreground tracking-tight">Otomatis</h3>
            <p class="text-xs text-pos-secondary font-medium mt-2 leading-relaxed">Menyesuaikan tema secara dinamis mengikuti pengaturan sistem operasi.</p>
            
             <div class="mt-8 size-8 rounded-full border-2 flex items-center justify-center transition-all"
                :class="$flux.appearance === 'system' ? 'bg-primary-blue border-primary-blue text-white' : 'border-pos-border dark:border-zinc-800 text-transparent'">
                <i data-lucide="check" class="size-4 font-black"></i>
            </div>

            <div x-show="$flux.appearance === 'system'" class="absolute -top-3 -right-3 px-4 py-1.5 bg-primary-blue text-white text-[10px] font-black rounded-xl shadow-lg uppercase tracking-widest">Aktif</div>
        </button>
    </div>

     <!-- Visual Hint -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[32px] p-8 border border-pos-border dark:border-zinc-800 shadow-sm flex items-center gap-6">
        <div class="size-14 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center text-pos-secondary shrink-0">
            <i data-lucide="info" class="size-6"></i>
        </div>
        <p class="text-sm font-medium text-pos-secondary leading-relaxed">
            Perubahan tema akan diterapkan secara instan di seluruh sesi aplikasi tanpa perlu memuat ulang halaman.
        </p>
    </div>
</div>
