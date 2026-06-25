<nav class="navbar navbar-expand-lg bg-supercasas py-3">
    <div class="container-fluid px-4">
        
        <!-- Botón menú móvil -->
        <button class="navbar-toggler border-0 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#menuSC">
            <i class="bi bi-list fs-2"></i>
        </button>

        <!-- Logo institucional -->
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <?php if(file_exists("assets/img/logo.jpeg")): ?>
                <img src="assets/img/logo.jpeg" alt="Super Casas" height="50">
            <?php else: ?>
                <!-- Texto si aún no has subido la imagen -->
                <span class="text-white fw-bold fs-4">SuperCasas</span>
            <?php endif; ?>
        </a>

        <!-- Buscador Central (.search-box de tu style.css) -->
        <div class="flex-grow-1 mx-lg-5 d-none d-md-block">
            <div class="input-group search-box overflow-hidden" style="max-width: 600px;">
                <input type="text" class="form-control border-0 py-2 ps-3" placeholder="Busca casas, departamentos o terrenos...">
                <button class="btn btn-white border-0 px-3" type="button">
                    <i class="bi bi-search text-primary"></i>
                </button>
            </div>
        </div>

        <!-- Acciones Derecha (.btn-sc-outline de tu style.css) -->
        <div class="d-flex align-items-center">
            <button type="button" 
            class="btn-sc-outline d-none d-sm-inline-block me-4" 
            data-bs-toggle="modal" data-bs-target="#modalRegistro">
            Publicar anuncio
            </button>
            
            <a href="#" class="text-white text-decoration-none fw-bold me-3">
                <i class="bi bi-bell fs-5"></i>
            </a>

            <a href="/Super Casas/views/login.php" class="text-white text-decoration-none fw-bold">
   <i class="bi bi-person-circle fs-4 me-1"></i> SAPN Super Casas
    </a>

        </div>

         <!-- Contenedor colapsable del menú -->
       <div class="collapse navbar-collapse" id="menuSC">
            <ul class="navbar-nav ms-auto mt-3 mt-lg-0">
                <li class="nav-item"><a class="nav-link text-white" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Publicar anuncio</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#">Acceder</a></li>
            </ul>
        </div>

    </div>
</nav>

<div class="bg-supercasas-verde border-bottom d-none d-lg-block py-2">
    <div class="container-fluid px-4 d-flex align-items-center justify-content-between">
        
        <div class="d-flex align-items-center gap-3">
            
            <a href="index.php?ruta=inicio" class="text-white text-decoration-none btn-sm fw-bold px-2 link-sub-sc text-uppercase small">
                Inicio
            </a>

            <a href="index.php?ruta=quienes-somos" class="text-white text-decoration-none btn-sm fw-bold px-2 link-sub-sc text-uppercase small">
                ¿Quiénes Somos?
            </a>

            <div class="dropdown">
                <button class="btn btn-link text-white text-decoration-none dropdown-toggle btn-sm fw-bold px-2 link-sub-sc text-uppercase small" type="button" id="dropInmuebles" data-bs-toggle="dropdown" aria-expanded="false">
                    Inmuebles
                </button>
                <ul class="dropdown-menu dropdown-menu-custom shadow" aria-labelledby="dropInmuebles">
                   <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=terreno">Terrenos</a></li>
                    <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=casa">Casas</a></li>
                    <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=edificio">Edificios</a></li>
                    <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=departamento">Departamentos</a></li>
                    <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=garzonier">Garzoniers</a></li>
                    <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=monoambiente">Monoambientes</a></li>
                    <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=oficina">Oficinas</a></li>
                    <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=local">Locales Comerciales</a></li>
                    <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=galpon">Galpones / Tinglados</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="index.php?ruta=catalogo&tipo=terreno">Otros</a></li>
                </ul>
            </div>

            <a href="index.php?ruta=agentes" class="text-white text-decoration-none btn-sm fw-bold px-2 link-sub-sc text-uppercase small">
                Agentes
            </a>

            <a href="index.php?ruta=blog" class="text-white text-decoration-none btn-sm fw-bold px-2 link-sub-sc text-uppercase small">
                Blog
            </a>

            <a href="index.php?ruta=contacto" class="text-white text-decoration-none btn-sm fw-bold px-2 link-sub-sc text-uppercase small">
                Contactos
            </a>

        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="index.php?ruta=quiero-vender" class="text-warning text-decoration-none btn-sm fw-bold small text-uppercase btn-vender-sc px-3 py-1 rounded">
                <i class="bi bi- megaphone me-1"></i> ¿Quieres vender o alquilar?
            </a>
        </div>

    </div>
</div>