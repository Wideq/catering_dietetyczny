@extends('layout')

@section('title', 'PureMeal - Miasta dostawy')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">Miasta dostawy PureMeal</h1>
    
    <div class="delivery-intro text-center mb-5">
        <p class="lead">Aktualnie dostarczamy świeże posiłki dietetyczne w głównych miastach Polski i ich okolicach (do 30 km). Stale poszerzamy naszą sieć logistyczną, aby nasze zdrowe posiłki docierały do coraz większej liczby osób.</p>
    </div>
    
    <div class="cities-grid row g-4">
        @foreach ([ 
            ['name' => 'Warszawa', 'info' => 'Stolica i największy obszar dostawy. Dostarczamy codziennie do wszystkich dzielnic i okolicznych miejscowości.'],
            ['name' => 'Kraków', 'info' => 'Dostawy realizowane codziennie w całym mieście oraz okolicach, w tym Wieliczka i Niepołomice.'],
            ['name' => 'Wrocław', 'info' => 'Pełne pokrycie miasta i okolicznych miejscowości w promieniu 30 km.'],
            ['name' => 'Poznań', 'info' => 'Dostarczamy do wszystkich dzielnic Poznania oraz okolicznych miejscowości.'],
            ['name' => 'Gdańsk', 'info' => 'Obsługujemy cały Trójmiasto (Gdańsk, Gdynia, Sopot) i okolice.'],
            ['name' => 'Szczecin', 'info' => 'Regularne dostawy w całym mieście i okolicach, włączając Stargard i Police.'],
            ['name' => 'Łódź', 'info' => 'Dostawy we wszystkich dzielnicach Łodzi i pobliskich miejscowościach.'],
            ['name' => 'Lublin', 'info' => 'Pełne pokrycie miasta i okolicznych miejscowości.'],
            ['name' => 'Białystok', 'info' => 'Dostawy realizowane codziennie w całym mieście i okolicach.'],
            ['name' => 'Rzeszów', 'info' => 'Obsługujemy całe miasto i miejscowości w promieniu 30 km.'],
            ['name' => 'Katowice', 'info' => 'Dostawy w całym regionie śląskim, włączając Gliwice, Zabrze i Chorzów.'],
            ['name' => 'Bydgoszcz', 'info' => 'Dostarczamy do całego miasta oraz okolicznych miejscowości.']
        ] as $city)
        <div class="col-md-4 col-lg-3">
            <div class="city-card shadow-sm p-4 text-center rounded d-flex flex-column">
                <div class="city-icon mb-3">
                    <i class="fas fa-city fa-3x text-dark"></i>
                </div>
                <h5 class="city-name fw-bold">{{ $city['name'] }}</h5>
                <p class="city-info text-muted flex-grow-1">{{ $city['info'] }}</p>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="delivery-details mt-5 p-4 rounded shadow-sm bg-light">
        <h2 class="text-center mb-4">Jak działa nasza dostawa?</h2>
        <ul class="list-unstyled">
            <li class="d-flex align-items-start mb-3">
                <i class="fas fa-check-circle text-success me-3 fa-lg"></i>
                <span>Dostawy realizowane są codziennie w godzinach 5:00-9:00</span>
            </li>
            <li class="d-flex align-items-start mb-3">
                <i class="fas fa-check-circle text-success me-3 fa-lg"></i>
                <span>Posiłki dostarczane są w specjalnych torbach termicznych</span>
            </li>
            <li class="d-flex align-items-start mb-3">
                <i class="fas fa-check-circle text-success me-3 fa-lg"></i>
                <span>Pakujemy w biodegradowalne opakowania</span>
            </li>
            <li class="d-flex align-items-start mb-3">
                <i class="fas fa-check-circle text-success me-3 fa-lg"></i>
                <span>Dostawy na sobotę, niedzielę i poniedziałek realizowane są w sobotę rano</span>
            </li>
            <li class="d-flex align-items-start mb-3">
                <i class="fas fa-check-circle text-success me-3 fa-lg"></i>
                <span>Możliwość pozostawienia paczki w wyznaczonym miejscu (np. pod drzwiami)</span>
            </li>
        </ul>
        
        <div class="delivery-note mt-4 p-3 bg-warning bg-opacity-25 border-start border-warning">
            <p class="mb-0"><strong>Uwaga:</strong> Stale poszerzamy obszar naszych dostaw. Jeśli Twojej miejscowości nie ma na liście, skontaktuj się z nami - być może wkrótce będziemy mogli dostarczać również do Ciebie!</p>
        </div>
    </div>
</div>
@endsection