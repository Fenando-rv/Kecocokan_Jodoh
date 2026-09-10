<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Kecocokan Jodoh - Laravel & Tailwind CSS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'bounce-subtle': 'bounce 2s infinite',
                        'float': 'float 6s ease-in-out infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(30, 41, 59, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glass-card-light {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="font-sans min-h-full text-slate-100 bg-gradient-to-br from-slate-950 via-slate-900 to-rose-950 flex flex-col justify-between selection:bg-rose-500 selection:text-white relative overflow-x-hidden">

    <!-- Ambient Background Glow Effects -->
    <div class="fixed top-0 -left-20 w-96 h-96 bg-rose-500/20 rounded-full blur-3xl pointer-events-none animate-pulse-slow"></div>
    <div class="fixed bottom-0 -right-20 w-96 h-96 bg-purple-600/20 rounded-full blur-3xl pointer-events-none animate-pulse-slow"></div>
    <div class="fixed top-1/3 right-10 w-72 h-72 bg-pink-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header Navigation -->
    <header class="w-full border-b border-slate-800/80 bg-slate-950/40 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="{{ route('matchmaker.index') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-rose-500 to-pink-500 flex items-center justify-center shadow-lg shadow-rose-500/30 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="font-extrabold text-lg text-white tracking-tight flex items-center gap-2">
                        LoveMatch <span class="text-xs px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 font-semibold border border-rose-500/30"></span>
                    </h1>
                    <p class="text-xs text-slate-400">Kalkulator Kecocokan Jodoh</p>
                </div>
            </a>
            <div class="hidden sm:flex items-center space-x-2 text-xs text-slate-400 bg-slate-900/80 border border-slate-800 rounded-full px-3.5 py-1.5">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span>Komutatif & Deterministik</span>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

        <!-- Hero Title -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-500/10 border border-rose-500/20 text-rose-300 text-xs font-semibold mb-4 animate-float">
                <svg class="w-4 h-4 text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
                <span>Sistem Matchmaking Hashing SHA-256</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight">
                Cek Kecocokan Jodoh Anda & Pasangan
            </h2>
            <p class="mt-3 text-slate-300 text-sm sm:text-base leading-relaxed">
                Masukkan nama dan tanggal lahir kedua pasangan. Algoritma kami secara deterministik dan komutatif menghitung tingkat keselarasan hubungan kalian.
            </p>
        </div>

        <!-- Global Validation Error Alert -->
        @if ($errors->any())
            <div class="max-w-4xl mx-auto mb-8 p-4 rounded-2xl bg-rose-950/80 border border-rose-500/40 text-rose-200 text-sm shadow-xl flex items-start gap-3">
                <div class="p-2 bg-rose-500/20 rounded-xl text-rose-400 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-rose-100">Terdapat kesalahan pengisian form:</h4>
                    <ul class="mt-1 list-disc list-inside space-y-1 text-xs sm:text-sm text-rose-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Layout Grid: Form (Left) & Result (Right) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start max-w-5xl mx-auto">

            <!-- Left Column: Input Form -->
            <div class="lg:col-span-6 glass-card rounded-3xl p-6 sm:p-8 shadow-2xl shadow-rose-950/20">
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-slate-800">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1.012 1.012 0 01.707.293l5.414 5.414a1.012 1.012 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Form Data Pasangan
                    </h3>
                    <span class="text-xs text-slate-400">Semua field wajib diisi</span>
                </div>

                <form id="matchmakerForm" action="{{ route('matchmaker.calculate') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Pasangan 1 Box -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-slate-900/70 border border-slate-800/80 space-y-4 relative group hover:border-slate-700 transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-rose-400 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                Pasangan Pertama
                            </span>
                            <span class="text-xs text-slate-500">Orang A</span>
                        </div>

                        <!-- Field Name 1 -->
                        <div>
                            <label for="person1_name" class="block text-xs font-semibold text-slate-300 mb-1.5">
                                Nama Lengkap / Panggilan
                            </label>
                            <div class="relative">
                                <input type="text"
                                       name="person1_name"
                                       id="person1_name"
                                       value="{{ old('person1_name', isset($result) ? $result['person1_name'] : '') }}"
                                       placeholder="Contoh: Romeo"
                                       required
                                       class="w-full bg-slate-950 border @error('person1_name') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-all">
                            </div>
                            @error('person1_name')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Field Date 1 -->
                        <div>
                            <label for="person1_birthdate" class="block text-xs font-semibold text-slate-300 mb-1.5">
                                Tanggal Lahir
                            </label>
                            <input type="date"
                                   name="person1_birthdate"
                                   id="person1_birthdate"
                                   value="{{ old('person1_birthdate', isset($result) ? $result['person1_birthdate'] : '') }}"
                                   required
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full bg-slate-950 border @error('person1_birthdate') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-rose-500/50 focus:border-rose-500 transition-all [color-scheme:dark]">
                            @error('person1_birthdate')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Swap Button Divider -->
                    <div class="relative flex items-center justify-center py-1">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-800"></div>
                        </div>
                        <button type="button"
                                id="swapBtn"
                                title="Tukar Posisi Pasangan (Uji Komutativitas)"
                                class="relative z-10 p-2.5 rounded-full bg-slate-800 border border-slate-700 text-slate-300 hover:text-rose-400 hover:bg-slate-700 hover:scale-110 active:scale-95 transition-all shadow-md flex items-center gap-1 text-xs font-medium px-3">
                            <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                            </svg>
                            <span>Tukar Pasangan</span>
                        </button>
                    </div>

                    <!-- Pasangan 2 Box -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-slate-900/70 border border-slate-800/80 space-y-4 relative group hover:border-slate-700 transition-colors">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-pink-400 flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-pink-500"></span>
                                Pasangan Kedua
                            </span>
                            <span class="text-xs text-slate-500">Orang B</span>
                        </div>

                        <!-- Field Name 2 -->
                        <div>
                            <label for="person2_name" class="block text-xs font-semibold text-slate-300 mb-1.5">
                                Nama Lengkap / Panggilan
                            </label>
                            <input type="text"
                                   name="person2_name"
                                   id="person2_name"
                                   value="{{ old('person2_name', isset($result) ? $result['person2_name'] : '') }}"
                                   placeholder="Contoh: Juliet"
                                   required
                                   class="w-full bg-slate-950 border @error('person2_name') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500 transition-all">
                            @error('person2_name')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Field Date 2 -->
                        <div>
                            <label for="person2_birthdate" class="block text-xs font-semibold text-slate-300 mb-1.5">
                                Tanggal Lahir
                            </label>
                            <input type="date"
                                   name="person2_birthdate"
                                   id="person2_birthdate"
                                   value="{{ old('person2_birthdate', isset($result) ? $result['person2_birthdate'] : '') }}"
                                   required
                                   max="{{ date('Y-m-d') }}"
                                   class="w-full bg-slate-950 border @error('person2_birthdate') border-rose-500 @else border-slate-800 @enderror rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500 transition-all [color-scheme:dark]">
                            @error('person2_birthdate')
                                <p class="mt-1 text-xs text-rose-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-rose-500 via-pink-500 to-purple-600 text-white font-bold text-sm sm:text-base tracking-wide shadow-lg shadow-rose-500/25 hover:shadow-rose-500/40 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2 group">
                        <svg class="w-5 h-5 text-white group-hover:scale-125 transition-transform" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                        </svg>
                        <span>Hitung Kecocokan Jodoh</span>
                    </button>
                </form>
            </div>

            <!-- Right Column: Result Section -->
            <div class="lg:col-span-6">
                @if (isset($result))
                    <!-- Result Card Active -->
                    <div id="resultCard" class="glass-card rounded-3xl p-6 sm:p-8 shadow-2xl border-rose-500/30 relative overflow-hidden transition-all">

                        <!-- Ambient Glow inside card -->
                        <div class="absolute -top-16 -right-16 w-48 h-48 bg-rose-500/20 rounded-full blur-2xl pointer-events-none"></div>

                        <!-- Card Header -->
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-6">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                                <h3 class="text-xs uppercase font-bold text-slate-400 tracking-wider">Hasil Analisis Kecocokan</h3>
                            </div>
                            <span class="text-xs text-slate-500">{{ $result['calculated_at'] }}</span>
                        </div>

                        <!-- Names Banner -->
                        <div class="text-center mb-6">
                            <div class="inline-flex items-center justify-center gap-3 px-4 py-2 rounded-2xl bg-slate-900/90 border border-slate-800">
                                <span class="font-bold text-white text-sm sm:text-base">{{ $result['person1_name'] }}</span>
                                <span class="text-rose-400 animate-pulse">💕</span>
                                <span class="font-bold text-white text-sm sm:text-base">{{ $result['person2_name'] }}</span>
                            </div>
                        </div>

                        <!-- Score Circular Gauge & Status Badge -->
                        <div class="flex flex-col items-center justify-center my-6">
                            <div class="relative w-40 h-40 flex items-center justify-center">
                                <!-- SVG Progress Circle -->
                                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 120 120">
                                    <circle cx="60" cy="60" r="50" stroke="currentColor" stroke-width="8" class="text-slate-800" fill="transparent"/>
                                    <circle cx="60" cy="60" r="50" stroke="currentColor" stroke-width="8"
                                            class="@if($result['badge_color'] === 'emerald') text-emerald-400 @elseif($result['badge_color'] === 'amber') text-amber-400 @else text-rose-400 @endif transition-all duration-1000 ease-out"
                                            stroke-dasharray="314.159"
                                            stroke-dashoffset="{{ 314.159 - (314.159 * $result['score']) / 100 }}"
                                            stroke-linecap="round"
                                            fill="transparent"/>
                                </svg>
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                    <span class="text-4xl font-extrabold text-white tracking-tight">{{ $result['score'] }}<span class="text-2xl text-rose-400">%</span></span>
                                    <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider mt-0.5">Tingkat Cocok</span>
                                </div>
                            </div>

                            <!-- Badge Status -->
                            <div class="mt-4">
                                @if($result['badge_color'] === 'emerald')
                                    <span class="px-4 py-1.5 rounded-full bg-emerald-500/20 border border-emerald-500/40 text-emerald-300 font-bold text-xs sm:text-sm shadow-lg shadow-emerald-500/10 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $result['category'] }}
                                    </span>
                                @elseif($result['badge_color'] === 'amber')
                                    <span class="px-4 py-1.5 rounded-full bg-amber-500/20 border border-amber-500/40 text-amber-300 font-bold text-xs sm:text-sm shadow-lg shadow-amber-500/10 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.57l-7 10A1 1 0 018 17v-5H4a1 1 0 01-.82-1.57l7-10a1 1 0 011.12-.384z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $result['category'] }}
                                    </span>
                                @else
                                    <span class="px-4 py-1.5 rounded-full bg-rose-500/20 border border-rose-500/40 text-rose-300 font-bold text-xs sm:text-sm shadow-lg shadow-rose-500/10 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-rose-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $result['category'] }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Narrative Paragraph -->
                        <div class="bg-slate-900/90 rounded-2xl p-4 sm:p-5 border border-slate-800 mb-5 relative">
                            <svg class="w-6 h-6 text-rose-500/30 absolute top-3 left-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                            </svg>
                            <p class="text-slate-200 text-xs sm:text-sm leading-relaxed pl-6 italic">
                                "{{ $result['narrative'] }}"
                            </p>
                        </div>

                        <!-- Advice Section -->
                        <div class="p-3.5 sm:p-4 rounded-xl bg-purple-950/30 border border-purple-800/40 text-purple-200 text-xs flex items-start gap-2.5 mb-6">
                            <span class="text-base shrink-0">💡</span>
                            <div>
                                <span class="font-bold text-purple-300 block mb-0.5">Saran Hubungan:</span>
                                <span>{{ $result['advice'] }}</span>
                            </div>
                        </div>

                        <!-- Breakdown Grid -->
                        <div class="space-y-3 mb-6">
                            <h4 class="text-xs uppercase font-bold text-slate-400 tracking-wider">Breakdown Indikator Hubungan</h4>

                            <div class="space-y-2 text-xs">
                                <!-- Komunikasi -->
                                <div>
                                    <div class="flex justify-between font-medium text-slate-300 mb-1">
                                        <span>Komunikasi & Keterbukaan</span>
                                        <span class="text-white font-bold">{{ $result['breakdown']['communication'] }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-900 rounded-full h-2 overflow-hidden border border-slate-800">
                                        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-2 rounded-full transition-all duration-700" style="width: {{ $result['breakdown']['communication'] }}%"></div>
                                    </div>
                                </div>

                                <!-- Emosional -->
                                <div>
                                    <div class="flex justify-between font-medium text-slate-300 mb-1">
                                        <span>Ikatan Emosional & Empati</span>
                                        <span class="text-white font-bold">{{ $result['breakdown']['emotional'] }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-900 rounded-full h-2 overflow-hidden border border-slate-800">
                                        <div class="bg-gradient-to-r from-rose-500 to-pink-500 h-2 rounded-full transition-all duration-700" style="width: {{ $result['breakdown']['emotional'] }}%"></div>
                                    </div>
                                </div>

                                <!-- Visi Hidup -->
                                <div>
                                    <div class="flex justify-between font-medium text-slate-300 mb-1">
                                        <span>Keselarasan Nilai & Visi Masa Depan</span>
                                        <span class="text-white font-bold">{{ $result['breakdown']['values'] }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-900 rounded-full h-2 overflow-hidden border border-slate-800">
                                        <div class="bg-gradient-to-r from-amber-500 to-emerald-500 h-2 rounded-full transition-all duration-700" style="width: {{ $result['breakdown']['values'] }}%"></div>
                                    </div>
                                </div>

                                <!-- Chemistry -->
                                <div>
                                    <div class="flex justify-between font-medium text-slate-300 mb-1">
                                        <span>Chemistry & Daya Tarik</span>
                                        <span class="text-white font-bold">{{ $result['breakdown']['chemistry'] }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-900 rounded-full h-2 overflow-hidden border border-slate-800">
                                        <div class="bg-gradient-to-r from-purple-500 to-fuchsia-500 h-2 rounded-full transition-all duration-700" style="width: {{ $result['breakdown']['chemistry'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <a href="{{ route('matchmaker.index') }}"
                               class="flex-1 py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-semibold text-xs text-center transition-all flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                <span>Hitung Ulang</span>
                            </a>
                            <button type="button"
                                    id="copyResultBtn"
                                    class="flex-1 py-2.5 px-4 rounded-xl bg-rose-600/30 hover:bg-rose-600/50 border border-rose-500/40 text-rose-200 font-semibold text-xs transition-all flex items-center justify-center gap-1.5">
                                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                </svg>
                                <span id="copyBtnText">Salin Hasil</span>
                            </button>
                        </div>

                    </div>
                @else
                    <!-- Placeholder Card when no calculation performed yet -->
                    <div class="glass-card rounded-3xl p-8 sm:p-12 text-center shadow-xl border-dashed border-slate-800 flex flex-col items-center justify-center min-h-[420px]">
                        <div class="w-20 h-20 rounded-full bg-slate-900 border border-slate-800 flex items-center justify-center mb-6 shadow-inner text-rose-400/80 animate-float">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Menunggu Data Pasangan</h3>
                        <p class="text-slate-400 text-xs sm:text-sm max-w-sm leading-relaxed mb-6">
                            Isi nama lengkap dan tanggal lahir kedua pasangan pada form di sebelah kiri, kemudian klik tombol <strong class="text-slate-300">Hitung Kecocokan Jodoh</strong>.
                        </p>
                        <div class="inline-flex items-center gap-2 text-xs text-slate-500 bg-slate-900/60 px-3.5 py-2 rounded-full border border-slate-800">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>Hasil deterministik A + B == B + A</span>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slate-800/80 bg-slate-950/60 py-6 text-center text-xs text-slate-500">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p>&copy; {{ date('Y') }} Kalkulator Kecocokan Jodoh - By Fenando</p>
            <div class="flex items-center gap-4 text-slate-400">
                <span class="hover:text-rose-400 transition-colors">Clean Code Architecture</span>
                <span>•</span>
                </div>
        </div>
    </footer>

    <!-- Interactive Client Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Swap Button Handler
            const swapBtn = document.getElementById('swapBtn');
            if (swapBtn) {
                swapBtn.addEventListener('click', () => {
                    const p1Name = document.getElementById('person1_name');
                    const p1Date = document.getElementById('person1_birthdate');
                    const p2Name = document.getElementById('person2_name');
                    const p2Date = document.getElementById('person2_birthdate');

                    if (p1Name && p1Date && p2Name && p2Date) {
                        const tempName = p1Name.value;
                        const tempDate = p1Date.value;

                        p1Name.value = p2Name.value;
                        p1Date.value = p2Date.value;

                        p2Name.value = tempName;
                        p2Date.value = tempDate;

                        // Visual feedback animation
                        swapBtn.classList.add('rotate-180');
                        setTimeout(() => swapBtn.classList.remove('rotate-180'), 300);
                    }
                });
            }

            // 2. Copy Result Handler
            const copyBtn = document.getElementById('copyResultBtn');
            if (copyBtn) {
                copyBtn.addEventListener('click', () => {
                    @if(isset($result))
                        const textToCopy = `Hasil Kecocokan Jodoh: {{ $result['person1_name'] }} 💕 {{ $result['person2_name'] }}\nSkor: {{ $result['score'] }}% ({{ $result['category'] }})\n\n"{{ $result['narrative'] }}"\n\nDihitung via Kalkulator Kecocokan Jodoh (Laravel 12).`;
                        navigator.clipboard.writeText(textToCopy).then(() => {
                            const copyBtnText = document.getElementById('copyBtnText');
                            if (copyBtnText) {
                                copyBtnText.textContent = 'Tersalin!';
                                copyBtn.classList.remove('bg-rose-600/30', 'text-rose-200');
                                copyBtn.classList.add('bg-emerald-600/40', 'text-emerald-200');

                                setTimeout(() => {
                                    copyBtnText.textContent = 'Salin Hasil';
                                    copyBtn.classList.remove('bg-emerald-600/40', 'text-emerald-200');
                                    copyBtn.classList.add('bg-rose-600/30', 'text-rose-200');
                                }, 2000);
                            }
                        }).catch(err => {
                            console.error('Failed to copy: ', err);
                        });
                    @endif
                });
            }
        });
    </script>
</body>
</html>
