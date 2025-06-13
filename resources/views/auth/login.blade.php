<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Admin - Servis.in</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('assets/style.css') }}" />
</head>

<body class="login-page-bg">
    <div class="container-fluid p-0">
        <div class="row g-0 min-vh-100">
            <div class="col-lg-7 d-none d-lg-block">
                <div class="login-visual"></div>
            </div>

            <div class="col-lg-5 d-flex flex-column justify-content-center align-items-center p-4">
                <div class="login-form-wrapper">

                    <form method="POST" action="{{ route('login') }}" class="login-form">
                        @csrf
                        <div class="logo text-center mb-3">Servis.in</div>
                        <h2 class="text-center">Selamat Datang Kembali</h2>
                        <p class="subtitle text-center mb-4">
                            Login untuk melanjutkan ke dashboard admin
                        </p>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email"
                                class="form-control form-control-lg @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="Masukkan email Anda" required
                                autofocus />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Masukkan password" required />
                                <span class="input-group-text bg-transparent border-start-0" id="togglePasswordSpan">
                                    <i class="fas fa-eye" id="togglePassword"></i>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        if (togglePassword) {
            togglePassword.addEventListener("click", function(e) {
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);
                this.classList.toggle("fa-eye");
                this.classList.toggle("fa-eye-slash");
            });
        }
    </script>
</body>

</html>