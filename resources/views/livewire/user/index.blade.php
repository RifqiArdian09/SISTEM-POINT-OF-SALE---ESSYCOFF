<div class="p-6 lg:p-10 space-y-10 bg-pos-muted min-h-screen font-sans">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="size-8 bg-primary-blue/10 rounded-lg flex items-center justify-center text-primary-blue">
                    <i data-lucide="users" class="size-5"></i>
                </div>
                <span class="text-[10px] font-black text-primary-blue uppercase tracking-widest">Manajemen Tim</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black text-pos-foreground tracking-tight">Karyawan & Akses</h1>
            <p class="text-pos-secondary font-medium mt-1">Kelola tim Anda dan berikan akses sesuai peran masing-masing.</p>
        </div>
        
        <a href="{{ route('users.create') }}" 
            class="flex items-center gap-3 px-6 py-4 rounded-2xl bg-primary-blue text-white font-bold text-sm hover:bg-primary-blue-hover shadow-xl shadow-primary-blue/20 transition-all active:scale-95" 
            wire:navigate>
            <i data-lucide="user-plus" class="size-5"></i>
            <span>Tambah Karyawan</span>
        </a>
    </div>

    <!-- Stats Mini Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-pos-card-grey p-6 rounded-2xl border border-pos-border dark:border-zinc-800 shadow-sm flex items-center gap-4">
            <div class="size-12 rounded-xl bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center text-pos-secondary">
                <i data-lucide="user-check" class="size-6"></i>
            </div>
            <div>
                <p class="text-[10px] font-black text-pos-secondary uppercase tracking-widest">Total Staff</p>
                <p class="text-xl font-black text-pos-foreground">{{ $users->total() }}</p>
            </div>
        </div>
    </div>

    <!-- Search & List -->
    <div class="bg-white dark:bg-pos-card-grey rounded-[40px] border border-pos-border dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="p-8 border-b border-pos-border dark:border-zinc-800">
            <div class="relative max-w-md">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 size-4 text-pos-secondary"></i>
                <input type="text" 
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari berdasarkan nama atau email staff..." 
                    class="w-full h-12 pl-11 pr-4 rounded-xl bg-pos-muted/50 dark:bg-pos-muted/10 border-none focus:ring-2 focus:ring-primary-blue/20 outline-none text-sm font-bold text-pos-foreground placeholder:text-pos-secondary/60">
            </div>
        </div>
        
        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead class="bg-pos-card-grey/50 dark:bg-pos-muted/10">
                    <tr>
                        <th class="px-10 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest w-24 text-center">No</th>
                        <th class="px-10 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Data Karyawan</th>
                        <th class="px-10 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest">Peran / Role</th>
                        <th class="px-10 py-5 text-[10px] font-black text-pos-secondary uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-pos-border dark:divide-zinc-800">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-pos-muted/20 dark:hover:bg-pos-muted/5 transition-colors group">
                            <td class="px-10 py-6 text-center">
                                <span class="size-8 inline-flex items-center justify-center rounded-lg bg-pos-muted text-pos-secondary font-black text-xs">{{ $index + 1 }}</span>
                            </td>
                             <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="size-12 rounded-2xl bg-pos-muted dark:bg-pos-muted/20 flex items-center justify-center text-primary-blue font-black border border-pos-border dark:border-zinc-800 overflow-hidden">
                                        @if($user->avatar_url)
                                            <img src="{{ $user->avatar_url }}" class="w-full h-full object-cover">
                                        @else
                                            {{ $user->initials() }}
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="text-base font-black text-pos-foreground capitalize group-hover:text-primary-blue transition-colors">{{ $user->name }}</h5>
                                        <p class="text-xs text-pos-secondary font-medium">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border 
                                    {{ $user->role === 'manager' ? 'bg-primary-blue/5 text-primary-blue border-primary-blue/20' : 'bg-pos-success/5 text-pos-success border-pos-success/20' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="px-10 py-6">
                                 <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('users.edit', $user) }}" 
                                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground font-bold text-xs hover:bg-primary-blue hover:text-white transition-all shadow-sm" 
                                        wire:navigate>
                                        <i data-lucide="user-cog" class="size-4"></i>
                                        <span>Pengaturan</span>
                                    </a>
                                    <button wire:click="confirmDelete({{ $user->id }})" 
                                        class="size-10 flex items-center justify-center rounded-xl bg-pos-muted dark:bg-pos-muted/20 text-pos-secondary hover:bg-pos-error hover:text-white transition-all">
                                        <i data-lucide="trash-2" class="size-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-10 py-20 text-center text-pos-secondary/30">
                                <div class="flex flex-col items-center gap-4">
                                    <div class="size-20 bg-pos-muted rounded-full flex items-center justify-center">
                                        <i data-lucide="user-x" class="size-10"></i>
                                    </div>
                                    <p class="font-black">Belum ada karyawan terdaftar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
         @if($users->hasPages())
            <div class="px-10 py-6 bg-pos-card-grey/30 dark:bg-pos-muted/10 border-t border-pos-border dark:border-zinc-800 flex items-center justify-between">
                <p class="text-xs font-bold text-pos-secondary uppercase tracking-widest">Menampilkan <span class="text-primary-blue">{{ $users->total() }}</span> Akun Karyawan</p>
                {{ $users->links('components.pagination.premium') }}
            </div>
        @endif
    </div>

     <!-- Modal Konfirmasi Hapus -->
    @if($confirmingUserDeletion)
        <div class="fixed inset-0 z-[999] flex items-center justify-center p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-md" wire:click="$set('confirmingUserDeletion', false)"></div>
            <div class="relative bg-white dark:bg-pos-card-grey rounded-[32px] w-full max-w-sm p-8 text-center shadow-2xl animate-peek border border-pos-border dark:border-zinc-800">
                <div class="size-20 bg-pos-error/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="user-minus" class="size-10 text-pos-error"></i>
                </div>
                <h3 class="text-2xl font-black text-pos-foreground mb-3 tracking-tight">Hapus Akses?</h3>
                <p class="text-pos-secondary text-sm font-medium mb-8">Karyawan ini tidak akan bisa login lagi ke sistem selamanya.</p>
                
                <div class="grid grid-cols-2 gap-4">
                    <button wire:click="$set('confirmingUserDeletion', false)" class="py-4 bg-pos-muted dark:bg-pos-muted/20 text-pos-foreground rounded-2xl font-extrabold text-sm hover:bg-pos-border dark:hover:bg-pos-muted transition-all">Batal</button>
                    <button wire:click="delete({{ $userIdToDelete }})" class="py-4 bg-pos-error text-white rounded-2xl font-extrabold text-sm hover:bg-pos-error/90 transition-all shadow-lg shadow-pos-error/20">Hapus User</button>
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
    </style>
</div>