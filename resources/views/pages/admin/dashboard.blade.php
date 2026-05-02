@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-name', 'Dashboard')

@section('content')

{{-- ===== WELCOME BANNER ===== --}}
<div class="bg-[#001544] rounded-2xl p-8 md:p-10 relative overflow-hidden mb-8">
    {{-- Gold accent line --}}
    <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#f8b830] via-[#f59e0b] to-[#f8b830]"></div>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 relative z-10">
        <div class="max-w-lg">
            <p class="text-[11px] font-bold text-[#f8b830] uppercase tracking-[.15em] mb-2">Admin Panel</p>
            <h1 class="text-[26px] font-extrabold text-white leading-tight mb-2">Administrasi Sistem</h1>
            <p class="text-blue-200/70 text-[14px] leading-relaxed">
                Kelola user, role, master data perusahaan, dan pantau aktivitas seluruh sistem rekrutmen.
            </p>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            <a href="{{ route('admin.users.index') }}"
               class="inline-flex items-center gap-2 font-extrabold py-3 px-6 rounded-xl transition-all active:scale-95 hover:brightness-110 shadow-lg text-sm"
               style="background:#f8b830; color:#001544;">
                <i class="bi bi-person-plus" style="font-size:16px;"></i>
                Kelola User
            </a>
            <div class="inline-flex items-center gap-2 px-4 py-3 bg-white/10 backdrop-blur rounded-xl text-sm font-semibold text-white/80">
                <i class="bi bi-calendar3" style="font-size:14px;"></i>
                {{ now()->translatedFormat('d M Y') }}
            </div>
        </div>
    </div>

    {{-- Background decorative icon --}}
    <i class="bi bi-shield-lock absolute -right-6 -bottom-6 text-white/[0.03]" style="font-size:180px;"></i>
</div>

{{-- ===== 4 STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    {{-- Card 1: Total User --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
        <div class="flex justify-between items-start mb-4">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Total User</p>
            <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                <i class="bi bi-people-fill text-[#002870]" style="font-size:18px;"></i>
            </div>
        </div>
        <h3 class="text-[32px] font-extrabold text-[#001544] leading-none mb-2">{{ $stats['total_user'] }}</h3>
        <div class="flex items-center gap-1.5">
            <i class="bi bi-database text-gray-400" style="font-size:12px;"></i>
            <span class="text-[12px] text-gray-400 font-medium">Semua role terdaftar</span>
        </div>
    </div>

    {{-- Card 2: HR & Admin --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
        <div class="flex justify-between items-start mb-4">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">HR & Admin</p>
            <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                <i class="bi bi-person-badge-fill text-purple-600" style="font-size:18px;"></i>
            </div>
        </div>
        <h3 class="text-[32px] font-extrabold text-[#001544] leading-none mb-2">{{ $stats['total_hr_admin'] }}</h3>
        <div class="flex items-center gap-1.5">
            <i class="bi bi-shield-check text-gray-400" style="font-size:12px;"></i>
            <span class="text-[12px] text-gray-400 font-medium">Pengelola sistem</span>
        </div>
    </div>

    {{-- Card 3: Kandidat --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
        <div class="flex justify-between items-start mb-4">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Kandidat</p>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center">
                <i class="bi bi-person-check-fill text-emerald-600" style="font-size:18px;"></i>
            </div>
        </div>
        <h3 class="text-[32px] font-extrabold text-[#001544] leading-none mb-2">{{ $stats['total_kandidat'] }}</h3>
        <div class="flex items-center gap-1.5">
            <i class="bi bi-person-lines-fill text-gray-400" style="font-size:12px;"></i>
            <span class="text-[12px] text-gray-400 font-medium">Pelamar terdaftar</span>
        </div>
    </div>

    {{-- Card 4: Lowongan Aktif --}}
    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
        <div class="flex justify-between items-start mb-4">
            <p class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">Lowongan Aktif</p>
            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center">
                <i class="bi bi-briefcase-fill text-amber-600" style="font-size:18px;"></i>
            </div>
        </div>
        <h3 class="text-[32px] font-extrabold text-[#001544] leading-none mb-2">{{ $stats['lowongan_aktif'] }}</h3>
        <div class="flex items-center gap-1.5">
            <i class="bi bi-activity text-gray-400" style="font-size:12px;"></i>
            <span class="text-[12px] text-gray-400 font-medium">Sedang dibuka</span>
        </div>
    </div>

</div>

{{-- ===== MAIN 2-COLUMN GRID ===== --}}
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

    {{-- LEFT: Distribusi Role (2/5 width) --}}
    <div class="lg:col-span-2 bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                <i class="bi bi-pie-chart-fill text-[#002870]" style="font-size:14px;"></i>
            </div>
            <div>
                <h3 class="text-[15px] font-bold text-[#001544]">Distribusi Role</h3>
                <p class="text-[11px] text-gray-400">Sebaran user berdasarkan role</p>
            </div>
        </div>

        <div class="p-6 space-y-5">
            @php
                $total = $distribusi['admin'] + $distribusi['hr'] + $distribusi['kandidat'];
                $pctAdmin = $total ? round($distribusi['admin'] / $total * 100) : 0;
                $pctHr = $total ? round($distribusi['hr'] / $total * 100) : 0;
                $pctKandidat = $total ? round($distribusi['kandidat'] / $total * 100) : 0;

                $roles = [
                    ['name' => 'Admin',    'count' => $distribusi['admin'],    'pct' => $pctAdmin,    'color' => 'bg-[#002870]', 'iconBg' => 'bg-blue-50',    'iconColor' => 'text-[#002870]', 'icon' => 'bi-shield-lock-fill'],
                    ['name' => 'HR',       'count' => $distribusi['hr'],       'pct' => $pctHr,       'color' => 'bg-purple-500','iconBg' => 'bg-purple-50',  'iconColor' => 'text-purple-600','icon' => 'bi-person-badge-fill'],
                    ['name' => 'Kandidat', 'count' => $distribusi['kandidat'], 'pct' => $pctKandidat, 'color' => 'bg-emerald-500','iconBg'=> 'bg-emerald-50', 'iconColor' => 'text-emerald-600','icon' => 'bi-person-fill'],
                ];
            @endphp

            @foreach($roles as $role)
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-lg {{ $role['iconBg'] }} flex items-center justify-center">
                            <i class="bi {{ $role['icon'] }} {{ $role['iconColor'] }}" style="font-size:12px;"></i>
                        </div>
                        <span class="text-[13px] font-bold text-[#001544]">{{ $role['name'] }}</span>
                    </div>
                    <span class="text-[13px] font-extrabold text-[#001544]">{{ $role['count'] }}</span>
                </div>
                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $role['color'] }} transition-all duration-700" style="width:{{ $role['pct'] }}%"></div>
                </div>
            </div>
            @endforeach

            {{-- Mini stat cards --}}
            <div class="grid grid-cols-2 gap-3 pt-3 border-t border-gray-50">
                <div class="bg-emerald-50/60 rounded-xl p-4">
                    <div class="flex items-center gap-1.5 mb-1.5">
                        <i class="bi bi-check-circle-fill text-emerald-500" style="font-size:12px;"></i>
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">User Aktif</span>
                    </div>
                    <span class="text-[24px] font-extrabold text-[#001544]">{{ $user_aktif }}</span>
                </div>
                <div class="bg-amber-50/60 rounded-xl p-4">
                    <div class="flex items-center gap-1.5 mb-1.5">
                        <i class="bi bi-exclamation-circle-fill text-amber-500" style="font-size:12px;"></i>
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">Pending</span>
                    </div>
                    <span class="text-[24px] font-extrabold text-[#001544]">{{ $user_pending }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT: User Terbaru (3/5 width) --}}
    <div class="lg:col-span-3 bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#002870]/10 flex items-center justify-center">
                    <i class="bi bi-clock-history text-[#002870]" style="font-size:14px;"></i>
                </div>
                <div>
                    <h3 class="text-[15px] font-bold text-[#001544]">User Terbaru</h3>
                    <p class="text-[11px] text-gray-400">Pendaftar terakhir di sistem</p>
                </div>
            </div>
            <a href="{{ route('admin.users.index') }}"
               class="text-[12px] font-bold text-[#002870] hover:underline uppercase tracking-wider">
                Kelola →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-6 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-4 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Email</th>
                        <th class="px-4 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="px-4 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3.5 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php
                        $avatarColors = [
                            ['bg' => 'bg-red-100',    'text' => 'text-red-700'],
                            ['bg' => 'bg-blue-100',   'text' => 'text-blue-700'],
                            ['bg' => 'bg-emerald-100','text' => 'text-emerald-700'],
                            ['bg' => 'bg-amber-100',  'text' => 'text-amber-700'],
                            ['bg' => 'bg-purple-100', 'text' => 'text-purple-700'],
                            ['bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                        ];

                        $roleBadge = [
                            'admin' => ['bg' => 'bg-purple-50',  'text' => 'text-purple-700', 'label' => 'Admin'],
                            'hr'    => ['bg' => 'bg-blue-50',    'text' => 'text-[#002870]',  'label' => 'HR'],
                            'user'  => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700','label' => 'Kandidat'],
                        ];

                        $statusBadge = [
                            'active'   => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'label' => 'Aktif'],
                            'pending'  => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'label' => 'Pending'],
                            'inactive' => ['bg' => 'bg-red-50',     'text' => 'text-red-600',     'label' => 'Nonaktif'],
                        ];
                    @endphp

                    @forelse($user_terbaru as $i => $u)
                        @php
                            $av = $avatarColors[$i % count($avatarColors)];
                            $rb = $roleBadge[$u->role] ?? $roleBadge['user'];
                            $sb = $statusBadge[$u->status] ?? $statusBadge['pending'];
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full {{ $av['bg'] }} flex items-center justify-center {{ $av['text'] }} text-[12px] font-bold flex-shrink-0">
                                        {{ $u->initial }}
                                    </div>
                                    <span class="font-bold text-sm text-[#001544]">{{ $u->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-500">{{ $u->email }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold tracking-wider {{ $rb['bg'] }} {{ $rb['text'] }}">
                                    {{ $rb['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-extrabold tracking-wider {{ $sb['bg'] }} {{ $sb['text'] }}">
                                    {{ $sb['label'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="text-sm text-gray-400">{{ $u->created_at->diffForHumans(null, true) }} lalu</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class="bi bi-inbox text-gray-300 block mb-2" style="font-size:36px;"></i>
                                <p class="text-sm text-gray-400">Belum ada user terdaftar</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-50 bg-gray-50/30">
            <p class="text-[12px] text-gray-400">
                Total kandidat tercatat: <strong class="text-[#001544] font-bold">{{ $stats['total_kandidat'] }}</strong>
            </p>
        </div>
    </div>

</div>

@endsection