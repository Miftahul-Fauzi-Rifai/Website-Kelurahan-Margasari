@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengaturan Sistem</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengaturan</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-cog me-1"></i>
            Pengaturan Umum
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" data-auto-dismiss="true">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    @foreach($settings as $setting)
                        <div class="col-md-6 mb-3">
                            <label for="setting_{{ $setting->id }}" class="form-label">
                                <strong>{{ $setting->label }}</strong>
                            </label>
                            @if($setting->description)
                                <small class="form-text text-muted d-block mb-2">
                                    {{ $setting->description }}
                                </small>
                            @endif
                            <input 
                                type="text" 
                                class="form-control @error('settings.'.$loop->index.'.value') is-invalid @enderror" 
                                id="setting_{{ $setting->id }}"
                                name="settings[{{ $loop->index }}][value]"
                                value="{{ old('settings.'.$loop->index.'.value', $setting->value) }}"
                            >
                            <input 
                                type="hidden" 
                                name="settings[{{ $loop->index }}][key]" 
                                value="{{ $setting->key }}"
                            >
                            @error('settings.'.$loop->index.'.value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <i class="fas fa-info-circle me-1"></i>
            Informasi
        </div>
        <div class="card-body">
            <p class="mb-2"><strong>Pengaturan ini digunakan untuk:</strong></p>
            <ul>
                <li>Nama Lurah akan muncul di laporan RT yang dicetak</li>
                <li>Nama Kelurahan akan muncul di header laporan</li>
                <li>Perubahan akan langsung diterapkan pada semua laporan yang dicetak</li>
            </ul>
        </div>
    </div>
</div>
@endsection
