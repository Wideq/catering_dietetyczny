<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PureMeal - Rejestracja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #333;
            --secondary-color: #fff;
            --accent-color: #f39c12;
            --background-color: #f5f5f5;
            --font-family: 'Roboto', sans-serif;
        }

        body {
            background-color: var(--background-color);
            color: var(--primary-color);
            font-family: var(--font-family);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: var(--secondary-color);
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 550px;
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.3);
        }

        .login-title {
            text-align: center;
            margin-bottom: 35px;
            color: var(--primary-color);
            font-weight: 700;
            font-size: 2.5rem;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            display: block;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #ddd;
            padding: 14px;
            font-size: 1.1rem;
            width: 100%;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 8px rgba(243, 156, 18, 0.3);
        }

        .btn-login {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            border: none;
            padding: 14px 30px;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 1.2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-login:hover {
            background-color: var(--accent-color);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .login-footer {
            margin-top: 30px;
            text-align: center;
            color: #777;
            font-size: 1.1rem;
        }

        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .login-footer a:hover {
            color: var(--accent-color);
        }
    </style>
</head>

<body data-aos="fade-in" data-aos-duration="800" data-aos-easing="ease-in-out">
    <div class="login-container animate__animated animate__fadeIn">
        <h2 class="login-title">Zarejestruj się</h2>
        <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">Imię i nazwisko</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Wprowadź swoje imię i nazwisko" required>
            </div>
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Wprowadź swój email" required>
            </div>
            <div class="form-group">
                <label for="password" class="form-label">Hasło</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Wprowadź hasło" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Potwierdzenie hasła</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Potwierdź swoje hasło" required>
            </div>
            <button type="submit" class="btn-login">Zarejestruj się</button>
        </form>


        <div class="login-footer">
            Masz już konto? <a href="/login">Zaloguj się</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Walidacja nazwy użytkownika
        const name = document.getElementById('name');
        if (name.value.trim().length < 2) {
            showError(name, 'Imię musi mieć co najmniej 2 znaki');
            isValid = false;
        } else {
            clearError(name);
        }
        
        // Walidacja email
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            showError(email, 'Wprowadź poprawny adres email');
            isValid = false;
        } else {
            clearError(email);
        }
        
        // Walidacja hasła
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        
        if (password.value.length < 8) {
            showError(password, 'Hasło musi mieć co najmniej 8 znaków');
            isValid = false;
        } else {
            clearError(password);
        }
        
        if (password.value !== passwordConfirm.value) {
            showError(passwordConfirm, 'Hasła nie są identyczne');
            isValid = false;
        } else {
            clearError(passwordConfirm);
        }
        
        if (!isValid) {
            e.preventDefault();
        }
    });
    
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
</body>
</html>