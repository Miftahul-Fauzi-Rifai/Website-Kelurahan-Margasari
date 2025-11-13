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
                  <button type="submit" class="btn" style="background-color: #CC710A; color: white;">
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
                          <strong class="rt-title" style="color: #CC710A;">RT {{ $rt->rt_code }}</strong>
                          @if($rt->ketua_rt_name)
                            <div class="small text-success rt-ketua">{{ Str::limit($rt->ketua_rt_name, 20) }}</div>
                          @endif
                        </div>
                        <div class="text-end">
                          <span class="badge rounded-pill rt-badge" style="background-color: #CC710A;">{{ $rt->num_population ?? 0 }}</span>
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
          
          <!-- Legend Populasi per RT - Horizontal Layout (Interactive) -->
          <div class="card border-0 shadow-sm mt-3">
            <div class="card-body p-3">
              <h6 class="mb-3 fw-bold text-center text-md-start" style="color: #333;">
                <i class="bi bi-funnel me-2"></i>Filter Populasi per RT
                <small class="text-muted ms-2" style="font-size: 0.75rem; font-weight: normal;">(Klik untuk filter)</small>
              </h6>
              <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start legend-horizontal">
                <div class="legend-item d-flex align-items-center" data-filter="300+" style="cursor: pointer;" title="Klik untuk filter RT ≥ 300 warga">
                  <div class="legend-color" style="background: #d73027;"></div>
                  <span class="legend-text">≥ 300</span>
                </div>
                <div class="legend-item d-flex align-items-center" data-filter="250-299" style="cursor: pointer;" title="Klik untuk filter RT 250-299 warga">
                  <div class="legend-color" style="background: #fc8d59;"></div>
                  <span class="legend-text">250-299</span>
                </div>
                <div class="legend-item d-flex align-items-center" data-filter="200-249" style="cursor: pointer;" title="Klik untuk filter RT 200-249 warga">
                  <div class="legend-color" style="background: #fee08b;"></div>
                  <span class="legend-text">200-249</span>
                </div>
                <div class="legend-item d-flex align-items-center" data-filter="150-199" style="cursor: pointer;" title="Klik untuk filter RT 150-199 warga">
                  <div class="legend-color" style="background: #91cf60;"></div>
                  <span class="legend-text">150-199</span>
                </div>
                <div class="legend-item d-flex align-items-center" data-filter="0-149" style="cursor: pointer;" title="Klik untuk filter RT < 150 warga">
                  <div class="legend-color" style="background: #4575b4;"></div>
                  <span class="legend-text">< 150</span>
                </div>
                <button class="btn btn-sm btn-outline-secondary ms-2" id="resetFilter" style="font-size: 0.75rem;">
                  <i class="bi bi-arrow-counterclockwise"></i> Reset
                </button>
              </div>
            </div>
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

  // Store all markers with their population data
  const allMarkers = [];

  points.forEach(p => {
    // Create Modern Location Pin marker with RT number (Compact Size)
    const markerHtml = `
      <div class="marker-container" style="position: relative; width: 36px; height: 42px; transition: opacity 0.3s ease;">
        <svg width="36" height="42" viewBox="0 0 50 58">
          <defs>
            <linearGradient id="pin-grad-${p.rt_code}">
              <stop offset="0%" stop-color="${populationToColor(p.num_population || 0)}" stop-opacity="1"/>
              <stop offset="100%" stop-color="${populationToColor(p.num_population || 0)}" stop-opacity="0.8"/>
            </linearGradient>
            <filter id="shadow-${p.rt_code}">
              <feDropShadow dx="0" dy="3" stdDeviation="2" flood-opacity="0.4"/>
            </filter>
          </defs>
          <!-- Main Pin Shape -->
          <path d="M25 2 C 13 2, 4 11, 4 22 C 4 33, 25 54, 25 54 C 25 54, 46 33, 46 22 C 46 11, 37 2, 25 2 Z" 
                fill="url(#pin-grad-${p.rt_code})" 
                stroke="white" 
                stroke-width="2.5"
                filter="url(#shadow-${p.rt_code})"/>
          <!-- White Circle Inside -->
          <circle cx="25" cy="21" r="13" fill="white" opacity="0.98"/>
          <!-- RT Number Only (Big & Clear) -->
          <text x="25" y="26" 
                font-family="'Arial Black', 'Arial', 'Helvetica', sans-serif" 
                font-weight="900" 
                font-size="16" 
                fill="#000000" 
                text-anchor="middle"
                dominant-baseline="middle">${p.rt_code}</text>
        </svg>
      </div>
    `;

    const customIcon = L.divIcon({
      html: markerHtml,
      className: 'custom-rt-marker',
      iconSize: [36, 42],
      iconAnchor: [18, 39],
      popupAnchor: [0, -39]
    });

    const marker = L.marker([p.lat, p.lng], { icon: customIcon }).addTo(map);
    
    // Store marker with population data
    allMarkers.push({
      marker: marker,
      population: p.num_population || 0,
      element: null
    });

    // Hover effect untuk Modern Pin
    marker.on('mouseover', function(e) {
      const markerElement = e.target.getElement();
      const svgElement = markerElement.querySelector('svg');
      if (svgElement) {
        svgElement.style.transform = 'scale(1.15)';
        svgElement.style.transition = 'transform 0.2s ease';
        svgElement.style.filter = 'drop-shadow(0 6px 12px rgba(0,0,0,0.5))';
      }
    });

    marker.on('mouseout', function(e) {
      const markerElement = e.target.getElement();
      const svgElement = markerElement.querySelector('svg');
      if (svgElement) {
        svgElement.style.transform = 'scale(1)';
        svgElement.style.filter = 'none';
      }
    });

    const popup = `
      <div style="min-width: 180px; padding: 6px;">
        <div class="mb-2 pb-1 border-bottom">
          <strong style="color: #CC710A; font-size: 0.95rem;">${p.name}</strong>
        </div>
        <div class="mb-2">
          <div class="d-flex align-items-start mb-1">
            <i class="bi bi-person-fill me-2" style="color: #CC710A; font-size: 0.85rem; margin-top: 2px;"></i>
            <div style="flex: 1;">
              <small class="text-muted d-block" style="font-size: 0.7rem;">Ketua RT</small>
              <strong style="font-size: 0.85rem;">${p.ketua_rt_name ?? 'Belum ada data'}</strong>
            </div>
          </div>
          <div class="d-flex align-items-start">
            <i class="bi bi-telephone-fill me-2" style="color: #28a745; font-size: 0.85rem; margin-top: 2px;"></i>
            <div style="flex: 1;">
              <small class="text-muted d-block" style="font-size: 0.7rem;">Telepon</small>
              <span style="font-size: 0.8rem;">${p.ketua_rt_phone ?? 'Belum ada data'}</span>
            </div>
          </div>
        </div>
        <div class="d-flex justify-content-around mb-2 py-1 border-top border-bottom" style="background-color: #fafafa;">
          <div class="text-center">
            <div class="fw-bold" style="color: #CC710A; font-size: 1.1rem;">${p.num_population || 0}</div>
            <small class="text-muted" style="font-size: 0.7rem;">Warga</small>
          </div>
          <div class="text-center">
            <div class="fw-bold text-success" style="font-size: 1.1rem;">${p.num_households || 0}</div>
            <small class="text-muted" style="font-size: 0.7rem;">KK</small>
          </div>
        </div>
        <div class="d-grid">
          <a class="btn btn-sm border" href="${`{{ url('/data-rt') }}/${p.rt_code}`}" style="background-color: #CC710A; color: white; border-color: #CC710A; font-weight: 500; padding: 6px; font-size: 0.8rem;">
            <i class="bi bi-eye me-1"></i> Lihat Detail
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

  // Wait for markers to be rendered, then get their DOM elements
  setTimeout(() => {
    allMarkers.forEach(markerData => {
      markerData.element = markerData.marker.getElement();
    });
  }, 100);

  // Filter functionality
  let activeFilter = null;

  function filterMarkersByPopulation(filterRange) {
    allMarkers.forEach(markerData => {
      if (!markerData.element) return;
      
      const pop = markerData.population;
      let shouldHighlight = false;
      
      if (filterRange === '300+' && pop >= 300) {
        shouldHighlight = true;
      } else if (filterRange === '250-299' && pop >= 250 && pop < 300) {
        shouldHighlight = true;
      } else if (filterRange === '200-249' && pop >= 200 && pop < 250) {
        shouldHighlight = true;
      } else if (filterRange === '150-199' && pop >= 150 && pop < 200) {
        shouldHighlight = true;
      } else if (filterRange === '0-149' && pop < 150) {
        shouldHighlight = true;
      }
      
      const container = markerData.element.querySelector('.marker-container');
      if (container) {
        if (shouldHighlight) {
          container.style.opacity = '1';
          container.style.filter = 'none';
          markerData.element.style.zIndex = '1000';
        } else {
          container.style.opacity = '0.2';
          container.style.filter = 'grayscale(100%)';
          markerData.element.style.zIndex = '1';
        }
      }
    });
  }

  function resetFilter() {
    allMarkers.forEach(markerData => {
      if (!markerData.element) return;
      const container = markerData.element.querySelector('.marker-container');
      if (container) {
        container.style.opacity = '1';
        container.style.filter = 'none';
        markerData.element.style.zIndex = 'auto';
      }
    });
    
    // Remove active class from all legend items
    document.querySelectorAll('.legend-item').forEach(item => {
      item.classList.remove('active');
    });
    
    activeFilter = null;
  }

  // Add click handlers to legend items
  document.querySelectorAll('.legend-item').forEach(item => {
    item.addEventListener('click', function() {
      const filter = this.getAttribute('data-filter');
      
      if (activeFilter === filter) {
        // Clicking same filter again = reset
        resetFilter();
      } else {
        // Apply new filter
        filterMarkersByPopulation(filter);
        activeFilter = filter;
        
        // Update active state
        document.querySelectorAll('.legend-item').forEach(i => i.classList.remove('active'));
        this.classList.add('active');
      }
    });
  });

  // Reset button handler
  document.getElementById('resetFilter').addEventListener('click', resetFilter);

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
    background-color: #CC710A !important;
    color: white !important;
    border-color: #CC710A !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  }

  /* Pagination Styling - Orange Theme */
  .pagination .page-item.active .page-link {
    background-color: #CC710A !important;
    border-color: #CC710A !important;
    color: white !important;
  }
  
  .pagination .page-link {
    color: #CC710A !important;
  }
  
  .pagination .page-link:hover {
    background-color: #CC710A !important;
    border-color: #CC710A !important;
    color: white !important;
  }
  
  .pagination .page-link:focus {
    box-shadow: 0 0 0 0.25rem rgba(204, 113, 10, 0.25) !important;
  }

  /* Legend Horizontal Styling */
  .legend-horizontal {
    gap: 1rem;
  }
  
  .legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
  }
  
  .legend-item:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  
  .legend-item.active {
    background-color: #e7f3ff;
    border-color: #0d6efd;
    box-shadow: 0 4px 12px rgba(13,110,253,0.2);
  }
  
  .legend-item.active .legend-text {
    color: #0d6efd;
    font-weight: 700;
  }
  
  .legend-color {
    width: 20px;
    height: 20px;
    border-radius: 4px;
    border: 1px solid rgba(0,0,0,0.1);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.2s ease;
  }
  
  .legend-item:hover .legend-color {
    transform: scale(1.15);
  }
  
  .legend-text {
    font-size: 0.875rem;
    font-weight: 500;
    color: #555;
    white-space: nowrap;
    transition: all 0.3s ease;
  }

  /* Custom RT Marker CSS - Modern Pin */
  .custom-rt-marker {
    background: transparent !important;
    border: none !important;
  }
  
  .custom-rt-marker svg {
    transition: all 0.2s ease-in-out;
    cursor: pointer;
  }
  
  .custom-rt-marker:hover svg {
    transform: scale(1.1);
  }
  
  /* SVG Text Rendering */
  .custom-rt-marker text {
    text-rendering: optimizeLegibility;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
  }
  
  /* Custom styles untuk form search */
  .input-group-text {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-right: none;
  }
  
  .form-control:focus {
    border-color: #CC710A;
    box-shadow: 0 0 0 0.25rem rgba(204, 113, 10, 0.25);
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
  
  /* Mobile RT Map Markers - Smaller Modern Pin */
  .custom-rt-marker div {
    width: 30px !important;
    height: 35px !important;
  }
  
  .custom-rt-marker svg {
    width: 30px !important;
    height: 35px !important;
  }
  
  /* Mobile legend adjustments */
  @media (max-width: 576px) {
    .legend-horizontal {
      gap: 0.5rem;
    }
    
    .legend-color {
      width: 16px;
      height: 16px;
    }
    
    .legend-text {
      font-size: 0.75rem;
    }
  }
}

/* Tablet and larger mobile screens */
@media (max-width: 767px) and (min-width: 577px) {
  .custom-rt-marker div {
    width: 33px !important;
    height: 38px !important;
  }
  
  .custom-rt-marker svg {
    width: 33px !important;
    height: 38px !important;
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


