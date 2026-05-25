@extends('layouts.master')

@section('page-title', 'Owner Dashboard')
@section('sidebar-title', 'Catering Owner')

@section('navigation')
    <a href="{{ route('owner.dashboard') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('owner.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-home w-5 text-center"></i> Dashboard
    </a>

    <a href="{{ route('owner.laporan') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('owner.laporan') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-file-alt w-5 text-center"></i> Laporan Keuangan
    </a>

    <a href="{{ route('owner.pemesanans') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('owner.pemesanans') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-list w-5 text-center"></i> Semua Pesanan
    </a>

    <a href="{{ route('owner.export-pdf') }}"
       class="flex items-center gap-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('owner.export-pdf') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
        <i class="fas fa-file-pdf w-5 text-center"></i> Export PDF
    </a>
@endsection

@section('content')
    @include('layouts.partials.content')
@endsection
