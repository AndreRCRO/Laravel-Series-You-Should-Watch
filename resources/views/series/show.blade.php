<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $series['title'] }} - Series que Debes Ver</title>
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
        .series-header {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('{{ $series['image_url'] }}');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            margin-bottom: 40px;
        }
        .series-image {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .series-image:hover {
            transform: scale(1.02);
        }
        .series-info {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .series-title {
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .series-meta {
            color: #6c757d;
            margin-bottom: 1.5rem;
        }
        .series-description {
            line-height: 1.8;
            margin-bottom: 2rem;
        }
        .genre-badge {
            background-color: #e9ecef;
            color: #495057;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.9rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
        .rating {
            color: #ffc107;
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #5a6268;
            color: white;
            transform: scale(1.05);
        }
        .info-item {
            margin-bottom: 1rem;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        .info-value {
            color: #6c757d;
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

    <!-- Series Header -->
    <section class="series-header">
        <div class="container">
            <h1 class="display-4 mb-3">{{ $series['title'] }}</h1>
            <div class="rating">
                <i class="fas fa-star"></i>
                <span>{{ $series['rating'] }}</span>
            </div>
            <div class="series-meta">
                <span class="me-3"><i class="fas fa-calendar me-1"></i>{{ $series['release_year'] }}</span>
                <span><i class="fas fa-film me-1"></i>{{ $series['seasons'] }} Temporadas</span>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <img src="{{ $series['image_url'] }}" class="img-fluid series-image" alt="{{ $series['title'] }}">
            </div>
            <div class="col-md-8">
                <div class="series-info">
                    <h2 class="series-title">{{ $series['title'] }}</h2>
                    <div class="series-description">
                        {{ $series['description'] }}
                    </div>
                    <div class="mb-4">
                        @foreach(explode(', ', $series['genre']) as $genre)
                            <span class="genre-badge">{{ $genre }}</span>
                        @endforeach
                    </div>
                    <div class="info-item">
                        <span class="info-label">Año de Lanzamiento:</span>
                        <span class="info-value">{{ $series['release_year'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Temporadas:</span>
                        <span class="info-value">{{ $series['seasons'] }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Calificación:</span>
                        <span class="info-value">
                            <i class="fas fa-star text-warning"></i>
                            {{ $series['rating'] }}
                        </span>
                    </div>
                    <a href="{{ route('series.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-1"></i>Volver a la lista
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 