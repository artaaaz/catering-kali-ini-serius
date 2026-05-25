@extends('layouts.master')

@section('page-title', 'Kurir Dashboard')
@section('sidebar-title', 'Kurir Catering')

@section('navigation')
    <a href="{{ route('kurir.dashboard') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('kurir.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-home w-5 text-center"></i> Dashboard
    </a>

    <a href="{{ route('kurir.pengiriman') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('kurir.pengiriman') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-truck w-5 text-center"></i> Tugas Pengiriman
        @php
            $count = \App\Models\Pemesanan::whereIn('status_pesan', ['Menunggu Kurir', 'Sedang Dikirim'])->count();
        @endphp
        @if($count > 0)
            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $count }}</span>
        @endif
    </a>

    <a href="{{ route('kurir.riwayat') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('kurir.riwayat') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-history w-5 text-center"></i> Riwayat
    </a>
@endsection

@section('content')
    @include('layouts.partials.content')
@endsection
