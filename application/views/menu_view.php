<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Responsive</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">Mi Proyecto</div>
        <div class="menu-icon" id="menu-icon">
            &#9776; <!-- Ícono de hamburguesa -->
        </div>
        <ul class="nav-links" id="nav-links">
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Servicios</a></li>
            <li><a href="#">Nosotros</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
    </nav>

    <script src="scripts.js"></script>
</body>
</html>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #333;
    padding: 10px 20px;
}

.logo {
    color: white;
    font-size: 24px;
    font-weight: bold;
}

.nav-links {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex;
}

.nav-links li {
    margin-left: 20px;
}

.nav-links li a {
    color: white;
    text-decoration: none;
    padding: 8px 16px;
    display: block;
}

.menu-icon {
    display: none;
    font-size: 24px;
    color: white;
    cursor: pointer;
}

@media (max-width: 768px) {
    .nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        background-color: #333;
        position: absolute;
        top: 60px;
        left: 0;
    }

    .nav-links li {
        margin: 0;
        text-align: center;
    }

    .menu-icon {
        display: block;
    }

    .nav-links.active {
        display: flex;
    }
}

</style>

<script>
document.getElementById('menu-icon').addEventListener('click', function() {
    var navLinks = document.getElementById('nav-links');
    navLinks.classList.toggle('active');
});

</script>


<script src="scripts.js"></script>
</body>
</html>
