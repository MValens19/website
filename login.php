<?php
session_start();

// CAMBIA ESTO POR TU CONTRASEÑA REAL
$password_admin = "Moisescr7_"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['password'] === $password_admin) {
        $_SESSION['usuario'] = 'admin';
        header("Location: /admin/admin.php");
        exit;
    } else {
        $error = "Contraseña incorrecta";
    }
}

?>
<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { colors: { primary: '#8b5cf6', darkbg: '#0f172a', cardbg: '#1e293b' } } } }
    </script>
</head>
<body class="bg-darkbg text-white h-screen flex items-center justify-center">
    <div class="bg-cardbg p-8 rounded-xl shadow-2xl w-full max-w-md border border-gray-700">
        <h2 class="text-2xl font-bold mb-6 text-center text-primary">Acceso Administrador</h2>
        
        <?php if(isset($error)) echo "<p class='text-red-500 text-center mb-4'>$error</p>"; ?>

        <form method="POST">
            <label class="block mb-2 text-sm text-gray-400">Contraseña</label>
            <input type="password" name="password" class="w-full p-3 rounded bg-darkbg border border-gray-600 focus:border-primary outline-none mb-6" required>
            <button type="submit" class="w-full bg-primary hover:bg-violet-600 text-white py-3 rounded font-bold transition">Entrar</button>
        </form>
        <a href="/index.php" class="block text-center mt-4 text-gray-500 text-sm hover:text-white">← Volver a la web</a>
    </div>
</body>
</html>