<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon Finder</title>
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/5/53/Pok%C3%A9_Ball_icon.svg"
        type="image/svg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar fixed-top bg-primary navbar-expand-lg">
        <div class="container-fluid">
            <div class="collapse navbar-collapse">
                <div class="nav-item">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Pok%C3%A9_Ball_icon.svg"
                        height="25" alt="Pokeball" loading="auto">
                </div>
                <div class="navbar-nav me-auto mb-2 mb-lg-0">
                    <div class="nav-item">
                        <a class="navbar-brand text-light mt-2 mt-lg-0" aria-current="page" href="/home">Home</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer fixed-bottom bg-primary">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-light">Hecho por Juan Ignacio Regueira</span>
                <a class="btn btn-dark btn-sm ms-auto my-2" href="https://github.com/Regue95/ixpandit-test">Link a mi Repo</a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>
