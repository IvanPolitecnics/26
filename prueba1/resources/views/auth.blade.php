<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login / Registro</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: Arial;
            background: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .box {
            background: white;
            padding: 20px;
            width: 300px;
            border-radius: 8px;
        }
        input, button {
            width: 100%;
            margin-top: 10px;
            padding: 8px;
        }
        button {
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Login</h2>
    <input type="email" id="login_email" placeholder="Email">
    <input type="password" id="login_password" placeholder="Password">
    <button onclick="login()">Entrar</button>

    <hr>

    <h2>Registro</h2>
    <input type="text" id="reg_nombre" placeholder="Nombre">
    <input type="email" id="reg_email" placeholder="Email">
    <input type="password" id="reg_password" placeholder="Password">
    <button onclick="register()">Registrarse</button>

    <p id="msg"></p>
</div>

<script>
const token = document.querySelector('meta[name="csrf-token"]').content;

function login() {
    fetch('{{ url("login") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            email: login_email.value,
            password: login_password.value
        })
    })
    .then(r => {
        if (!r.ok) throw 'Error';
        return r.json();
    })
    .then(() => window.location.href = '{{ url("principal") }}')
    .catch(() => msg.innerText = 'Login incorrecto');
}

function register() {
    fetch('{{ url("register") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            nombre: reg_nombre.value,
            email: reg_email.value,
            password: reg_password.value
        })
    })
    .then(r => r.json())
    .then(data => msg.innerText = data.message);
}
</script>



</body>
</html>
