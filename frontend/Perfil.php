    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta Nome="viewport" content="width=device-width, initial-scale=1.0">
        <title>Projeto de vida - Estudante de programação</title>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap">
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <!-- Navigation -->
        <header id="navbar">
            <div class="container">
                <a href="#Inicio" class="logo">Projeto de <span>Vida</span></a>
                <nav>
                    <ul class="desktop-nav">
                        <li><a href="index.php?#Inicio">Início</a></li>
                        <li><a href="index.php?#Sobre">Sobre</a></li>
                        <li><a href="index.php?#Educacao">Educação</a></li>
                        <li><a href="index.php?#Carreira">Carreira</a></li>
                        <li><a href="index.php?#Contato">Contato</a></li>
                        <li><a href="index.php?Perfil.php">Perfil</a></li>
                    </ul>

                    <button id="mobile-menu-btn" aria-label="Toggle menu">
                        <span>
                            <li><a href="index.php?#Inicio">Início</a></li>
                        </span>
                        <span>
                            <li><a href="index.php?#Sobre">Sobre</a></li>
                        </span>
                        <span>
                            <li><a href="index.php?#Educacao">Educação</a></li>
                        </span>
                        <span>
                            <li><a href="index.php?#Carreira">Carreira</a></li>
                        </span>
                        <span>
                            <li><a href="index.php?#Contato">Contato</a></li>
                        </span>
                        <span>
                            <li><a href="index.php?Perfil.php">Perfil</a></li>
                        </span>
                    </button>
                </nav>
            </div>

            <!-- Mobile Navigation -->
            <div id="mobile-menu">
                <ul>
                    <li><a href="index.php?#Inicio">Início</a></li>
                    <li><a href="index.php?#Sobre">Sobre</a></li>
                    <li><a href="index.php?#Educacao">Educação</a></li>
                    <li><a href="index.php?#Carreira">Carreira</a></li>
                    <li><a href="index.php?#Contato">Contato</a></li>
                    <li><a href="index.php?Perfil.php">Perfil</a></li>
                </ul>
            </div>
        </header>

        <main>
            <section class="features">
                <div class="feature-card">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAKoAAACUCAMAAAA02EJtAAAAMFBMVEXk5ueutLfn6eqrsbTq7O3h4+Ta3d6orrG0ubzU19m7wMLQ09XJzc+4vb/X2tu+w8WvuuWfAAAEOElEQVR4nO2c25KsKgxAJVwVlP//243ap3vG7lYuITh1WG9TNQ+rQoiISQ9Dp9PpdDqdTqfT6XQ6nU7nHgBIqRbrNuyipARo7fQJENI6b7jWfENrZrwbpbibLcDiDeOc/SL8bby6lSxIy/RB86mrmZV3kQXpjP7suaONu4esGM2XgP4IrVlEa88Q0ulSdIusbx1YGFmUaQgsW5q6gosU3VxtQ1eIW/ynrG/mKqfTjf+O9q1U02K6x7WJKMzJpo1yAHzi6u9oR+4KNiOmW1yp6wCoPNEVRasqYyv/h7AaUlPhs02DK2W6wlJgGlwVnaucS0wZn8hMh9zd/3QdyVRNmSldWMFmFf+faKIDoSgVDRiSlwIYCzN1haYIwFRuyhjJsUWVbqoNI+ubZp9TDowEYS15pr7grr5pcVF9qM71TVVxUX241k/W8vq/o6s/XEX6u99n6h8FMR5Vu+pc+4EFSOsfXGurSjRVXTsBsApAUK1dAkY81cpvrliP1VV1+TOqtd9a/qeqfycBaufqgPG28lCtfXe1/J26ivi0qmyKeAbQtc8AAi1Xq18FCJRXa7Z+Fah+CEz4qHaKtpVN8UpA9Vq1Xq3jQHFngXQPQPCxDStZCb4JAdadFcX92t+5CUQ5XHGaa2vASFaaVhaEjaWpPrQilFYa0UBpWAm/XsvCekVwt/ofhUWAU1yuP11Lwspn0uYFWRJWStGiFCBd/o3cAxZp48KDnN6l9aM1vSkM172gH0xNi167cBpM716jOfshuLYyXdts01y5GZq1Wsa2BD9MGzcGu+h37QbdgL+JaQrfF181bwwH6b6NBPwQ5fdotwc1X2SBnohbFr8j1Py1nZFzNsnma/8CxOLm4wTLFk8+u+VWQyzrc1YqZ7R+5S0PfxinbpGjb4AYlPXTbALz5K0abhbP34AQsCHurLnqHbiZ7WOoTi7WrYsfSgEPG4yzkATeuVHt96jNpWHdTaP1M9PrjjqWgG3ubhu8WycFGw4KCpCj28bsPpWpgzIz6z6DNimh/PqGnTAZFP7V+HEgDS4MavRfhwHPfbWeQxEjshXSenO15Ke2bHIUY5hC+ZRV/2LL2Fz5NgCkPZ+tTEBzVy8RQF0MgSbCmV+q7DEx+OKFf5ed8IdGo876OegZNw2CKHpEn3CP2M0uxrz7qVhX5pBSFjIv0pJkcT5j2Xpr/0KXv9FCxgRoFtyMZbUAlpybyUzZktsXKP5AlYSespMAhrxR1Wy4ySxbIKvv/DfXvHERUBQ7/002I2HbmOa4wtLGNN0V8BrVM1zTTFvFdHeNfxikfo5Ad02oA+RV6kisqyCu/O/wyC48xM7vfNeosaFQpm5AXMlqnqg714dtQXqY+k7EmCNeh3ohl9UVZ0oZhYtmfBhbC764+jUZnJZfJE4P2nhjHwic9jhn/exPRU6+zDY8+n3i8Bz4BwNyNbbmxYzRAAAAAElFTkSuQmCC" alt="Foto de Perfil">
                   
                        <div class="text">
                            <h2><?php echo $name; ?></h2>
                            <p><?php echo $email; ?></p>
                            <button class="btn btn-primary"><a href="index.php?#Contato">Contato</a></button>
                            <button class="btn btn-primary"><a href="https://github.com/Eric-codecrypt?tab=projects">Ver Projetos</a></button>
                        </div>
                    
                </div>


                </div>
            </section>
        </main>


    </body>

    </html>