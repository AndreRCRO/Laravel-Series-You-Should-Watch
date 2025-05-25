<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Series que Debes Ver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #1a1a1a;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: 600;
            color: #fff !important;
        }
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        .card-img-top {
            height: 300px;
            object-fit: cover;
        }
        .card-body {
            padding: 1.5rem;
        }
        .card-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .rating {
            color: #ffc107;
            margin-bottom: 1rem;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .genre-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
        .search-box {
            max-width: 500px;
            margin: 0 auto;
        }
        .search-box input {
            border-radius: 25px;
            padding: 0.75rem 1.5rem;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .filter-section {
            background: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .genre-filter {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 1rem;
        }
        .genre-filter .genre-badge {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .genre-filter .genre-badge.active {
            background-color: #007bff;
            color: white;
        }
        .sort-options {
            display: flex;
            gap: 10px;
            margin-bottom: 1rem;
        }
        .sort-options button {
            border: none;
            background: #e9ecef;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .sort-options button.active {
            background: #007bff;
            color: white;
        }
        .series-count {
            color: #6c757d;
            margin-bottom: 1rem;
        }
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #007bff;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1000;
        }
        .back-to-top.visible {
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('series.index') }}">
                <i class="fas fa-tv me-2"></i>Series que Debes Ver
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Filtros -->
        <div class="filter-section">
            <div class="search-box mb-4">
                <input type="text" class="form-control" id="searchInput" placeholder="Buscar series...">
            </div>
            
            <div class="genre-filter">
                @php
                    $allGenres = collect($series)->flatMap(function($item) {
                        return explode(', ', $item['genre']);
                    })->unique()->sort()->values();
                @endphp
                @foreach($allGenres as $genre)
                    <span class="genre-badge" data-genre="{{ $genre }}">{{ $genre }}</span>
                @endforeach
            </div>

            <div class="row align-items-center mt-3">
                <div class="col-md-4">
                    <select class="form-select" id="yearFilter">
                        <option value="">Todos los años</option>
                        @php
                            $years = collect($series)->pluck('release_year')->unique()->sort()->reverse();
                        @endphp
                        @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="ratingFilter">
                        <option value="">Todas las calificaciones</option>
                        <option value="9">9+</option>
                        <option value="8">8+</option>
                        <option value="7">7+</option>
                        <option value="6">6+</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="sort-options">
                        <button class="active" data-sort="rating">Mejor Calificación</button>
                        <button data-sort="year">Más Recientes</button>
                        <button data-sort="title">A-Z</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="series-count">
            Mostrando <span id="seriesCount">{{ count($series) }}</span> series
        </div>

        <!-- Series Grid -->
        <div class="row" id="seriesGrid">
            @foreach ($series as $item)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4 series-item" 
                     data-title="{{ strtolower($item['title']) }}"
                     data-year="{{ $item['release_year'] }}"
                     data-rating="{{ $item['rating'] }}"
                     data-genres="{{ strtolower($item['genre']) }}">
                    <div class="card h-100">
                        <img src="{{ $item['image_url'] }}" class="card-img-top" alt="{{ $item['title'] }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $item['title'] }}</h5>
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <span>{{ $item['rating'] }}</span>
                            </div>
                            <div class="mb-3">
                                @foreach(explode(', ', $item['genre']) as $genre)
                                    <span class="genre-badge">{{ $genre }}</span>
                                @endforeach
                            </div>
                            <a href="{{ route('series.show', ['id' => $item['id']]) }}" class="btn btn-primary mt-auto">
                                <i class="fas fa-info-circle me-1"></i>Ver Detalle
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Back to Top Button -->
    <div class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Funcionalidad de búsqueda y filtros
        const searchInput = document.getElementById('searchInput');
        const yearFilter = document.getElementById('yearFilter');
        const ratingFilter = document.getElementById('ratingFilter');
        const genreBadges = document.querySelectorAll('.genre-filter .genre-badge');
        const sortButtons = document.querySelectorAll('.sort-options button');
        const seriesGrid = document.getElementById('seriesGrid');
        const seriesItems = document.querySelectorAll('.series-item');
        const seriesCount = document.getElementById('seriesCount');
        const backToTop = document.querySelector('.back-to-top');

        // Conjunto para almacenar los géneros activos
        let activeGenres = new Set();
        // Ordenamiento actual (por defecto por calificación)
        let currentSort = 'rating';

        /**
         * Filtra las series según los criterios seleccionados:
         * - Término de búsqueda
         * - Año
         * - Calificación mínima
         * - Géneros seleccionados
         */
        function filterSeries() {
            const searchTerm = searchInput.value.toLowerCase();
            const year = yearFilter.value;
            const rating = ratingFilter.value;
            
            let visibleCount = 0;

            seriesItems.forEach(item => {
                const title = item.dataset.title;
                const itemYear = item.dataset.year;
                const itemRating = parseFloat(item.dataset.rating);
                const genres = item.dataset.genres.split(', ');

                // Verifica si la serie cumple con todos los criterios de filtrado
                const matchesSearch = title.includes(searchTerm);
                const matchesYear = !year || itemYear === year;
                const matchesRating = !rating || itemRating >= parseFloat(rating);
                const matchesGenre = activeGenres.size === 0 || 
                    genres.some(genre => activeGenres.has(genre.toLowerCase()));

                // Muestra u oculta la serie según los criterios
                if (matchesSearch && matchesYear && matchesRating && matchesGenre) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });

            seriesCount.textContent = visibleCount;
        }

        function sortSeries() {
            const items = Array.from(seriesItems);
            items.sort((a, b) => {
                switch(currentSort) {
                    case 'rating':
                        return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
                    case 'year':
                        return parseInt(b.dataset.year) - parseInt(a.dataset.year);
                    case 'title':
                        return a.dataset.title.localeCompare(b.dataset.title);
                    default:
                        return 0;
                }
            });

            items.forEach(item => seriesGrid.appendChild(item));
        }

        // Listeners
        searchInput.addEventListener('input', filterSeries);
        yearFilter.addEventListener('change', filterSeries);
        ratingFilter.addEventListener('change', filterSeries);

        genreBadges.forEach(badge => {
            badge.addEventListener('click', () => {
                const genre = badge.dataset.genre.toLowerCase();
                if (activeGenres.has(genre)) {
                    activeGenres.delete(genre);
                    badge.classList.remove('active');
                } else {
                    activeGenres.add(genre);
                    badge.classList.add('active');
                }
                filterSeries();
            });
        });

        sortButtons.forEach(button => {
            button.addEventListener('click', () => {
                sortButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                currentSort = button.dataset.sort;
                sortSeries();
            });
        });

        // Volver al inicio
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Inicializar ordenamiento
        sortSeries();
    </script>
</body>
</html> 