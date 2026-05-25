@extends('layouts.master')

@section('page-title', 'Admin Dashboard')
@section('sidebar-title', 'Catering Admin')

@section('navigation')
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-home w-5 text-center"></i> Dashboard
    </a>

    <a href="{{ route('admin.pakets.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.pakets.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-box w-5 text-center"></i> Kelola Paket
    </a>

    <a href="{{ route('admin.pemesanans.index') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.pemesanans.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-shopping-cart w-5 text-center"></i> Pesanan
        @php
            $count = \App\Models\Pemesanan::where('status_pesan', 'Menunggu Konfirmasi')->count();
        @endphp
        @if($count > 0)
            <span class="ml-auto bg-red-500 text-white text-xs px-2 py-0.5 rounded-full">{{ $count }}</span>
        @endif
    </a>

    <a href="{{ route('admin.laporan') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('admin.laporan') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-chart-bar w-5 text-center"></i> Laporan
    </a>
@endsection

@section('content')
    @include('layouts.partials.content')
@endsection

