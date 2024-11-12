<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin-top: 70px; /* Espaço para o header fixo */
            background-color: #f1f1f1;
        }
        header {
            width: 100%;
            background-color: #006400;
            padding: 10px 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        header .container {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        header img {
            max-height: 50px;
        }
        .login-container {
            width: 90%;
            max-width: 500px;
            padding: 30px;
            background-color: #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        @media (min-width: 992px) {
            .login-container {
                max-width: 400px;
                padding: 40px;
            }
        }
        .login-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-header img {
            max-width: 150px;
        }
        .form-control {
            border-radius: 5px;
        }
        .btn-login {
            background-color: #006400;
            color: #fff;
            border-radius: 5px;
        }
        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <img src="logo.png" alt="Logo">
        </div>
    </header>

    <div class="login-container">
        <div class="login-header">
            <h3>LOGIN</h3>
        </div>
        <form>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="CPF" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" placeholder="Senha" required>
            </div>
            <button type="submit" class="btn btn-login w-100">Entrar</button>
            <a href="#" class="forgot-password">Esqueci minha senha</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
