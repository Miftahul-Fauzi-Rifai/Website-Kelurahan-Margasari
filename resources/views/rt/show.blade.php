@extends('layouts.app')

@section('title', 'Detail RT ' . $rt->rt_code . ' - Kelurahan Marga Sari')

@section('content')
<section class="bg-primary text-white py-5">
  <div class="container">
    <h1 class="display-6 fw-bold">Detail RT {{ $rt->rt_code }} / RW {{ $rt->rw_code }}</h1>
    <p class="mb-0">Informasi ketua RT, statistik penduduk, dan lokasi</p>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
          <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Ketua RT</h5>
          </div>
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-md-8">
                <h4 class="fw-bold mb-1">{{ $rt->ketua_rt_name ?? 'Belum diisi' }}</h4>
                <div class="text-muted mb-2">Ketua RT {{ $rt->rt_code }} / RW {{ $rt->rw_code }}</div>
                <div><i class="bi bi-telephone me-2"></i>{{ $rt->ketua_rt_phone ?? '-' }}</div>
              </div>
              <div class="col-md-4 text-md-end">
                <a href="tel:{{ $rt->ketua_rt_phone }}" class="btn btn-primary">
                  <i class="bi bi-telephone me-2"></i>Hubungi
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Lokasi RT</h5>
          </div>
          <div class="card-body p-0">
            <link rel="stylesheet" href="{{ asset('leaflet.css') }}">
            <div id="map" style="height: 420px;"></div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
          <div class="card-header bg-white">
            <h5 class="mb-0"><i class="bi bi-bar-chart-line me-2"></i>Statistik Warga</h5>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-6 mb-3">
                <div class="text-primary"><i class="bi bi-people" style="font-size: 2rem;"></i></div>
                <h4 class="fw-bold mb-0">{{ $rt->num_population }}</h4>
                <small class="text-muted">Total Warga</small>
              </div>
              <div class="col-6 mb-3">
                <div class="text-success"><i class="bi bi-house" style="font-size: 2rem;"></i></div>
                <h4 class="fw-bold mb-0">{{ $rt->num_households }}</h4>
                <small class="text-muted">KK</small>
              </div>
              <div class="col-6">
                <div class="text-info"><i class="bi bi-gender-male" style="font-size: 2rem;"></i></div>
                <h4 class="fw-bold mb-0">{{ $rt->num_male }}</h4>
                <small class="text-muted">Laki-laki</small>
              </div>
              <div class="col-6">
                <div class="text-danger"><i class="bi bi-gender-female" style="font-size: 2rem;"></i></div>
                <h4 class="fw-bold mb-0">{{ $rt->num_female }}</h4>
                <small class="text-muted">Perempuan</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="mt-4">
      <a href="{{ route('rt.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Data RT
      </a>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('leaflet.js') }}"></script>
<script>
  const lat = {{ $rt->latitude ?? 'null' }};
  const lng = {{ $rt->longitude ?? 'null' }};
  const rtData = {
    rt_code: '{{ $rt->rt_code }}',
    rw_code: '{{ $rt->rw_code }}',
    name: '{{ $rt->name }}',
    ketua_rt_name: '{{ $rt->ketua_rt_name }}',
    ketua_rt_phone: '{{ $rt->ketua_rt_phone }}',
    num_population: {{ $rt->num_population ?? 0 }},
    num_households: {{ $rt->num_households ?? 0 }}
  };

  const map = L.map('map').setView([lat ?? -1.2379, lng ?? 116.8289], lat && lng ? 16 : 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap contributors'
  }).addTo(map);

  // Function untuk warna berdasarkan populasi (sama dengan halaman index)
  const populationToColor = (pop) => {
    if (pop >= 300) return '#d73027';  // Merah - Populasi tinggi
    if (pop >= 250) return '#fc8d59';  // Oranye - Populasi sedang-tinggi
    if (pop >= 200) return '#fee08b';  // Kuning - Populasi sedang
    if (pop >= 150) return '#91cf60';  // Hijau muda - Populasi rendah-sedang
    return '#4575b4';                  // Biru - Populasi rendah
  };

  const getMarkerSize = (pop) => {
    if (pop >= 300) return 15;  // Lebih besar untuk detail view
    if (pop >= 250) return 13;
    if (pop >= 200) return 11;
    if (pop >= 150) return 10;
    return 9;
  };

  if (lat && lng) {
    // Create custom HTML marker dengan nomor RT (sama seperti halaman index)
    const markerHtml = `
      <div class="rt-marker" style="
        background-color: ${populationToColor(rtData.num_population)};
        border: 2px solid #fff;
        border-radius: 5px;
        width: 50px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Arial', 'Helvetica', sans-serif;
        font-weight: 900;
        font-size: 12px;
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
        ${rtData.rt_code}
        <div style="
          position: absolute;
          bottom: -7px;
          left: 50%;
          transform: translateX(-50%);
          width: 0;
          height: 0;
          border-left: 8px solid transparent;
          border-right: 8px solid transparent;
          border-top: 8px solid ${populationToColor(rtData.num_population)};
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

    const marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);

    // Popup dengan informasi lengkap
    const popup = `
      <div style="min-width: 220px;">
        <div class="mb-2">
          <strong class="text-primary">${rtData.name}</strong>
        </div>
        <div class="mb-2">
          <small class="text-muted d-block"><i class="bi bi-person-fill"></i> Ketua RT:</small>
          <strong>${rtData.ketua_rt_name || 'Belum ada data'}</strong>
        </div>
        <div class="mb-2">
          <small class="text-muted d-block"><i class="bi bi-telephone-fill"></i> Telepon:</small>
          <span>${rtData.ketua_rt_phone || 'Belum ada data'}</span>
        </div>
        <div class="row text-center mb-2">
          <div class="col-6">
            <div class="border-end">
              <div class="h6 mb-0 text-primary">${rtData.num_population}</div>
              <small class="text-muted">Warga</small>
            </div>
          </div>
          <div class="col-6">
            <div class="h6 mb-0 text-success">${rtData.num_households}</div>
            <small class="text-muted">KK</small>
          </div>
        </div>
      </div>
    `;
    marker.bindPopup(popup);

    // Hover effect untuk custom marker (sama seperti halaman index)
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

    // Auto open popup untuk RT yang sedang dilihat
    marker.openPopup();
  } else {
    // Jika tidak ada koordinat, tampilkan pesan
    L.popup()
      .setLatLng([-1.2379, 116.8289])
      .setContent('<div class="text-center"><i class="bi bi-exclamation-triangle text-warning"></i><br><strong>Koordinat RT belum tersedia</strong><br><small>Silakan hubungi admin untuk menambahkan lokasi RT ini</small></div>')
      .openOn(map);
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

  /* Style untuk peta detail RT */
  #map {
    border-radius: 0;
  }

  /* Responsive map untuk mobile */
  @media (max-width: 768px) {
    #map {
      height: 300px !important;
    }
  }

  /* Animasi untuk marker */
  .leaflet-marker-icon, .leaflet-div-icon {
    transition: all 0.3s ease;
  }

  /* Card hover effects */
  .card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  }

  .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
  }

  /* Stats cards styling */
  .card-body .text-primary,
  .card-body .text-success,
  .card-body .text-info,
  .card-body .text-danger {
    transition: transform 0.2s ease;
  }

  .card-body .text-primary:hover,
  .card-body .text-success:hover,
  .card-body .text-info:hover,
  .card-body .text-danger:hover {
    transform: scale(1.1);
  }

  /* Custom RT Marker CSS - sama dengan halaman index */
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
</style>
@endpush

