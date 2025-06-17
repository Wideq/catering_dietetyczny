@extends('layout')

@section('title', 'Cennik')

@section('content')
<style>
    .package-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        background-color: #fff;
        border-radius: 0.5rem;
    }

    .package-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .premium-package {
        border-color: #333 !important;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 2;
    }

    .faq-item:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .review-card {
        transition: transform 0.3s ease;
    }

    .review-card:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }
</style>

<header class="py-5 bg-dark text-white text-center" data-aos="fade-down">
    <div class="container">
        <h1 class="display-4 fw-bold">Cennik</h1>
        <p class="lead">Wybierz najlepszy plan żywieniowy dla siebie!</p>
    </div>
</header>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 text-dark" data-aos="fade-up">Nasze Pakiety</h2>
        <div class="row g-4 justify-content-center">

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 shadow-sm package-card border-0">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark">Pakiet Podstawowy</h5>
                        <p class="card-text text-secondary fw-bold fs-3 mb-4">49 zł / dzień</p>
                        <ul class="list-unstyled mb-4 text-start mx-auto" style="max-width: 220px; color: #555;">
                            <li class="d-flex align-items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#28a745" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
                                    <path d="M10.97 5.97a.75.75 0 0 0-1.08-1.04L7.477 7.417 6.324 6.264a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.08 0l3.875-3.875z" />
                                </svg>
                                3 posiłki dziennie
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#28a745" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
                                    <path d="M10.97 5.97a.75.75 0 0 0-1.08-1.04L7.477 7.417 6.324 6.264a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.08 0l3.875-3.875z" />
                                </svg>
                                1500 kcal
                            </li>
                            <li class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#28a745" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
                                    <path d="M10.97 5.97a.75.75 0 0 0-1.08-1.04L7.477 7.417 6.324 6.264a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.08 0l3.875-3.875z" />
                                </svg>
                                Darmowa dostawa
                            </li>
                        </ul>
                        <a href="#zamow" class="btn btn-outline-dark mt-auto px-4 py-2 fw-semibold">
                            Zamów <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 shadow package-card border-3 border-dark bg-white position-relative premium-package">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark">Pakiet Premium</h5>
                        <p class="card-text text-dark fw-bold fs-3 mb-4">69 zł / dzień</p>
                        <ul class="list-unstyled mb-4 text-start mx-auto" style="max-width: 220px; color: #444;">
                            <li class="d-flex align-items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#198754" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
                                    <path d="M10.97 5.97a.75.75 0 0 0-1.08-1.04L7.477 7.417 6.324 6.264a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.08 0l3.875-3.875z" />
                                </svg>
                                5 posiłków dziennie
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#198754" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
                                    <path d="M10.97 5.97a.75.75 0 0 0-1.08-1.04L7.477 7.417 6.324 6.264a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.08 0l3.875-3.875z" />
                                </svg>
                                2000 kcal
                            </li>
                            <li class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#198754" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
                                    <path d="M10.97 5.97a.75.75 0 0 0-1.08-1.04L7.477 7.417 6.324 6.264a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.08 0l3.875-3.875z" />
                                </svg>
                                Indywidualne dopasowanie
                            </li>
                        </ul>
                        <a href="#zamow" class="btn btn-dark mt-auto px-4 py-2 fw-semibold">
                            Zamów <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <span class="badge bg-dark text-white position-absolute top-0 start-50 translate-middle-x mt-3 px-3 py-1 fw-semibold shadow-sm" style="border-radius: 20px; font-size: 0.9rem; letter-spacing: 1px;">
                            Najlepszy wybór
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card h-100 shadow-sm package-card border-0">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark">Pakiet Sport</h5>
                        <p class="card-text text-secondary fw-bold fs-3 mb-4">79 zł / dzień</p>
                        <ul class="list-unstyled mb-4 text-start mx-auto" style="max-width: 220px; color: #555;">
                            <li class="d-flex align-items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#28a745" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
                                    <path d="M10.97 5.97a.75.75 0 0 0-1.08-1.04L7.477 7.417 6.324 6.264a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.08 0l3.875-3.875z" />
                                </svg>
                                6 posiłków dziennie
                            </li>
                            <li class="d-flex align-items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#28a745" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
                                    <path d="M10.97 5.97a.75.75 0 0 0-1.08-1.04L7.477 7.417 6.324 6.264a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.08 0l3.875-3.875z" />
                                </svg>
                                2500+ kcal
                            </li>
                            <li class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#28a745" class="bi bi-check2-circle me-2" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 1 1 11 0 5.5 5.5 0 0 1-11 0z" />
                                    <path d="M10.97 5.97a.75.75 0 0 0-1.08-1.04L7.477 7.417 6.324 6.264a.75.75 0 1 0-1.06 1.06l1.75 1.75a.75.75 0 0 0 1.08 0l3.875-3.875z" />
                                </svg>
                                Konsultacje dietetyczne
                            </li>
                        </ul>
                        <a href="#zamow" class="btn btn-outline-dark mt-auto px-4 py-2 fw-semibold">
                            Zamów <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-5 text-dark" data-aos="fade-up">Najczęściej zadawane pytania</h2>
        <div class="row justify-content-center">
            <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
                <div class="faq-item p-4 mb-4 shadow-sm rounded border">
                    <h5 class="faq-question fw-bold">Jakie diety oferujecie?</h5>
                    <p class="faq-answer text-secondary">Oferujemy diety dostosowane do różnych potrzeb, w tym diety wegetariańskie, bezglutenowe, wysokobiałkowe i wiele innych.</p>
                </div>
            </div>
            <div class="col-md-8" data-aos="fade-up" data-aos-delay="200">
                <div class="faq-item p-4 mb-4 shadow-sm rounded border">
                    <h5 class="faq-question fw-bold">Czy dostarczacie na terenie całego kraju?</h5>
                    <p class="faq-answer text-secondary">Dostarczamy jedzenie na terenie wybranych miast i regionów, ale stale rozszerzamy naszą strefę dostaw.</p>
                </div>
            </div>
            <div class="col-md-8" data-aos="fade-up" data-aos-delay="300">
                <div class="faq-item p-4 mb-4 shadow-sm rounded border">
                    <h5 class="faq-question fw-bold">Jakie są opcje płatności?</h5>
                    <p class="faq-answer text-secondary">Akceptujemy płatności kartą kredytową, przelewem bankowym oraz przy odbiorze.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 text-dark" data-aos="fade-up">Opinie naszych klientów</h2>
        <div id="carouselOpinie" class="carousel slide" data-bs-ride="carousel" data-aos="fade-up" data-aos-delay="100">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="review-card p-4 bg-white shadow-sm rounded mx-auto" style="max-width: 600px;">
                        <p class="fst-italic text-secondary">"PureMeal to najlepszy catering dietetyczny! Diety są smaczne i dobrze zbilansowane. Polecam!"</p>
                        <h5 class="fw-bold text-dark">- Anna Kowalska</h5>
                        <div class="star-rating text-warning fs-4">
                            &#9733;&#9733;&#9733;&#9733;&#9734;
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="review-card p-4 bg-white shadow-sm rounded mx-auto" style="max-width: 600px;">
                        <p class="fst-italic text-secondary">"Dzięki PureMeal schudłem 10 kg w miesiąc! Jedzenie jest pyszne i różnorodne."</p>
                        <h5 class="fw-bold text-dark">- Jan Nowak</h5>
                        <div class="star-rating text-warning fs-4">
                            &#9733;&#9733;&#9733;&#9733;&#9733;
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselOpinie" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Poprzedni</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselOpinie" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Następny</span>
            </button>
        </div>
    </div>
</section>

<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-5 text-dark" data-aos="fade-up">Masz pytania? Skontaktuj się z nami!</h2>
        <div class="row justify-content-center">
            <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Imię i nazwisko</label>
                        <input type="text" class="form-control" id="name" placeholder="Twoje imię i nazwisko" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Adres email</label>
                        <input type="email" class="form-control" id="email" placeholder="name@example.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label fw-semibold">Wiadomość</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Napisz do nas..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark px-4 py-2 fw-semibold">Wyślij</button>
                </form>
            </div>
        </div>
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const message = document.getElementById('message');
            
            let isValid = true;
            
            // Walidacja imienia
            if (name.value.trim().length < 2) {
                showError(name, 'Imię musi mieć co najmniej 2 znaki');
                isValid = false;
            } else {
                clearError(name);
            }
            
            // Walidacja email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email.value)) {
                showError(email, 'Wprowadź poprawny adres email');
                isValid = false;
            } else {
                clearError(email);
            }
            
            // Walidacja wiadomości
            if (message.value.trim().length < 10) {
                showError(message, 'Wiadomość musi mieć co najmniej 10 znaków');
                isValid = false;
            } else {
                clearError(message);
            }
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    }
    
    function showError(field, message) {
        field.classList.add('is-invalid');
        let errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback';
            field.parentNode.appendChild(errorDiv);
        }
        errorDiv.textContent = message;
    }
    
    function clearError(field) {
        field.classList.remove('is-invalid');
        const errorDiv = field.parentNode.querySelector('.invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
});
</script>
@endsection
