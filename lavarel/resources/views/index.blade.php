@extends('layout')

@section('title', 'PureMeal - Catering Dietetyczny')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
<style>
    :root {
        --primary-color: #1a1a1a;
        --secondary-color: #ffffff;
        --gray-dark: #333333;
        --gray-medium: #666666;
        --gray-light: #f5f5f5;
        --accent: #888888;
        --font-primary: 'Montserrat', sans-serif;
        --transition: all 0.3s ease;
        --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    body {
        font-family: var(--font-primary);
        color: var(--primary-color);
        background-color: var(--secondary-color);
        line-height: 1.6;
        overflow-x: hidden;
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: 700;
        letter-spacing: -0.5px;
    }

    p {
        color: var(--gray-medium);
    }

    .btn-primary {
        background-color: var(--accent);
        border-color: var(--accent);
        color: var(--secondary-color);
        padding: 12px 28px;
        font-weight: 500;
        letter-spacing: 1px;
        border-radius: 0;
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }

    .btn-primary:before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: var(--primary-color);
        transition: all 0.4s;
        z-index: -1;
    }

    .btn-primary:hover {
        background-color: var(--accent);
        border-color: var(--accent);
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }
    
    .btn-primary:hover:before {
        left: 0;
    }

    .btn-outline {
        background-color: transparent;
        border: 1px solid var(--primary-color);
        color: var(--primary-color);
        padding: 12px 28px;
        font-weight: 500;
        letter-spacing: 1px;
        border-radius: 0;
        transition: var(--transition);
    }

    .btn-outline:hover {
        background-color: var(--primary-color);
        color: var(--secondary-color);
        transform: translateY(-3px);
        box-shadow: var(--box-shadow);
    }

    /* HERO SECTION */
    .hero {
        position: relative;
        height: 100vh;
        background-color: var(--primary-color);
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 0 15px;
    }

    .hero-content {
        max-width: 900px;
        z-index: 2;
    }

    .hero-title {
        font-size: 4.5rem;
        font-weight: 300;
        color: var(--secondary-color);
        margin-bottom: 1.5rem;
        letter-spacing: -2px;
    }

    .hero-title span {
        font-weight: 800;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--accent);
        margin-bottom: 2.5rem;
        font-weight: 400;
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
    }

    .hero-btn {
        color: var(--secondary-color);
        border: 1px solid var(--secondary-color);
        background-color: transparent;
        padding: 14px 36px;
        font-size: 1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        border-radius: 0;
        transition: var(--transition);
    }

    .hero-btn:hover {
        background-color: var(--secondary-color);
        color: var(--primary-color);
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    /* OFFER SECTION */
    .section {
        padding: 120px 0;
    }

    .section-title {
        text-align: center;
        margin-bottom: 60px;
    }

    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        left: 50%;
        bottom: -15px;
        width: 40px;
        height: 2px;
        background-color: var(--primary-color);
        transform: translateX(-50%);
    }

    .section-title p {
        max-width: 600px;
        margin: 0 auto;
        color: var(--gray-medium);
    }

    .offer-card {
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        background-color: var(--secondary-color);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        transition: all 0.5s cubic-bezier(0.215, 0.61, 0.355, 1);
        border: none;
        border-radius: 0;
        overflow: hidden;
    }

    .offer-card:before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(to right, var(--accent), var(--primary-color));
        transform: translateY(-100%);
        transition: all 0.4s ease;
    }

    .offer-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }
    
    .offer-card:hover:before {
        transform: translateY(0);
    }

    .offer-image {
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: var(--gray-light);
        overflow: hidden;
        position: relative;
    }
    
    .offer-image:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, transparent 40%, rgba(0,0,0,0.03) 100%);
        opacity: 0;
        transition: all 0.4s ease;
    }
    
    .offer-card:hover .offer-image:after {
        opacity: 1;
    }

    .offer-icon {
        font-size: 3rem;
        color: var(--accent);
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .offer-card:hover .offer-icon {
        transform: scale(1.1) rotate(10deg);
        color: var(--primary-color);
    }

    .offer-body {
        padding: 2rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        position: relative;
        z-index: 1;
    }
    
    .offer-body:before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(245,245,245,0.05) 0%, rgba(255,255,255,0) 30%);
        z-index: -1;
        opacity: 0;
        transition: all 0.5s ease;
    }
    
    .offer-card:hover .offer-body:before {
        opacity: 1;
    }

    .offer-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        padding-bottom: 15px;
    }
    
    .offer-title:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 30px;
        height: 2px;
        background-color: var(--accent);
        transition: all 0.3s ease;
    }
    
    .offer-card:hover .offer-title:after {
        width: 50px;
    }

    .offer-text {
        margin-bottom: 1.5rem;
        color: var(--gray-medium);
        flex-grow: 1;
    }

    .offer-price {
        font-size: 1.35rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: var(--primary-color);
        display: flex;
        align-items: flex-end;
    }

    .offer-price span {
        font-size: 0.9rem;
        color: var(--gray-medium);
        font-weight: 400;
        margin-left: 5px;
    }
    
    .offer-card .btn {
        transform: translateY(0);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .offer-card:hover .btn {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* FAQ SECTION */
    .faq-section {
        background-color: var(--gray-light);
    }

    .accordion-item {
        border: none;
        background-color: transparent;
        margin-bottom: 15px;
    }

    .accordion-button {
        padding: 1.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
        background-color: var(--secondary-color);
        box-shadow: none;
        border-radius: 0 !important;
    }

    .accordion-button:not(.collapsed) {
        color: var(--primary-color);
        background-color: var(--secondary-color);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }

    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23212529'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    .accordion-body {
        padding: 1rem 1.5rem 1.5rem;
        background-color: var(--secondary-color);
        color: var(--gray-medium);
    }
</style>
@endpush

@section('content')
<section class="hero">
    <div class="hero-content" data-aos="fade-up" data-aos-duration="1000">
        <h1 class="hero-title" data-aos="fade-up" data-aos-delay="200">pure<span>meal</span></h1>
        <p class="hero-subtitle" data-aos="fade-up" data-aos-delay="400">Odkryj nasze premium diety pudełkowe, perfekcyjnie dopasowane do Twojego stylu życia, celów i preferencji smakowych.</p>
        <a href="#oferta" class="btn hero-btn" data-aos="fade-up" data-aos-delay="600">Poznaj ofertę</a>
    </div>
</section>

<section id="oferta" class="section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Nasza oferta</h2>
            <p>Wybierz jeden z naszych planów żywieniowych, skomponowanych przez doświadczonych dietetyków i przygotowanych przez profesjonalnych szefów kuchni.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="offer-card">
                    <div class="offer-image">
                        <i class="fas fa-utensils offer-icon"></i>
                    </div>
                    <div class="offer-body">
                        <h3 class="offer-title">Dieta Standard</h3>
                        <p class="offer-text">Zbilansowane posiłki dostosowane do Twoich potrzeb kalorycznych, zapewniające wszystkie niezbędne składniki odżywcze.</p>
                        <div class="offer-price">
                            Od 59 zł <span>/ dzień</span>
                        </div>
                        <a href="#" class="btn btn-primary w-100">Zamów teraz</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="offer-card">
                    <div class="offer-image">
                        <i class="fas fa-carrot offer-icon"></i>
                    </div>
                    <div class="offer-body">
                        <h3 class="offer-title">Dieta Vege</h3>
                        <p class="offer-text">Pełnowartościowe posiłki wegetariańskie, bogate w białko roślinne, witaminy i minerały.</p>
                        <div class="offer-price">
                            Od 65 zł <span>/ dzień</span>
                        </div>
                        <a href="#" class="btn btn-primary w-100">Zamów teraz</a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="offer-card">
                    <div class="offer-image">
                        <i class="fas fa-dumbbell offer-icon"></i>
                    </div>
                    <div class="offer-body">
                        <h3 class="offer-title">Dieta Sport</h3>
                        <p class="offer-text">Specjalistyczna dieta wysokobiałkowa dla osób aktywnych, wspierająca regenerację i budowę mięśni.</p>
                        <div class="offer-price">
                            Od 69 zł <span>/ dzień</span>
                        </div>
                        <a href="#" class="btn btn-primary w-100">Zamów teraz</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section faq-section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Najczęściej zadawane pytania</h2>
            <p>Znajdź odpowiedzi na najczęściej zadawane pytania dotyczące naszych usług, dostawy i płatności.</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Jakie diety oferujecie?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Oferujemy szeroki wybór diet dopasowanych do różnych potrzeb i celów. W naszej ofercie znajdziesz diety: Standard, Vege, Sport, Ketogeniczną, Bezglutenową, Low Carb oraz diety dedykowane osobom z alergią lub nietolerancją pokarmową. Każdy plan żywieniowy jest przygotowywany przez doświadczonych dietetyków i szefów kuchni.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Kiedy i gdzie dostarczacie posiłki?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Dostawy realizujemy codziennie (7 dni w tygodniu) we wczesnych godzinach porannych (2:00-9:00), co gwarantuje, że posiłki będą świeże na cały dzień. Obecnie obsługujemy wszystkie większe miasta w Polsce oraz ich okolice. Dokładną informację o dostępności dla Twojej lokalizacji uzyskasz podczas składania zamówienia.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Jakie są opcje płatności?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Akceptujemy różne formy płatności: karty płatnicze (Visa, Mastercard), przelewy bankowe, BLIK oraz płatności elektroniczne poprzez PayU. Dla stałych klientów oferujemy również możliwość rozliczeń okresowych oraz atrakcyjne rabaty przy przedłużaniu subskrypcji.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Czy można zmienić lub anulować zamówienie?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Tak, wszystkie zmiany w zamówieniu możesz wprowadzić najpóźniej do godz. 12:00 na dwa dni przed planowaną dostawą. Modyfikacje, takie jak zmiana adresu dostawy, pauza na wybrane dni czy zmiana kaloryczności, możesz wprowadzić samodzielnie w swoim panelu klienta lub kontaktując się z naszym działem obsługi.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Czy oferujecie konsultacje dietetyczne?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Tak, w ramach naszych usług oferujemy również indywidualne konsultacje z certyfikowanymi dietetykami, którzy pomogą Ci dobrać odpowiedni plan żywieniowy, uwzględniający Twoje cele, preferencje smakowe oraz ewentualne przeciwwskazania zdrowotne. Pierwsza konsultacja jest bezpłatna przy zamówieniu diety na minimum 14 dni.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true,
        mirror: false,
        offset: 50
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
</script>
@endpush