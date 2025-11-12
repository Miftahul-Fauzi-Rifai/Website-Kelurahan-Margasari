@extends('layouts.app')

@section('title', 'Data RT - Kelurahan Marga Sari')
@section('meta_description', 'Peta persebaran RT dan statistik per RT di Kelurahan Marga Sari, Kota Balikpapan.')

@section('content')
<section id="rt-hero" class="rt-hero-section text-white py-4 py-md-5 page-header-rt">
    <div class="container position-relative">
        <h1 class="display-5 display-md-4 fw-bold mobile-title">Data RT Kelurahan Marga Sari</h1>
        <p class="lead mb-0 mobile-subtitle">Persebaran lokasi RT dan statistik singkat</p>
    </div>
</section>

  <section class="py-5">
    <div class="container">
      <!-- Search Form -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <form method="GET" action="{{ route('rt.index') }}" class="mobile-search-form">
                <div class="d-flex gap-2">
                  <div class="flex-grow-1">
                    <div class="input-group">
                      <span class="input-group-text bg-light border-end-0">
                        <i class="bi bi-search"></i>
                      </span>
                      <input 
                        type="text" 
                        class="form-control border-start-0" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Cari RT (contoh: RT 01)" 
                        style="border-left: none !important; box-shadow: none;"
                      >
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i><span class="d-none d-md-inline ms-1">Cari</span>
                  </button>
                  @if($search)
                    <a href="{{ route('rt.index') }}" class="btn btn-outline-secondary">
                      <i class="bi bi-x-circle"></i><span class="d-none d-md-inline ms-1">Reset</span>
                    </a>
                  @endif
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile First: List RT di atas, Map di bawah -->
      <div class="row g-4">
        <!-- Daftar RT - Prioritas utama di mobile -->
        <div class="col-12 col-lg-4 order-1 order-lg-2">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
              <h5 class="mb-0"><i class="bi bi-list-ol me-2"></i>Daftar RT</h5>
              <span class="badge bg-secondary">{{ $rts->total() }} RT</span>
            </div>
            <div class="card-body p-0 mobile-rt-list" style="max-height: 350px; overflow-y: auto;">
              @if($rts->count() > 0)
                <div class="list-group list-group-flush">
                  @foreach($rts as $rt)
                  <a href="{{ route('rt.show', $rt->rt_code) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-start-0 border-end-0 rt-list-item">
                    <div class="flex-grow-1">
                      <div class="d-flex justify-content-between align-items-start">
                        <div>
                          <strong class="text-primary rt-title">RT {{ $rt->rt_code }}</strong>
                          @if($rt->ketua_rt_name)
                            <div class="small text-success rt-ketua">{{ Str::limit($rt->ketua_rt_name, 20) }}</div>
                          @endif
                        </div>
                        <div class="text-end">
                          <span class="badge bg-primary rounded-pill rt-badge">{{ $rt->num_population ?? 0 }}</span>
                          <div class="small text-muted d-none d-sm-block">warga</div>
                        </div>
                      </div>
                    </div>
                  </a>
                  @endforeach
                </div>
              @else
                <div class="text-center py-4 text-muted">
                  <i class="bi bi-search display-6 mb-3"></i>
                  <p class="mb-0">Tidak ada RT yang ditemukan</p>
                  @if($search)
                    <p class="small">untuk pencarian "{{ $search }}"</p>
                  @endif
                </div>
              @endif
            </div>
            @if($rts->hasPages())
              <div class="card-footer bg-white">
                <div class="d-flex justify-content-center">
                  {{ $rts->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
              </div>
            @endif
          </div>
        </div>

        <!-- Map - Di bawah untuk mobile, di samping untuk desktop -->
        <div class="col-12 col-lg-8 order-2 order-lg-1">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Peta Persebaran RT</h5>
              <small class="text-muted">{{ $mapPoints->count() }} RT ditampilkan di peta</small>
            </div>
            <div class="card-body p-0">
              <link rel="stylesheet" href="{{ asset('leaflet.css') }}">
              <div id="map" class="mobile-map"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('scripts')
<script src="{{ asset('leaflet.js') }}"></script>
<script>
  const points = @json($mapPoints);
  const center = points.length ? [points[0].lat, points[0].lng] : [-1.2379, 116.8289];
  const map = L.map('map').setView(center, 13);
  
  // Google Maps Hybrid (Satelit + Label jalan & bangunan)
  L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
    maxZoom: 20,
    attribution: '&copy; Google Maps'
  }).addTo(map);

  const populationToColor = (pop) => {
    if (pop >= 300) return '#d73027';  // Merah - Populasi tinggi
    if (pop >= 250) return '#fc8d59';  // Oranye - Populasi sedang-tinggi
    if (pop >= 200) return '#fee08b';  // Kuning - Populasi sedang
    if (pop >= 150) return '#91cf60';  // Hijau muda - Populasi rendah-sedang
    return '#4575b4';                  // Biru - Populasi rendah
  };

  const getMarkerSize = (pop) => {
    if (pop >= 300) return 12;
    if (pop >= 250) return 10;
    if (pop >= 200) return 8;
    if (pop >= 150) return 7;
    return 6;
  };

  points.forEach(p => {
    // Create custom HTML marker with RT number
    const markerHtml = `
      <div class="rt-marker" style="
        background-color: ${populationToColor(p.num_population || 0)};
        border: 2px solid #fff;
        border-radius: 5px;
        width: 50px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Arial', 'Helvetica', sans-serif;
        font-weight: 900;
        font-size: 11px;
        color: black;
        text-shadow: 
          -1px -1px 0 #fff,
          1px -1px 0 #fff,
          -1px 1px 0 #fff,
          1px 1px 0 #fff,
          0 0 1px #fff;
        box-shadow: 0 3px 6px rgba(0,0,0,0.4);
        position: relative;
        line-height: 1;
        letter-spacing: 0.5px;
        text-align: center;
      ">
        RT ${p.rt_code}
        <div style="
          position: absolute;
          bottom: -7px;
          left: 50%;
          transform: translateX(-50%);
          width: 0;
          height: 0;
          border-left: 8px solid transparent;
          border-right: 8px solid transparent;
          border-top: 8px solid ${populationToColor(p.num_population || 0)};
        "></div>
      </div>
    `;

    const customIcon = L.divIcon({
      html: markerHtml,
      className: 'custom-rt-marker',
      iconSize: [50, 42],
      iconAnchor: [25, 42],
      popupAnchor: [0, -42]
    });

    const marker = L.marker([p.lat, p.lng], { icon: customIcon }).addTo(map);

    // Hover effect dengan jQuery
    marker.on('mouseover', function(e) {
      const markerElement = e.target.getElement();
      const rtMarker = markerElement.querySelector('.rt-marker');
      if (rtMarker) {
        rtMarker.style.transform = 'scale(1.1)';
        rtMarker.style.zIndex = '1000';
        rtMarker.style.boxShadow = '0 4px 8px rgba(0,0,0,0.5)';
      }
    });

    marker.on('mouseout', function(e) {
      const markerElement = e.target.getElement();
      const rtMarker = markerElement.querySelector('.rt-marker');
      if (rtMarker) {
        rtMarker.style.transform = 'scale(1)';
        rtMarker.style.zIndex = 'auto';
        rtMarker.style.boxShadow = '0 3px 6px rgba(0,0,0,0.4)';
      }
    });

    const popup = `
      <div style="min-width: 200px;">
        <div class="mb-2">
          <strong class="text-primary">${p.name}</strong>
        </div>
        <div class="mb-2">
          <small class="text-muted d-block"><i class="bi bi-person-fill"></i> Ketua RT:</small>
          <strong>${p.ketua_rt_name ?? 'Belum ada data'}</strong>
        </div>
        <div class="mb-2">
          <small class="text-muted d-block"><i class="bi bi-telephone-fill"></i> Telepon:</small>
          <span>${p.ketua_rt_phone ?? 'Belum ada data'}</span>
        </div>
        <div class="row text-center mb-2">
          <div class="col-6">
            <div class="border-end">
              <div class="h6 mb-0 text-primary">${p.num_population || 0}</div>
              <small class="text-muted">Warga</small>
            </div>
          </div>
          <div class="col-6">
            <div class="h6 mb-0 text-success">${p.num_households || 0}</div>
            <small class="text-muted">KK</small>
          </div>
        </div>
        <div class="d-grid">
          <a class="btn btn-sm btn-light border" href="${`{{ url('/data-rt') }}/${p.rt_code}`}" style="background-color: white; color: #0d6efd; border-color: #0d6efd; font-weight: 500;">
            <i class="bi bi-eye"></i> Lihat Detail
          </a>
        </div>
      </div>
    `;
    marker.bindPopup(popup);
  });

  if (points.length > 1) {
    const group = L.featureGroup(points.map(p => L.marker([p.lat, p.lng])));
    map.fitBounds(group.getBounds().pad(0.2));
  }

  // Add legend  
  const legend = L.control({position: 'bottomright'});
  legend.onAdd = function(map) {
    const div = L.DomUtil.create('div', 'info legend');
    div.innerHTML = `
      <div style="background: white; padding: 12px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2); font-size: 12px; line-height: 22px;">
        <div style="font-weight: bold; margin-bottom: 6px; color: #333;">Populasi per RT</div>
        <div style="display: flex; align-items: center; margin-bottom: 4px;">
          <div style="background: #d73027; width: 18px; height: 18px; border-radius: 3px; margin-right: 8px; border: 1px solid #ccc;"></div>
          ≥ 300 warga
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 4px;">
          <div style="background: #fc8d59; width: 18px; height: 18px; border-radius: 3px; margin-right: 8px; border: 1px solid #ccc;"></div>
          250-299 warga
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 4px;">
          <div style="background: #fee08b; width: 18px; height: 18px; border-radius: 3px; margin-right: 8px; border: 1px solid #ccc;"></div>
          200-249 warga
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 4px;">
          <div style="background: #91cf60; width: 18px; height: 18px; border-radius: 3px; margin-right: 8px; border: 1px solid #ccc;"></div>
          150-199 warga
        </div>
        <div style="display: flex; align-items: center;">
          <div style="background: #4575b4; width: 18px; height: 18px; border-radius: 3px; margin-right: 8px; border: 1px solid #ccc;"></div>
          < 150 warga
        </div>
      </div>
    `;
    return div;
  };
  legend.addTo(map);

  // Mobile responsive map handler
  function handleMapResize() {
    setTimeout(() => {
      map.invalidateSize();
    }, 250);
  }

  // Listen for orientation changes and window resize
  window.addEventListener('orientationchange', handleMapResize);
  window.addEventListener('resize', handleMapResize);

  // Initial resize check for mobile
  if (window.innerWidth <= 991) {
    handleMapResize();
  }
</script>
@endpush

@push('styles')
<style>
  #map .leaflet-popup-content-wrapper {
    border-radius: .5rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
  }
  
  #map .leaflet-popup-content {
    margin: 0;
    font-family: inherit;
  }
  
  #map .leaflet-popup-close-button {
    color: #6c757d;
    font-size: 18px;
    font-weight: bold;
  }
  
  #map .leaflet-popup-close-button:hover {
    color: #495057;
  }
  
  /* Styling untuk tombol di popup peta */
  #map .leaflet-popup-content .btn {
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }

  #map .leaflet-popup-content .btn:hover {
    background-color: #0d6efd !important;
    color: white !important;
    border-color: #0d6efd !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  }

  /* Legend styling */
  .legend {
    line-height: 18px;
    color: #555;
  }
  
  .legend i {
    width: 18px;
    height: 18px;
    float: left;
    margin-right: 8px;
    opacity: 0.7;
  }

  /* Custom RT Marker CSS */
  .custom-rt-marker {
    background: transparent !important;
    border: none !important;
  }
  
  .rt-marker {
    transition: all 0.2s ease-in-out;
    cursor: pointer;
    font-family: 'Arial', 'Helvetica', sans-serif !important;
    font-weight: 900 !important;
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }
  
  .rt-marker:hover {
    transform: scale(1.1) !important;
  }
  
  /* Custom styles untuk form search */
  .input-group-text {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-right: none;
  }
  
  .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
  }
  
  /* Custom scrollbar untuk daftar RT */
  .card-body::-webkit-scrollbar {
    width: 8px;
  }
  
  .card-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
  }
  
  .card-body::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
  }
  
  .card-body::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
  }
  
  /* Hover effect untuk list items */
  .list-group-item:hover {
    background-color: #f8f9fa !important;
    transform: translateY(-1px);
    transition: all 0.2s ease;
  }
  
  /* Animation untuk search form */
  .card {
    transition: all 0.3s ease;
  }
  
  .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
  }
  
  /* Mobile-First Responsive Design */
  
  /* Mobile Search Form Optimizations */
  .mobile-search-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }
  
  @media (min-width: 768px) {
    .mobile-search-form {
      flex-direction: row;
      align-items: center;
      gap: 1.5rem;
    }
  }
  
  /* Mobile Map Adjustments */
  .mobile-map {
    height: 280px;
    border-radius: 0;
  }
  
  @media (min-width: 576px) {
    .mobile-map {
      height: 350px;
    }
  }
  
  @media (min-width: 992px) {
    .mobile-map {
      height: 520px;
    }
  }
  
  /* Mobile List Optimizations */
  .mobile-rt-list {
    max-height: 350px;
  }
  
  @media (min-width: 576px) {
    .mobile-rt-list {
      max-height: 400px;
    }
  }
  
  @media (min-width: 992px) {
    .mobile-rt-list {
      max-height: 500px;
    }
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
  }
  
  /* Mobile Typography & Spacing */
  @media (max-width: 575px) {
    .card-body {
      padding: 1rem !important;
    }
    
    .card-header {
      padding: 0.75rem 1rem !important;
    }
    
    .card-header h5 {
      font-size: 1rem;
      margin-bottom: 0;
    }
    
    .list-group-item {
      padding: 0.75rem 1rem;
    }
    
    .btn {
      padding: 0.5rem 1rem;
      font-size: 0.9rem;
    }
    
    /* Hide text labels on very small screens */
    .btn .d-none {
      display: none !important;
    }
    
    /* Stack pagination on mobile */
    .pagination {
      flex-wrap: wrap;
      justify-content: center;
    }
    
    .page-link {
      padding: 0.375rem 0.75rem;
      font-size: 0.875rem;
    }
  }
  
  /* Tablet Portrait */
  @media (min-width: 576px) and (max-width: 767px) {
    .mobile-map {
      border-radius: 0.375rem;
    }
    
    .card {
      margin-bottom: 1rem;
    }
  }
  
  /* Touch-friendly improvements */
  @media (max-width: 991px) {
    .list-group-item {
      min-height: 60px;
      display: flex;
      align-items: center;
    }
    
    .card:hover {
      transform: none; /* Disable hover animations on mobile */
    }
    
    .list-group-item:hover {
      transform: none;
    }
    
    /* Larger touch targets */
    .btn {
      min-height: 44px;
    }
  }
  
  /* Scrollbar improvements for mobile */
  @media (max-width: 991px) {
    .mobile-rt-list::-webkit-scrollbar {
      width: 4px;
    }
    
    .mobile-rt-list::-webkit-scrollbar-thumb {
      background: #dee2e6;
      border-radius: 2px;
    }
  }

/* Mobile RT List Optimizations */
.rt-list-item {
  padding: 0.6rem 1rem !important;
  transition: background-color 0.2s ease;
}

.rt-list-item:hover {
  background-color: #f8f9fa !important;
}

.rt-title {
  font-size: 0.95rem;
  font-weight: 600;
}

.rt-ketua {
  font-size: 0.8rem;
  margin-top: 0.1rem;
}

.rt-badge {
  font-size: 0.75rem;
  padding: 0.3rem 0.6rem;
}

/* Mobile specific optimizations */
@media (max-width: 767px) {
  .mobile-rt-list {
    max-height: 300px !important;
  }
  
  .rt-list-item {
    padding: 0.5rem 0.8rem !important;
    min-height: 45px !important;
  }
  
  .rt-title {
    font-size: 0.9rem;
    line-height: 1.2;
  }
  
  .rt-ketua {
    font-size: 0.75rem;
    margin-top: 0.05rem;
    line-height: 1.1;
  }
  
  .rt-badge {
    font-size: 0.65rem;
    padding: 0.2rem 0.4rem;
    min-width: 35px;
    text-align: center;
  }
  
  /* Compact header */
  .card-header h5 {
    font-size: 1rem;
  }
  
  .badge {
    font-size: 0.65rem;
    padding: 0.25rem 0.5rem;
  }
}

/* Extra small screens */
@media (max-width: 576px) {
  .mobile-rt-list {
    max-height: 280px !important;
  }
  
  .rt-list-item {
    padding: 0.4rem 0.7rem !important;
    min-height: 40px !important;
  }
  
  .rt-title {
    font-size: 0.85rem;
  }
  
  .rt-ketua {
    font-size: 0.7rem;
  }
  
  .rt-badge {
    font-size: 0.6rem;
    padding: 0.15rem 0.3rem;
    min-width: 30px;
  }
  
  /* Mobile RT Map Markers - Smaller size */
  .rt-marker {
    width: 40px !important;
    height: 28px !important;
    font-size: 9px !important;
    letter-spacing: 0.3px !important;
  }
  
  /* Smaller legend on mobile */
  .legend {
    font-size: 10px !important;
  }
  
  .legend > div {
    padding: 8px !important;
  }
  
  .legend div[style*="width: 18px"] {
    width: 14px !important;
    height: 14px !important;
  }
}

/* Tablet and larger mobile screens */
@media (max-width: 767px) and (min-width: 577px) {
  .rt-marker {
    width: 45px !important;
    height: 32px !important;
    font-size: 10px !important;
  }
}

/* Page Header Spacing untuk menghindari navbar */
.page-header-rt {
  padding-top: 90px !important; /* Reasonable space from fixed navbar */
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .page-header-rt {
    padding-top: 80px !important; /* Less padding on mobile since navbar auto-hides */
  }
}

@media (max-width: 576px) {
  .page-header-rt {
    padding-top: 70px !important; /* Minimal padding on small mobile */
  }
}

/* ==== RT HERO SECTION - BACKGROUND ORANGE ==== */
.rt-hero-section {
    position: relative;
    overflow: hidden;
    color: white;
    background: linear-gradient(135deg, #CC710A 0%, #A35808 100%);
}

.rt-hero-section .container {
    position: relative;
    z-index: 2;
}
</style>
@endpush

@push('scripts')
@endpush

