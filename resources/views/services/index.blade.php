@extends('layouts.app')

@section('title', 'Semua Layanan Kami')

@section('content')
    <main>
        <section class="page-header text-center">
            <div class="container">
                <h1>Semua Layanan Kami</h1>
                <p>
                    Temukan solusi yang tepat untuk setiap masalah pada perangkat
                    elektronik kesayangan Anda.
                </p>
            </div>
        </section>

        <section class="filter-section py-4">
            <div class="container">
                <form action="{{ route('services.index_public') }}" method="GET">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="flex-grow-1">
                            <input type="search" name="search"
                                class="form-control form-control-lg rounded-pill search-input"
                                placeholder="Cari layanan... (misal: ganti baterai)" value="{{ request('search') }}" />
                        </div>
                        <div class="filter-buttons" role="group">
                            <a href="{{ route('services.index_public') }}"
                                class="btn btn-filter {{ !request('category') ? 'active' : '' }}">Semua</a>
                            <a href="{{ route('services.index_public', ['category' => 'Laptop']) }}"
                                class="btn btn-filter {{ request('category') == 'Laptop' ? 'active' : '' }}">Laptop</a>
                            <a href="{{ route('services.index_public', ['category' => 'Smartphone']) }}"
                                class="btn btn-filter {{ request('category') == 'Smartphone' ? 'active' : '' }}">Smartphone</a>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section class="services-list-section pt-4 pb-5">
            <div class="container">
                <div id="service-list-container">
                    @include('services._service_list')
                </div>
            </div>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            let searchTimeout;

            function fetchServices(page, search, category) {
                $.ajax({
                    url: "{{ route('services.index_public') }}?page=" + page,
                    data: {
                        search: search,
                        category: category
                    },
                    success: function(data) {
                        $('#service-list-container').html(data);
                    }
                });
            }

            $('.search-input').on('keyup', function() {
                clearTimeout(searchTimeout);
                let query = $(this).val();

                searchTimeout = setTimeout(function() {
                    fetchServices(1, query, '');
                }, 500);
            });

            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                let query = $('.search-input').val();
                let activeCategory = $('.filter-buttons .btn-filter.active').text().toLowerCase();
                if (activeCategory === 'semua') {
                    activeCategory = '';
                }

                fetchServices(page, query, activeCategory);
            });
        });
    </script>
@endpush
