 
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="font-sans min-h-screen antialiased bg-white dark:bg-pos-card-grey overflow-hidden">
    <div class="grid h-screen lg:grid-cols-2">
        <!-- Left Side - Background Image with Premium Overlay -->
        <div class="hidden lg:relative lg:block overflow-hidden">
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 hover:scale-105" style="background-image: url('{{ asset('images/background.png') }}');"></div>
            <div class="absolute inset-0 bg-gradient-to-tr from-black/80 via-black/40 to-transparent"></div>
            
            <!-- Branding Content -->
            <div class="relative h-full flex flex-col justify-between p-16 text-white">
                <div class="flex items-center gap-3">
                    <div class="size-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30">
                        <img src="{{ asset('images/tanpajudul.png') }}" alt="Logo" class="size-8">
                    </div>
                    <span class="text-2xl font-black tracking-tighter uppercase">EssyCoff</span>
                </div>

                <div class="space-y-6">
                    <h1 class="text-6xl font-black leading-none tracking-tight">
                        Elevate Your<br>
                        <span class="text-primary-blue">Coffee Experience.</span>
                    </h1>
                    <p class="text-xl text-white/70 max-w-md font-medium leading-relaxed">
                        Sistem manajemen kasir yang dirancang khusus untuk mempercepat layanan dan meningkatkan kepuasan pelanggan Anda.
                    </p>
                    <div class="flex items-center gap-4 pt-4">
                        <div class="flex -space-x-3">
                            @for($i=1; $i<=4; $i++)
                                <div class="size-10 rounded-full border-2 border-white/20 bg-zinc-800 flex items-center justify-center overflow-hidden">
                                    <img src="https://i.pravatar.cc/100?u={{ $i }}" alt="avatar">
                                </div>
                            @endfor
                        </div>
                        <p class="text-sm font-semibold text-white/80 italic">Dipercaya oleh ribuan barista profesional.</p>
                    </div>
                </div>

                <div class="text-sm text-white/50 font-medium">
                    &copy; {{ date('Y') }} EssyCoff Technology. All rights reserved.
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="flex w-full items-center justify-center p-6 lg:p-12 relative overflow-y-auto">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 p-8 hidden sm:block">
                <div class="flex items-center gap-2 text-sm font-bold text-pos-secondary">
                    <span class="size-2 rounded-full bg-green-500 animate-pulse"></span>
                    Sistem Operasional Aktif
                </div>
            </div>

            <div class="mx-auto w-full max-w-[440px] animate-in fade-in slide-in-from-bottom-8 duration-700">
                {{ $slot }}
            </div>
        </div>
    </div>

    @fluxScripts
</body>
</html>
