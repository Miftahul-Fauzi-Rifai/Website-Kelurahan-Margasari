@extends('layouts.app')

@section('title', 'Detail RT ' . $rt->rt_code . ' - Kelurahan Marga Sari')

@section('content')
<section class="bg-primary text-white py-4 py-md-5 page-header-rt">
  <div class="container">
    <h1 class="display-5 display-md-4 fw-bold mobile-title">Detail RT {{ $rt->rt_code }}</h1>
    <p class="lead mb-0 mobile-subtitle">Informasi lengkap ketua RT, statistik penduduk, dan data wilayah</p>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row g-3">
      <!-- Left Column -->
      <div class="col-lg-6">
        <!-- Profil Ketua RT & Statistik Warga -->
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0"><i class="bi bi-person-badge me-2"></i>Profil Ketua RT</h6>
          </div>
          <div class="card-body py-3">
            <div class="row">
              <div class="col-md-3 text-center mb-3 mb-md-0">
                @if($rt->ketua_rt_photo && file_exists(public_path('storage/' . $rt->ketua_rt_photo)))
                  <img src="{{ asset('storage/' . $rt->ketua_rt_photo) }}" 
                       alt="Foto {{ $rt->ketua_rt_name }}" 
                       class="img-thumbnail"
                       style="width: 150px; height: 150px; object-fit: cover;"
                       onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'border d-flex align-items-center justify-content-center bg-light mx-auto\' style=\'width: 150px; height: 150px;\'><i class=\'bi bi-person-circle text-muted\' style=\'font-size: 4rem;\'></i></div>';">
                @else
                  <div class="border d-flex align-items-center justify-content-center bg-light mx-auto" 
                       style="width: 150px; height: 150px;">
                    <i class="bi bi-person-circle text-muted" style="font-size: 4rem;"></i>
                  </div>
                @endif
              </div>
              <div class="col-md-4">
                <h5 class="fw-bold mb-1">{{ $rt->ketua_rt_name ?? 'Belum diisi' }}</h5>
                <div class="text-muted small mb-1">Ketua RT {{ $rt->rt_code }}</div>
                <div class="small mb-1"><i class="bi bi-telephone me-1"></i>{{ $rt->ketua_rt_phone ?? '-' }}</div>
                @if($rt->address)
                <div class="small mb-2">
                  <i class="bi bi-house-door me-1"></i>{{ $rt->address }}
                </div>
                @endif
                
                @if($rt->ketua_rt_profession || $rt->ketua_rt_age || $rt->ketua_rt_tenure_years)
                <div class="border-top pt-2 mt-2">
                  @if($rt->ketua_rt_age || $rt->ketua_rt_profession)
                  <div class="small mb-1">
                    @if($rt->ketua_rt_age)<span class="badge bg-info me-1">{{ $rt->ketua_rt_age }} tahun</span>@endif
                    @if($rt->ketua_rt_profession)<span class="badge bg-success">{{ $rt->ketua_rt_profession }}</span>@endif
                  </div>
                  @endif
                  @if($rt->ketua_rt_tenure_years)
                  <div class="small"><i class="bi bi-clock-history me-1"></i>Masa Jabatan: {{ $rt->ketua_rt_tenure_years }} tahun</div>
                  @endif
                </div>
                @endif
              </div>
              <div class="col-md-5">
                <div class="row text-center g-2">
                  <div class="col-6">
                    <div class="bg-light rounded p-2">
                      <i class="bi bi-people text-primary"></i>
                      <div class="fw-bold">{{ $rt->num_population }}</div>
                      <small class="text-muted">Warga</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="bg-light rounded p-2">
                      <i class="bi bi-house text-success"></i>
                      <div class="fw-bold">{{ $rt->num_households }}</div>
                      <small class="text-muted">KK</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="bg-light rounded p-2">
                      <i class="bi bi-gender-male text-info"></i>
                      <div class="fw-bold">{{ $rt->num_male }}</div>
                      <small class="text-muted">L</small>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="bg-light rounded p-2">
                      <i class="bi bi-gender-female text-danger"></i>
                      <div class="fw-bold">{{ $rt->num_female }}</div>
                      <small class="text-muted">P</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Mata Pencaharian & Tingkat Pendidikan -->
        <div class="row g-3 mb-3">
          @if($rt->mata_pencaharian && array_sum($rt->mata_pencaharian) > 0)
          <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-header bg-primary text-white py-2">
                <h6 class="mb-0 small"><i class="bi bi-briefcase me-1"></i>Mata Pencaharian</h6>
              </div>
              <div class="card-body py-2">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <small><i class="bi bi-shop text-success"></i> Pedagang</small>
                  <span class="text-dark">{{ $rt->mata_pencaharian['pedagang'] ?? 0 }}%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <small><i class="bi bi-person-workspace text-primary"></i> Karyawan</small>
                  <span class="text-dark">{{ $rt->mata_pencaharian['karyawan'] ?? 0 }}%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <small><i class="bi bi-hammer text-warning"></i> Buruh</small>
                  <span class="text-dark">{{ $rt->mata_pencaharian['buruh'] ?? 0 }}%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <small><i class="bi bi-three-dots text-info"></i> Lainnya</small>
                  <span class="text-dark">{{ $rt->mata_pencaharian['lainnya'] ?? 0 }}%</span>
                </div>
              </div>
            </div>
          </div>
          @endif

          @if($rt->tingkat_pendidikan && array_sum($rt->tingkat_pendidikan) > 0)
          <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-header bg-primary text-white py-2">
                <h6 class="mb-0 small"><i class="bi bi-mortarboard me-1"></i>Tingkat Pendidikan</h6>
              </div>
              <div class="card-body py-2">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <small><i class="bi bi-book text-primary"></i> SD</small>
                  <span class="text-dark">{{ $rt->tingkat_pendidikan['sd'] ?? 0 }}%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <small><i class="bi bi-book-half text-success"></i> SMP</small>
                  <span class="text-dark">{{ $rt->tingkat_pendidikan['smp'] ?? 0 }}%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <small><i class="bi bi-journal-text text-warning"></i> SMA</small>
                  <span class="text-dark">{{ $rt->tingkat_pendidikan['sma'] ?? 0 }}%</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <small><i class="bi bi-mortarboard-fill text-info"></i> Kuliah</small>
                  <span class="text-dark">{{ $rt->tingkat_pendidikan['kuliah'] ?? 0 }}%</span>
                </div>
              </div>
            </div>
          </div>
          @endif
        </div>

        <!-- Bantuan Sosial & Kegiatan Rutin -->
        <div class="row g-3 mb-3">
          @if($rt->bantuan_sosial && array_sum($rt->bantuan_sosial) > 0)
          <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-header bg-primary text-white py-2">
                <h6 class="mb-0 small"><i class="bi bi-heart me-1"></i>Bantuan Sosial</h6>
              </div>
              <div class="card-body py-2">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small><i class="bi bi-cash-stack text-primary"></i> PKH</small>
                  <span class="text-dark">{{ $rt->bantuan_sosial['pkh'] ?? 0 }} KK</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small><i class="bi bi-currency-dollar text-success"></i> BLT</small>
                  <span class="text-dark">{{ $rt->bantuan_sosial['blt'] ?? 0 }} KK</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                  <small><i class="bi bi-gift text-info"></i> Lainnya</small>
                  <span class="text-dark">{{ $rt->bantuan_sosial['lainnya'] ?? 0 }} KK</span>
                </div>
              </div>
            </div>
          </div>
          @endif

          @if($rt->kegiatan_rutin && count(array_filter($rt->kegiatan_rutin)) > 0)
          <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-header bg-primary text-white py-2">
                <h6 class="mb-0 small"><i class="bi bi-calendar-event me-1"></i>Kegiatan Rutin (Per Bulan)</h6>
              </div>
              <div class="card-body py-2">
                @if(isset($rt->kegiatan_rutin['pengajian']) && $rt->kegiatan_rutin['pengajian'])
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small><i class="bi bi-book-fill text-success"></i> Pengajian</small>
                  <span class="text-dark">{{ $rt->kegiatan_rutin['pengajian'] == 'lebih_dari_3' ? 'Lebih dari 3x' : 'Kurang dari 3x' }}</span>
                </div>
                @endif
                @if(isset($rt->kegiatan_rutin['posyandu']) && $rt->kegiatan_rutin['posyandu'])
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small><i class="bi bi-hospital text-info"></i> Posyandu</small>
                  <span class="text-dark">{{ $rt->kegiatan_rutin['posyandu'] == 'lebih_dari_3' ? 'Lebih dari 3x' : 'Kurang dari 3x' }}</span>
                </div>
                @endif
                @if(isset($rt->kegiatan_rutin['kerja_bakti']) && $rt->kegiatan_rutin['kerja_bakti'])
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small><i class="bi bi-broom text-warning"></i> Kerja Bakti</small>
                  <span class="text-dark">{{ $rt->kegiatan_rutin['kerja_bakti'] == 'lebih_dari_3' ? 'Lebih dari 3x' : 'Kurang dari 3x' }}</span>
                </div>
                @endif
                @if(isset($rt->kegiatan_rutin['lainnya']) && $rt->kegiatan_rutin['lainnya'])
                <div class="d-flex justify-content-between align-items-center">
                  <small><i class="bi bi-three-dots text-danger"></i> Lainnya</small>
                  <span class="text-dark">{{ $rt->kegiatan_rutin['lainnya'] == 'lebih_dari_3' ? 'Lebih dari 3x' : 'Kurang dari 3x' }}</span>
                </div>
                @endif
              </div>
            </div>
          </div>
          @endif
        </div>

        <!-- Fasilitas Umum -->
        @if($rt->fasilitas_umum)
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 small"><i class="bi bi-buildings me-1"></i>Fasilitas Umum</h6>
          </div>
          <div class="card-body py-2">
            <div class="row g-2">
              @if(isset($rt->fasilitas_umum['masjid']) && $rt->fasilitas_umum['masjid'] > 0)
              <div class="col-4">
                <div class="text-center bg-light rounded p-2">
                  <i class="bi bi-building text-primary"></i>
                  <div class="small fw-bold text-dark">{{ $rt->fasilitas_umum['masjid'] }}</div>
                  <small class="text-muted">Masjid</small>
                </div>
              </div>
              @endif
              @if(isset($rt->fasilitas_umum['musholla']) && $rt->fasilitas_umum['musholla'] > 0)
              <div class="col-4">
                <div class="text-center bg-light rounded p-2">
                  <i class="bi bi-house-heart text-success"></i>
                  <div class="small fw-bold text-dark">{{ $rt->fasilitas_umum['musholla'] }}</div>
                  <small class="text-muted">Musholla</small>
                </div>
              </div>
              @endif
              @if(isset($rt->fasilitas_umum['posyandu']) && $rt->fasilitas_umum['posyandu'] > 0)
              <div class="col-4">
                <div class="text-center bg-light rounded p-2">
                  <i class="bi bi-hospital text-info"></i>
                  <div class="small fw-bold text-dark">{{ $rt->fasilitas_umum['posyandu'] }}</div>
                  <small class="text-muted">Posyandu</small>
                </div>
              </div>
              @endif
              @if(isset($rt->fasilitas_umum['bank_sampah']) && $rt->fasilitas_umum['bank_sampah'] > 0)
              <div class="col-4">
                <div class="text-center bg-light rounded p-2">
                  <i class="bi bi-recycle text-warning"></i>
                  <div class="small fw-bold text-dark">{{ $rt->fasilitas_umum['bank_sampah'] }}</div>
                  <small class="text-muted">Bank Sampah</small>
                </div>
              </div>
              @endif
              @if(isset($rt->fasilitas_umum['pos_ronda']) && $rt->fasilitas_umum['pos_ronda'] > 0)
              <div class="col-4">
                <div class="text-center bg-light rounded p-2">
                  <i class="bi bi-shield-check text-danger"></i>
                  <div class="small fw-bold text-dark">{{ $rt->fasilitas_umum['pos_ronda'] }}</div>
                  <small class="text-muted">Pos Ronda</small>
                </div>
              </div>
              @endif
            </div>
            @if(isset($rt->fasilitas_umum['lainnya']) && $rt->fasilitas_umum['lainnya'])
            <div class="alert alert-info mt-2 mb-0 py-1 px-2">
              <small><i class="bi bi-info-circle me-1"></i><strong>Lainnya:</strong> {{ $rt->fasilitas_umum['lainnya'] }}</small>
            </div>
            @endif
          </div>
        </div>
        @endif
      </div>

      <!-- Right Column -->
      <div class="col-lg-6">
        <!-- Lokasi Peta -->
        <div class="card border-0 shadow-sm mb-3">
          <div class="card-header bg-primary text-white py-2">
            <h6 class="mb-0 small"><i class="bi bi-geo-alt me-1"></i>Lokasi RT pada Peta</h6>
          </div>
          <div class="card-body p-0">
            <link rel="stylesheet" href="{{ asset('leaflet.css') }}">
            <div id="map" style="height: 380px;"></div>
          </div>
        </div>

        <!-- Kondisi Infrastruktur & Masalah Lingkungan -->
        <div class="row g-3">
          @if($rt->kondisi_infrastruktur)
          <div class="col-md-7">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-header bg-primary text-white py-2">
                <h6 class="mb-0 small"><i class="bi bi-hammer me-1"></i>Kondisi Infrastruktur</h6>
              </div>
              <div class="card-body py-2">
                @if(isset($rt->kondisi_infrastruktur['jalan']))
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small><i class="bi bi-sign-turn-right me-1 text-primary"></i>Jalan</small>
                  <span class="text-dark">
                    {{ ucfirst($rt->kondisi_infrastruktur['jalan']) }}
                  </span>
                </div>
                @endif
                @if(isset($rt->kondisi_infrastruktur['saluran_air']))
                <div class="d-flex justify-content-between align-items-center mb-2">
                  <small><i class="bi bi-droplet me-1 text-info"></i>Saluran Air</small>
                  <span class="text-dark">
                    {{ ucfirst($rt->kondisi_infrastruktur['saluran_air']) }}
                  </span>
                </div>
                @endif
                @if(isset($rt->kondisi_infrastruktur['penerangan']))
                <div class="d-flex justify-content-between align-items-center">
                  <small><i class="bi bi-lightbulb me-1 text-warning"></i>Penerangan</small>
                  <span class="text-dark">
                    {{ ucfirst($rt->kondisi_infrastruktur['penerangan']) }}
                  </span>
                </div>
                @endif
              </div>
            </div>
          </div>
          @endif

          @if($rt->masalah_lingkungan)
          <div class="col-md-5">
            <div class="card border-0 shadow-sm h-100">
              <div class="card-header bg-primary text-white py-2">
                <h6 class="mb-0 small"><i class="bi bi-exclamation-triangle me-1"></i>Masalah Lingkungan</h6>
              </div>
              <div class="card-body py-2">
                @if(isset($rt->masalah_lingkungan['banjir']) && $rt->masalah_lingkungan['banjir'])
                <div class="mb-2">
                  <small><i class="bi bi-droplet text-primary"></i> Rawan Banjir</small>
                </div>
                @endif
                @if(isset($rt->masalah_lingkungan['sampah']) && $rt->masalah_lingkungan['sampah'])
                <div class="mb-0">
                  <small><i class="bi bi-trash text-warning"></i> Masalah Sampah</small>
                </div>
                @endif
                @if((!isset($rt->masalah_lingkungan['banjir']) || !$rt->masalah_lingkungan['banjir']) && 
                    (!isset($rt->masalah_lingkungan['sampah']) || !$rt->masalah_lingkungan['sampah']))
                <div class="text-center">
                  <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                  <div class="small text-muted">Tidak ada masalah</div>
                </div>
                @endif
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>

    <div class="mt-3">
      <a href="{{ route('rt.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i>Kembali ke Data RT
      </a>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
/* Orange Theme - Override Blue Colors */
.bg-primary {
  background-color: #CC710A !important;
}

.text-primary {
  color: #CC710A !important;
}

.btn-primary {
  background-color: #CC710A !important;
  border-color: #CC710A !important;
}

.btn-primary:hover {
  background-color: #A35808 !important;
  border-color: #A35808 !important;
}

.btn-primary:focus {
  box-shadow: 0 0 0 0.25rem rgba(204, 113, 10, 0.25) !important;
}

.badge.bg-info {
  background-color: #CC710A !important;
}

.card-header.bg-primary {
  background-color: #CC710A !important;
}

/* Page Header Spacing untuk menghindari navbar */
.page-header-rt {
  padding-top: 90px !important;
}

/* Mobile Header Optimizations */
.mobile-title {
  font-size: 1.8rem;
  line-height: 1.2;
  margin-bottom: 0.5rem;
}

.mobile-subtitle {
  font-size: 1rem;
  opacity: 0.9;
}

@media (min-width: 576px) {
  .mobile-title {
    font-size: 2.2rem;
  }
  
  .mobile-subtitle {
    font-size: 1.125rem;
  }
}

@media (min-width: 768px) {
  .mobile-title {
    font-size: 2.5rem;
  }
  
  .mobile-subtitle {
    font-size: 1.25rem;
  }
  
  .page-header-rt {
    padding-top: 90px !important;
  }
}

@media (max-width: 768px) {
  .page-header-rt {
    padding-top: 80px !important;
  }
}

@media (max-width: 576px) {
  .page-header-rt {
    padding-top: 70px !important;
  }
}

/* Leaflet Popup Styling - COMPACT SIZE */
.leaflet-popup-content-wrapper {
  background-color: #fff;
  color: #333;
  box-shadow: 0 3px 14px rgba(0,0,0,0.4);
}

.leaflet-popup-content {
  margin: 10px;
  line-height: 1.3;
}

.leaflet-popup-content h6 {
  color: #CC710A !important;
  margin-bottom: 8px;
}

.leaflet-popup-content .small {
  color: #333 !important;
  font-size: 0.875rem;
}

.leaflet-popup-content a.btn {
  text-decoration: none;
  display: block;
  text-align: center;
  padding: 8px 12px;
  border-radius: 4px;
  font-weight: 500;
  transition: all 0.2s;
}

.leaflet-popup-content a.btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.leaflet-popup-tip {
  background-color: #fff;
}

.leaflet-popup-content i {
  color: #28a745 !important;
}

.leaflet-popup-content .btn i {
  color: #fff !important;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('leaflet.js') }}"></script>
<script>
  const lat = {{ $rt->latitude ?? 'null' }};
  const lng = {{ $rt->longitude ?? 'null' }};
  const rtData = {
    rt_code: '{{ $rt->rt_code }}',
    name: '{{ $rt->name }}',
    ketua_rt_name: '{{ $rt->ketua_rt_name }}',
    ketua_rt_phone: '{{ $rt->ketua_rt_phone }}',
    address: '{{ $rt->address ?? '' }}',
    num_population: {{ $rt->num_population ?? 0 }},
    num_households: {{ $rt->num_households ?? 0 }}
  };

  const map = L.map('map').setView([lat ?? -1.2379, lng ?? 116.8289], lat && lng ? 16 : 13);
  
  // Google Maps Hybrid (Satelit + Label jalan & bangunan)
  L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    attribution: '&copy; Google Maps'
  }).addTo(map);

  // Function untuk warna berdasarkan populasi
  const populationToColor = (pop) => {
    if (pop >= 300) return '#d73027';
    if (pop >= 250) return '#fc8d59';
    if (pop >= 200) return '#fee08b';
    if (pop >= 150) return '#91cf60';
    return '#4575b4';
  };

  // Data batas wilayah Kelurahan Margasari
  const kelurahanBoundary = {
    "type": "FeatureCollection",
    "features": [
      {
        "type": "Feature",
        "properties": {
          "name": "Batas Kelurahan Margasari"
        },
        "geometry": {
          "coordinates": [
            [
              116.82265233098497,
              -1.240431056886834
            ],
            [
              116.82234187253704,
              -1.2401206711876824
            ],
            [
              116.82226425792862,
              -1.2403057088092595
            ],
            [
              116.82199294163911,
              -1.2401064795903665
            ],
            [
              116.8217272608806,
              -1.2397513266998175
            ],
            [
              116.82139292105006,
              -1.2393722979325759
            ],
            [
              116.82101380356221,
              -1.2390738500450311
            ],
            [
              116.8204248624819,
              -1.238865153390222
            ],
            [
              116.81973368880739,
              -1.2386936613280994
            ],
            [
              116.81924431766424,
              -1.2386331347151298
            ],
            [
              116.81847242297795,
              -1.2385625203312571
            ],
            [
              116.81754176089697,
              -1.2386297752996427
            ],
            [
              116.817150001985,
              -1.238697856149571
            ],
            [
              116.81755828130315,
              -1.2375828021183395
            ],
            [
              116.81812783057933,
              -1.2360086414736031
            ],
            [
              116.81854744260562,
              -1.2348736419046702
            ],
            [
              116.81868723328097,
              -1.23438345968097
            ],
            [
              116.82007677918779,
              -1.2344524690934975
            ],
            [
              116.82237970373365,
              -1.2345989046826844
            ],
            [
              116.823837031734,
              -1.2347151453596297
            ],
            [
              116.8247482746599,
              -1.2348486616248522
            ],
            [
              116.82548395473657,
              -1.2354428935335733
            ],
            [
              116.8263220016513,
              -1.2363472666382904
            ],
            [
              116.82736759527216,
              -1.2374563389483768
            ],
            [
              116.82793276982841,
              -1.2380985942335343
            ],
            [
              116.8281246376045,
              -1.2406043551182648
            ],
            [
              116.82616147688486,
              -1.240604877985632
            ],
            [
              116.82432717778568,
              -1.2404954592413162
            ],
            [
              116.82353964394099,
              -1.2404144561198507
            ],
            [
              116.8226622784897,
              -1.2404383692451546
            ],
            [
              116.82265233098497,
              -1.240431056886834
            ]
          ],
          "type": "LineString"
        }
      }
    ]
  };

  // Tambahkan garis batas kelurahan ke peta
  L.geoJSON(kelurahanBoundary, {
    style: {
      color: '#CC710A',
      weight: 3,
      opacity: 0.8,
      dashArray: '10, 5',
      fillOpacity: 0
    },
    onEachFeature: function(feature, layer) {
      if (feature.properties && feature.properties.name) {
        layer.bindPopup(`
          <div style="text-align: center; padding: 5px;">
            <strong style="color: #CC710A; font-size: 14px;">${feature.properties.name}</strong>
          </div>
        `);
      }
    }
  }).addTo(map);

  if (lat && lng) {
    // Create Modern Location Pin marker with RT number (Compact Size)
    const markerHtml = `
      <div style="position: relative; width: 36px; height: 42px;">
        <svg width="36" height="42" viewBox="0 0 50 58">
          <defs>
            <linearGradient id="pin-grad-detail">
              <stop offset="0%" stop-color="${populationToColor(rtData.num_population)}" stop-opacity="1"/>
              <stop offset="100%" stop-color="${populationToColor(rtData.num_population)}" stop-opacity="0.8"/>
            </linearGradient>
            <filter id="shadow-detail">
              <feDropShadow dx="0" dy="3" stdDeviation="2" flood-opacity="0.4"/>
            </filter>
          </defs>
          <!-- Main Pin Shape -->
          <path d="M25 2 C 13 2, 4 11, 4 22 C 4 33, 25 54, 25 54 C 25 54, 46 33, 46 22 C 46 11, 37 2, 25 2 Z" 
                fill="url(#pin-grad-detail)" 
                stroke="white" 
                stroke-width="2.5"
                filter="url(#shadow-detail)"/>
          <!-- White Circle Inside -->
          <circle cx="25" cy="21" r="13" fill="white" opacity="0.98"/>
          <!-- RT Number Only (Big & Clear) -->
          <text x="25" y="26" 
                font-family="'Arial Black', 'Arial', 'Helvetica', sans-serif" 
                font-weight="900" 
                font-size="16" 
                fill="#000000" 
                text-anchor="middle"
                dominant-baseline="middle">${rtData.rt_code}</text>
        </svg>
      </div>
    `;

    const divIcon = L.divIcon({
      html: markerHtml,
      className: 'custom-marker',
      iconSize: [36, 42],
      iconAnchor: [18, 39]
    });

    const marker = L.marker([lat, lng], { icon: divIcon }).addTo(map);

    // Create popup content (COMPACT SIZE)
    let popupContent = `
      <div style="min-width: 160px; padding: 4px; color: #333;">
        <h6 class="fw-bold mb-2" style="color: #0d6efd; font-size: 0.9rem;">${rtData.name}</h6>
    `;

    // Tambahkan alamat jika ada
    if (rtData.address && rtData.address.trim() !== '') {
      popupContent += `
        <div class="mb-2" style="color: #333;">
          <i class="bi bi-house-door me-1" style="color: #28a745; font-size: 0.85rem;"></i>
          <span class="small" style="font-size: 0.8rem;">${rtData.address}</span>
        </div>
      `;
    }

    // Tambahkan link Google Maps
    const googleMapsUrl = `https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`;
    popupContent += `
        <hr class="my-2" style="border-color: #dee2e6; margin: 6px 0;">
        <a href="${googleMapsUrl}" target="_blank" class="btn btn-sm btn-primary w-100" style="background-color: #CC710A; border-color: #CC710A; color: #fff; text-decoration: none; padding: 6px 8px; font-size: 0.8rem;">
          <i class="bi bi-geo-alt-fill me-1"></i>Buka di Google Maps
        </a>
      </div>
    `;
    
    // Bind popup dengan offset agar muncul pas di atas marker (tidak menabrak logo)
    marker.bindPopup(popupContent, {
      offset: [0, -15], // Geser popup ke atas sedikit, pas di atas logo
      closeButton: true,
      autoClose: false,
      closeOnClick: false
    });
    
    // Auto open popup
    marker.openPopup();
  }
</script>
@endpush
