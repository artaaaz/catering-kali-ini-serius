@extends('layouts.admin')

@section('page-title', 'Detail Pesanan')

@section('content')
<div class="detail-container">
    <!-- Header -->
    <div class="detail-header">
        <div class="header-info">
            <h1 class="detail-title">Detail Pesanan</h1>
            <p class="detail-subtitle">{{ $pemesanan->no_resi }}</p>
        </div>
        <div class="header-status">
            <span class="status-pill status-{{ str_replace(' ', '-', strtolower($pemesanan->status_pesan)) }}">
                <span class="status-dot"></span>
                {{ $pemesanan->status_pesan }}
            </span>
            <button class="btn-print" onclick="window.print()">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                    <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"></path>
                    <rect x="6" y="14" width="12" height="8"></rect>
                </svg>
                Print
            </button>
        </div>
    </div>

    <div class="detail-content">
        <!-- Customer Info -->
        <div class="detail-card">
            <div class="card-title-row">
                <div class="title-icon customer">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <h3>Informasi Pelanggan</h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <label>Nama Lengkap</label>
                    <span>{{ $pemesanan->pelanggan->name ?? '-' }}</span>
                </div>
                <div class="info-item">
                    <label>Email</label>
                    <span>{{ $pemesanan->pelanggan->email ?? '-' }}</span>
                </div>
                <div class="info-item full">
                    <label>Alamat Pengiriman</label>
                    <span>{{ $pemesanan->alamat_pengiriman ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Package Details -->
        <div class="detail-card">
            <div class="card-title-row">
                <div class="title-icon package">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line>
                        <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div>
                <h3>Detail Paket</h3>
            </div>
            @foreach($pemesanan->pakets as $paket)
            <div class="package-row">
                <img src="{{ asset('storage/' . $paket->foto1) }}" alt="{{ $paket->nama_paket }}" class="package-thumb">
                <div class="package-details">
                    <h4>{{ $paket->nama_paket }}</h4>
                    <div class="tags">
                        <span>{{ $paket->jenis }}</span>
                        <span>{{ $paket->kategori }}</span>
                    </div>
                    <div class="package-meta">
                        <span>Jumlah Pax: <strong>{{ $paket->pivot->jumlah_pax ?? $pemesanan->jumlah_pax }}</strong></span>
                        <span>Harga: <strong>Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</strong></span>
                    </div>
                </div>
                <div class="package-total">
                    <small>Subtotal</small>
                    <strong>Rp {{ number_format($paket->pivot->subtotal ?? $pemesanan->total_bayar, 0, ',', '.') }}</strong>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Payment Info -->
        <div class="detail-card">
            <div class="card-title-row">
                <div class="title-icon payment">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                        <line x1="1" y1="10" x2="23" y2="10"></line>
                    </svg>
                </div>
                <h3>Informasi Pembayaran</h3>
            </div>
            <div class="payment-row">
                <div class="payment-method">
                    <label>Metode Pembayaran</label>
                    <div class="method-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2"></rect>
                            <line x1="2" y1="10" x2="22" y2="10"></line>
                        </svg>
                        {{ $pemesanan->jenisPembayaran->metode_pembayaran ?? '-' }}
                    </div>
                </div>
                <div class="payment-date">
                    <label>Tanggal Acara</label>
                    <div class="date-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        {{ \Carbon\Carbon::parse($pemesanan->tgl_acara)->format('d M Y') }}
                    </div>
                </div>
            </div>
            @if($pemesanan->bukti_bayar)
            <div class="proof-section">
                <label>Bukti Pembayaran</label>
                <a href="{{ asset('storage/' . $pemesanan->bukti_bayar) }}" target="_blank" class="proof-link">
                    <img src="{{ asset('storage/' . $pemesanan->bukti_bayar) }}" alt="Bukti">
                </a>
            </div>
            @endif
            <div class="total-bar">
                <span>Total Pembayaran</span>
                <span class="total-amount">Rp {{ number_format($pemesanan->total_bayar, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- UPDATE STATUS SECTION (Dipindah sini) -->
        <div class="detail-card update-section">
            <div class="card-title-row">
                <div class="title-icon status">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <h3>Update Status Pesanan</h3>
            </div>

            @if(session('success'))
            <div class="alert-success">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('admin.pemesanans.updateStatus', $pemesanan->id) }}" method="POST" class="update-form">
                @csrf
                @method('PATCH')

                <div class="form-row">
                    <div class="form-group">
                        <label>Status Baru</label>
                        <select name="status_pesan" class="modern-select" required>
                            <option value="">Pilih Status...</option>
                            <option value="Menunggu Konfirmasi" {{ $pemesanan->status_pesan == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                            <option value="Sedang Diproses" {{ $pemesanan->status_pesan == 'Sedang Diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                            <option value="Menunggu Kurir" {{ $pemesanan->status_pesan == 'Menunggu Kurir' ? 'selected' : '' }}>Menunggu Kurir</option>
                            <option value="Sedang Dikirim" {{ $pemesanan->status_pesan == 'Sedang Dikirim' ? 'selected' : '' }}>Sedang Dikirim</option>
                            <option value="Selesai" {{ $pemesanan->status_pesan == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ $pemesanan->status_pesan == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Update Status
                        </button>
                        <a href="{{ route('admin.pemesanans.index') }}" class="btn-back">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            Kembali
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- TIMELINE (Horizontal Compact) -->
        <div class="detail-card timeline-section">
            <div class="card-title-row">
                <div class="title-icon timeline">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                </div>
                <h3>Progress Pesanan</h3>
            </div>
            <div class="timeline-horizontal">
                <div class="step {{ in_array($pemesanan->status_pesan, ['Menunggu Konfirmasi', 'Sedang Diproses', 'Menunggu Kurir', 'Sedang Dikirim', 'Selesai']) ? 'completed' : '' }}">
                    <div class="step-dot"></div>
                    <div class="step-info">
                        <strong>Dibuat</strong>
                        <span>{{ $pemesanan->created_at->format('d M') }}</span>
                    </div>
                </div>
                <div class="step {{ in_array($pemesanan->status_pesan, ['Sedang Diproses', 'Menunggu Kurir', 'Sedang Dikirim', 'Selesai']) ? 'completed' : '' }}">
                    <div class="step-dot"></div>
                    <div class="step-info">
                        <strong>Diproses</strong>
                        <span>Persiapan</span>
                    </div>
                </div>
                <div class="step {{ in_array($pemesanan->status_pesan, ['Menunggu Kurir', 'Sedang Dikirim', 'Selesai']) ? 'completed' : '' }}">
                    <div class="step-dot"></div>
                    <div class="step-info">
                        <strong>Kurir</strong>
                        <span>Penjemputan</span>
                    </div>
                </div>
                <div class="step {{ in_array($pemesanan->status_pesan, ['Sedang Dikirim', 'Selesai']) ? 'completed' : '' }}">
                    <div class="step-dot"></div>
                    <div class="step-info">
                        <strong>Dikirim</strong>
                        <span>Pengiriman</span>
                    </div>
                </div>
                <div class="step {{ $pemesanan->status_pesan == 'Selesai' ? 'completed' : '' }}">
                    <div class="step-dot"></div>
                    <div class="step-info">
                        <strong>Selesai</strong>
                        <span>Diterima</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary: #6366f1;
    --primary-light: #818cf8;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --bg: #f1f5f9;
    --card: #ffffff;
    --text: #1e293b;
    --text-secondary: #64748b;
    --border: #e2e8f0;
    --radius: 12px;
}

.detail-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
}

/* Header */
.detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.detail-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
}

.detail-subtitle {
    color: var(--text-secondary);
    margin: 0.25rem 0 0 0;
    font-size: 0.875rem;
}

.header-status {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.875rem;
}

.status-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: currentColor;
}

.status-menunggu-konfirmasi { background: #fef3c7; color: #d97706; }
.status-sedang-diproses { background: #dbeafe; color: #2563eb; }
.status-menunggu-kurir { background: #e0e7ff; color: #4f46e5; }
.status-sedang-dikirim { background: #cffafe; color: #0891b2; }
.status-selesai { background: #d1fae5; color: #059669; }
.status-dibatalkan { background: #fee2e2; color: #dc2626; }

.btn-print {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border: 1px solid var(--border);
    background: var(--card);
    border-radius: 8px;
    cursor: pointer;
    color: var(--text-secondary);
    font-weight: 500;
    transition: all 0.2s;
}

.btn-print:hover {
    background: var(--bg);
    color: var(--text);
}

/* Cards */
.detail-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.detail-card {
    background: var(--card);
    border-radius: var(--radius);
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
}

.card-title-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.25rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border);
}

.title-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.title-icon.customer { background: linear-gradient(135deg, #60a5fa, #3b82f6); }
.title-icon.package { background: linear-gradient(135deg, #f472b6, #ec4899); }
.title-icon.payment { background: linear-gradient(135deg, #34d399, #10b981); }
.title-icon.status { background: linear-gradient(135deg, #a78bfa, #8b5cf6); }
.title-icon.timeline { background: linear-gradient(135deg, #fbbf24, #f59e0b); }

.card-title-row h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text);
    margin: 0;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.info-item.full {
    grid-column: 1 / -1;
}

.info-item label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.info-item span {
    font-size: 0.9375rem;
    color: var(--text);
    font-weight: 600;
}

/* Package Row */
.package-row {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg);
    border-radius: 8px;
    align-items: center;
}

.package-thumb {
    width: 64px;
    height: 64px;
    border-radius: 8px;
    object-fit: cover;
}

.package-details {
    flex: 1;
}

.package-details h4 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 0.5rem 0;
}

.tags {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.tags span {
    padding: 0.125rem 0.5rem;
    background: white;
    border: 1px solid var(--border);
    border-radius: 4px;
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.package-meta {
    display: flex;
    gap: 1.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.package-total {
    text-align: right;
}

.package-total small {
    display: block;
    color: var(--text-secondary);
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
}

.package-total strong {
    font-size: 1.125rem;
    color: var(--primary);
}

/* Payment */
.payment-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
    margin-bottom: 1.25rem;
}

.payment-method, .payment-date {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.payment-method label, .payment-date label {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.method-badge, .date-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: #d1fae5;
    color: #059669;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
}

.date-badge {
    background: var(--bg);
    color: var(--text);
}

.proof-section {
    margin-bottom: 1.25rem;
}

.proof-section label {
    display: block;
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.proof-link img {
    max-height: 200px;
    border-radius: 8px;
    border: 1px solid var(--border);
}

.total-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-light));
    border-radius: 8px;
    color: white;
}

.total-bar span:first-child {
    font-weight: 500;
}

.total-amount {
    font-size: 1.5rem;
    font-weight: 700;
}

/* Update Section */
.update-section {
    border: 2px solid var(--primary);
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.02), rgba(99, 102, 241, 0.05));
}

.update-form .form-row {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
}

.form-group {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text);
}

.modern-select {
    padding: 0.75rem 1rem;
    border: 2px solid var(--border);
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 500;
    background: white;
    color: var(--text);
    transition: all 0.2s;
}

.modern-select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.form-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-save {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-save:hover {
    background: var(--primary-light);
    transform: translateY(-1px);
}

.btn-back {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    background: white;
    color: var(--text-secondary);
    border: 2px solid var(--border);
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-back:hover {
    background: var(--bg);
    color: var(--text);
}

.alert-success {
    padding: 0.875rem 1rem;
    background: #d1fae5;
    color: #059669;
    border-radius: 8px;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-weight: 500;
}

/* Timeline Horizontal */
.timeline-section {
    background: var(--bg);
}

.timeline-horizontal {
    display: flex;
    justify-content: space-between;
    position: relative;
    padding-top: 1rem;
}

.timeline-horizontal::before {
    content: '';
    position: absolute;
    top: 1.5rem;
    left: 2rem;
    right: 2rem;
    height: 2px;
    background: var(--border);
    z-index: 0;
}

.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    position: relative;
    z-index: 1;
    flex: 1;
}

.step-dot {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: white;
    border: 2px solid var(--border);
    transition: all 0.3s;
}

.step.completed .step-dot {
    background: var(--success);
    border-color: var(--success);
    box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
}

.step-info {
    text-align: center;
}

.step-info strong {
    display: block;
    font-size: 0.875rem;
    color: var(--text);
    margin-bottom: 0.25rem;
}

.step-info span {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

/* Responsive */
@media (max-width: 768px) {
    .detail-container {
        padding: 1rem;
    }

    .detail-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-grid, .payment-row {
        grid-template-columns: 1fr;
    }

    .package-row {
        flex-direction: column;
        text-align: center;
    }

    .package-total {
        text-align: center;
    }

    .update-form .form-row {
        flex-direction: column;
    }

    .form-actions {
        width: 100%;
        justify-content: stretch;
    }

    .btn-save, .btn-back {
        flex: 1;
        justify-content: center;
    }

    .timeline-horizontal {
        flex-direction: column;
        gap: 1rem;
        padding-left: 2rem;
    }

    .timeline-horizontal::before {
        top: 0;
        bottom: 0;
        left: 1rem;
        right: auto;
        width: 2px;
        height: auto;
    }

    .step {
        flex-direction: row;
        gap: 1rem;
    }
}
</style>
@endsectioninear-gradient(135deg, #60a5fa, #3b82f6);
    color: white;
.package-icon {
    background: linear-gradient(135deg, #f472b6, #ec4899);
    color: white;
}

.payment-icon {
    background: linear-gradient(135deg, #34d399, #10b981);
    color: white;
}

.settings-icon {
    background: linear-gradient(135deg, #a78bfa, #8b5cf6);
    color: white;
}

.timeline-icon {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.card-body {
    padding: 1.5rem;
}

/* Info Grid */
.info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-item.full-width {
    grid-column: 1 / -1;
}

.info-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.info-value {
    font-size: 1rem;
    color: var(--text-primary);
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.inline-icon {
    color: var(--primary);
    flex-shrink: 0;
}

.address {
    line-height: 1.6;
}

/* Package Item */
.package-item {
    display: grid;
    grid-template-columns: 100px 1fr auto;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--bg-primary);
    border-radius: var(--radius-sm);
    margin-bottom: 1rem;
}

.package-item:last-child {
    margin-bottom: 0;
}

.package-image {
    width: 100px;
    height: 100px;
    border-radius: var(--radius-sm);
    overflow: hidden;
    background: var(--bg-primary);
}

.package-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-secondary);
    background: var(--border-color);
}

.package-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.package-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.package-tags {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.tag {
    padding: 0.25rem 0.75rem;
    background: white;
    border: 1px solid var(--border-color);
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
    color: var(--text-secondary);
}

.package-details {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.detail-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.detail-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
}

.package-price {
    text-align: right;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.price-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
}

.price-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary);
}

/* Payment */
.payment-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.payment-method,
.payment-dates {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.payment-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border-radius: var(--radius-sm);
    font-weight: 600;
    color: #059669;
}

.date-display {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    background: var(--bg-primary);
    border-radius: var(--radius-sm);
    font-weight: 600;
    color: var(--text-primary);
}

.payment-proof {
    margin-bottom: 1.5rem;
}

.proof-container {
    position: relative;
    border-radius: var(--radius-sm);
    overflow: hidden;
    border: 2px solid var(--border-color);
}

.proof-link {
    display: block;
    position: relative;
}

.proof-image {
    width: 100%;
    max-height: 250px;
    object-fit: contain;
    display: block;
}

.proof-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    opacity: 0;
    transition: opacity 0.3s;
    color: white;
    font-weight: 600;
}

.proof-link:hover .proof-overlay {
    opacity: 1;
}

.total-section {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: var(--radius-sm);
    padding: 1.5rem;
    color: white;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-label {
    font-size: 1rem;
    font-weight: 500;
}

.total-amount {
    font-size: 1.75rem;
    font-weight: 700;
}

/* Sidebar */
.sidebar {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.sidebar-card {
    position: sticky;
    top: 2rem;
}

/* Form */
.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.modern-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-sm);
    font-size: 0.875rem;
    font-weight: 500;
    background: var(--bg-card);
    color: var(--text-primary);
    cursor: pointer;
    transition: all 0.2s;
}

.modern-select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.btn-primary {
    width: 100%;
    padding: 0.875rem 1.25rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    box-shadow: var(--shadow-md);
    transition: all 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
}

.btn-secondary {
    width: 100%;
    padding: 0.875rem 1.25rem;
    background: var(--bg-primary);
    color: var(--text-secondary);
    border: 2px solid var(--border-color);
    border-radius: var(--radius-sm);
    font-weight: 600;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
    transition: all 0.2s;
}

.btn-secondary:hover {
    background: var(--border-color);
    color: var(--text-primary);
}

.alert-success {
    padding: 0.875rem 1rem;
    background: #d1fae5;
    color: #059669;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.25rem;
    font-weight: 500;
}

/* Timeline Modern */
.timeline-modern {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.timeline-step {
    display: flex;
    gap: 1rem;
    position: relative;
}

.timeline-step:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 23px;
    top: 40px;
    width: 2px;
    height: calc(100% + 0.5rem);
    background: var(--border-color);
}

.timeline-step.completed:not(:last-child)::before {
    background: var(--success);
}

.step-marker {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--bg-primary);
    border: 2px solid var(--border-color);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    z-index: 1;
}

.step-marker.completed {
    background: var(--success);
    border-color: var(--success);
    color: white;
}

.step-marker svg {
    width: 14px;
    height: 14px;
}

.step-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--border-color);
}

.step-content {
    flex: 1;
    padding-top: 0.25rem;
}

.step-title {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.step-date {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

/* Responsive */
@media (max-width: 1024px) {
    .modern-grid {
        grid-template-columns: 1fr;
    }

    .sidebar {
        position: static;
    }

    .sidebar-card {
        position: static;
    }
}

@media (max-width: 768px) {
    .modern-container {
        padding: 1rem;
    }

    .page-title {
        font-size: 1.25rem;
    }

    .info-grid,
    .payment-grid {
        grid-template-columns: 1fr;
    }

    .package-item {
        grid-template-columns: 1fr;
    }

    .package-price {
        text-align: left;
    }
</style>
@endsection
