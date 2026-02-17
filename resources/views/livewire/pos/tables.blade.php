<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    @once
    <script>
        window.printQr = function(size){
            const card = document.getElementById('qr-card');
            if(!card) return;
            const qrImg = card.querySelector('img[alt^="QR "]');
            if(size === 'A5'){
                card.style.setProperty('width', '148mm', 'important');
                card.style.setProperty('padding', '8mm', 'important');
                if(qrImg){
                    qrImg.style.setProperty('width', '88mm', 'important');
                    qrImg.style.setProperty('height', '88mm', 'important');
                }
            } else {
                card.style.setProperty('width', '105mm', 'important');
                card.style.setProperty('padding', '6mm', 'important');
                if(qrImg){
                    qrImg.style.setProperty('width', '54mm', 'important');
                    qrImg.style.setProperty('height', '54mm', 'important');
                }
            }
            const style = document.createElement('style');
            style.setAttribute('id', 'tmp-print-size');
            style.media = 'print';
            style.innerHTML = `@page { size: ${size}; margin: 0; }`;
            document.head.appendChild(style);
            window.print();
            setTimeout(() => {
                const s = document.getElementById('tmp-print-size');
                if (s) s.remove();
            }, 500);
        }
    </script>
    @endonce

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="size-8 bg-primary-blue/10 rounded-lg flex items-center justify-center text-primary-blue">
                    <i data-lucide="layout-grid" class="size-5"></i>
                </div>
                <span class="text-[10px] font-black text-primary-blue uppercase tracking-widest">Manajemen Area</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Layout Meja</h1>
            <p class="text-pos-secondary font-medium mt-1">Atur penempatan pelanggan dan cetak QR code untuk self-ordering.</p>
        </div>
        
        <button wire:click="openCreate" 
            class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-primary-blue text-white font-bold text-sm hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95">
            <i data-lucide="plus" class="size-5"></i>
            <span>Tambah Meja</span>
        </button>
    </div>

    <!-- Stats & Quick Filters -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[40px] p-8 border border-pos-border dark:border-zinc-800 shadow-sm">
        <div class="flex flex-col lg:flex-row gap-8 items-center">
            <div class="flex items-center gap-2 p-1 bg-pos-muted/50 dark:bg-pos-muted/10 rounded-2xl shrink-0">
                <button wire:click="$set('status','')" class="px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $status === '' ? 'bg-white text-primary-blue shadow-sm' : 'text-pos-secondary hover:text-pos-foreground' }}">Semua</button>
                <button wire:click="$set('status','available')" class="px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $status === 'available' ? 'bg-white text-pos-success shadow-sm' : 'text-pos-secondary hover:text-pos-foreground' }}">Tersedia</button>
                <button wire:click="$set('status','unavailable')" class="px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ $status === 'unavailable' ? 'bg-white text-pos-error shadow-sm' : 'text-pos-secondary hover:text-pos-foreground' }}">Terisi</button>
            </div>
            
             <div class="relative flex-1 w-full">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-pos-secondary/40"></i>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama atau kode meja..." class="w-full h-14 pl-12 pr-6 rounded-2xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
            </div>
        </div>
    </div>

    <!-- Tables Grid -->
     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse ($tables as $index => $t)
            <div class="bg-white dark:bg-pos-card-grey rounded-[32px] p-6 border border-pos-border dark:border-zinc-800 shadow-sm hover:shadow-xl transition-all group">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="size-12 rounded-2xl {{ $t->status === 'available' ? 'bg-pos-success/10 text-pos-success' : 'bg-pos-error/10 text-pos-error' }} flex items-center justify-center transition-colors">
                            <i data-lucide="armchair" class="size-6"></i>
                        </div>
                        <div>
                            <h5 class="text-base font-black text-pos-foreground capitalize">{{ $t->name }}</h5>
                            <span class="text-[10px] font-black text-pos-secondary uppercase tracking-widest">{{ $t->code }}</span>
                         </div>
                    </div>
                    <button wire:click="openQr('{{ $t->code }}')" class="size-10 rounded-xl bg-pos-muted dark:bg-pos-muted/20 hover:bg-primary-blue hover:text-white flex items-center justify-center transition-all text-pos-secondary">
                        <i data-lucide="qr-code" class="size-5"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-pos-secondary uppercase tracking-wider">Kapasitas</span>
                        <span class="font-black text-pos-foreground">{{ $t->seats ?? '-' }} Kursi</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-bold text-pos-secondary uppercase tracking-wider">Status</span>
                        <div class="flex items-center gap-1.5">
                            <div class="size-2 rounded-full {{ $t->status === 'available' ? 'bg-pos-success animate-pulse' : 'bg-pos-error' }}"></div>
                            <span class="font-black {{ $t->status === 'available' ? 'text-pos-success' : 'text-pos-error' }} uppercase tracking-widest">{{ $t->status === 'available' ? 'Tersedia' : 'Terisi' }}</span>
                        </div>
                    </div>
                </div>

                 <div class="grid grid-cols-3 gap-2 mt-8">
                    <button wire:click="openEdit({{ $t->id }})" class="h-11 rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary flex items-center justify-center hover:bg-primary-blue hover:text-white transition-all">
                        <i data-lucide="edit-3" class="size-4"></i>
                    </button>
                    <button wire:click="toggleStatus({{ $t->id }})" class="h-11 rounded-xl bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center transition-all {{ $t->status === 'available' ? 'text-pos-error hover:bg-pos-error/10 border-pos-error/0 border' : 'text-pos-success hover:bg-pos-success/10 border-pos-success/0 border' }}">
                        <i data-lucide="{{ $t->status === 'available' ? 'lock' : 'unlock' }}" class="size-4"></i>
                    </button>
                    <button wire:click="confirmDelete({{ $t->id }})" class="h-11 rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary flex items-center justify-center hover:bg-pos-error hover:text-white transition-all">
                        <i data-lucide="trash-2" class="size-4"></i>
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 bg-white rounded-[40px] border border-pos-border text-center">
                <i data-lucide="layout-grid" class="size-12 text-pos-secondary/20 mx-auto mb-4"></i>
                <p class="text-xl font-black text-pos-foreground/40">Belum ada meja terdaftar</p>
            </div>
        @endforelse
    </div>

    @if($tables->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $tables->links('components.pagination.premium') }}
        </div>
    @endif

     <!-- QR Modal -->
    @if($showQrModal)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="closeQr"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[40px] w-full max-w-sm p-8 text-center shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
                <div class="flex flex-col items-center gap-6">
                    <div>
                        <h3 class="text-2xl font-black text-pos-foreground tracking-tight">QR Meja {{ $qrName }}</h3>
                        <p class="text-[10px] font-black text-primary-blue uppercase tracking-widest mt-1">Scan untuk memesan</p>
                    </div>

                    <div class="bg-pos-muted/50 dark:bg-pos-muted/10 p-6 rounded-[32px] border border-pos-border dark:border-zinc-800 relative overflow-hidden group">
                        <img src="{{ $this->getQrUrl($qrCode, 300) }}" alt="QR {{ $qrCode }}" class="w-48 h-48 rounded-2xl shadow-sm bg-white p-2">
                        <div class="absolute inset-0 bg-primary-blue/0 group-hover:bg-primary-blue/5 transition-colors pointer-events-none"></div>
                    </div>

                     <div class="grid grid-cols-2 gap-3 w-full">
                        <button onclick="window.printQr('A6')" class="h-12 bg-pos-foreground dark:bg-zinc-800 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-pos-foreground/90 transition-all flex items-center justify-center gap-2">
                            <i data-lucide="printer" class="size-4"></i> Cetak A6
                        </button>
                        <button onclick="window.printQr('A5')" class="h-12 bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-pos-border dark:hover:bg-pos-muted transition-all flex items-center justify-center gap-2">
                            <i data-lucide="printer" class="size-4"></i> Cetak A5
                        </button>
                    </div>
                </div>

                <!-- Hidden Printable Element -->
                <div id="qr-card" class="bg-white text-black rounded-lg p-6 w-[105mm] hidden print:block shadow-none border-0">
                    <div class="text-center space-y-4">
                        <div class="text-2xl font-black uppercase tracking-tight text-gray-900 leading-none">EssyCoff</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em] leading-none mb-6">Scan to Order</div>
                        <div class="bg-white p-4 inline-block border-2 border-gray-100 rounded-[2rem]">
                            <img src="{{ $this->getQrUrl($qrCode, 360) }}" alt="QR {{ $qrCode }}" class="w-[65mm] h-[65mm]" />
                        </div>
                        <div class="mt-6">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest leading-none mb-2">Location</p>
                            <h4 class="text-3xl font-black text-gray-900 uppercase leading-none">{{ $qrName }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Form Modal -->
    @if($showModal)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="$set('showModal', false)"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[40px] w-full max-w-md p-8 shadow-2xl animate-peek flex flex-col gap-8 border border-pos-border dark:border-zinc-800">
                <div>
                    <h3 class="text-2xl font-black text-pos-foreground tracking-tight">{{ $editing ? 'Update Meja' : 'Daftarkan Meja' }}</h3>
                    <p class="text-pos-secondary text-sm font-medium">Lengkapi detail meja untuk sistem POS Anda.</p>
                </div>

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Nama Meja</label>
                        <input type="text" wire:model.live="name" placeholder="Contoh: Meja Area Depan" class="w-full h-14 px-6 rounded-2xl bg-pos-muted border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                         <div class="space-y-2">
                            <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Kode Meja</label>
                            <div class="relative">
                                <input type="text" wire:model.live="code" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20 uppercase">
                                <button wire:click="regenerateCode" class="absolute right-3 top-1/2 -translate-y-1/2 size-8 bg-white dark:bg-zinc-800 rounded-lg flex items-center justify-center text-pos-secondary hover:text-primary-blue shadow-sm">
                                    <i data-lucide="refresh-cw" class="size-4"></i>
                                </button>
                            </div>
                        </div>
                     <div class="space-y-2">
                        <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Jumlah Kursi</label>
                        <input type="number" wire:model.live="seats" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] font-black text-pos-secondary uppercase tracking-widest px-1">Catatan Lokasi</label>
                    <input type="text" wire:model.live="note" placeholder="Misal: Lantai 2, Dekat Jendela" class="w-full h-14 px-6 rounded-2xl bg-pos-muted dark:bg-pos-muted/10 border-none font-bold text-sm text-pos-foreground outline-none focus:ring-2 focus:ring-primary-blue/20">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button wire:click="$set('showModal', false)" class="h-14 bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground rounded-2xl font-black text-sm transition-all hover:bg-pos-border dark:hover:bg-pos-muted">Batal</button>
                    <button wire:click="save" class="h-14 bg-primary-blue text-white rounded-2xl font-black text-sm transition-all hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20">Simpan Data</button>
                </div>
            </div>
        </div>
    @endif

    <style>
        .animate-peek { animation: peek 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes peek {
            0% { transform: scale(0.9) translateY(20px); opacity: 0; }
            100% { transform: scale(1) translateY(0); opacity: 1; }
        }
        @media print {
            body * { visibility: hidden !important; }
            #qr-card, #qr-card * { visibility: visible !important; }
            #qr-card { position: static !important; margin: 0 auto !important; height: auto !important; }
        }
    </style>
</div>
