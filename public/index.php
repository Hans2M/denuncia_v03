<?php include '../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Denuncias - Reporte Seguro</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="hero-header">
        <div class="header-content">
            <div class="logo-container">
                <i class="fas fa-shield-alt logo-icon"></i>
                <h1 class="logo-text">ReporteSeguro</h1>
            </div>
            <nav class="main-nav">
                <a href="denuncia.php" class="nav-link"><i class="fas fa-plus-circle"></i> Nueva Denuncia</a>
                <a href="informacion.php" class="nav-link"><i class="fas fa-info-circle"></i> Información</a>
                <a href="login.php" class="nav-link accent"><i class="fas fa-lock"></i> Acceso Encargado</a>
            </nav>
        </div>
    </header>
    
    <main>
        <!-- Banner principal -->
        <section class="hero-banner">
            <div class="banner-content">
                <h2 class="banner-title">Canales Seguros para Reportar Incidentes</h2>
                <p class="banner-subtitle">Tu voz es importante. Reporta de forma anónima o con tu identidad protegida.</p>
                <a href="denuncia.php" class="cta-button">Reportar Ahora <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="banner-image">
                <img src="../assets/img/denuncia.png" alt="Protección de denuncias" class="floating">
            </div>
        </section>

        <!-- Tarjetas informativas -->
        <section class="info-cards">
            <h2 class="section-title">¿Por qué reportar con nosotros?</h2>
            <div class="cards-container">
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-user-secret"></i>
                    </div>
                    <h3>Anonimato</h3>
                    <p>Puedes reportar sin revelar tu identidad si así lo prefieres.</p>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Protección</h3>
                    <p>Tus datos están seguros con nuestro sistema encriptado.</p>
                </div>
                
                <div class="info-card">
                    <div class="card-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Rápida Respuesta</h3>
                    <p>Nuestro equipo atenderá tu reporte en menos de 24 horas.</p>
                </div>
            </div>
        </section>

        <!-- Testimonios -->
        <section class="testimonials">
            <h2 class="section-title">Lo que dicen nuestros usuarios</h2>
            <div class="testimonial-slider">
                <div class="testimonial active">
                    <p>"Gracias a este sistema pude reportar un incidente en mi trabajo sin temor a represalias."</p>
                    <div class="author">- María G.</div>
                </div>
                <div class="testimonial">
                    <p>"El proceso fue sencillo y recibí seguimiento a mi denuncia en menos de un día."</p>
                    <div class="author">- Carlos M.</div>
                </div>
                <div class="testimonial">
                    <p>"Me sentí seguro reportando aquí, sabiendo que mi identidad estaría protegida."</p>
                    <div class="author">- Ana L.</div>
                </div>
            </div>
            <div class="slider-controls">
                <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
                <div class="slider-dots"></div>
                <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
            </div>
        </section>

        <!-- Estadísticas -->
        <section class="stats">
            <div class="stat-item">
                <div class="stat-number" data-count="1254">0</div>
                <div class="stat-label">Denuncias recibidas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="98">0</div>
                <div class="stat-label">% Resueltas</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" data-count="24">0</div>
                <div class="stat-label">Horas respuesta</div>
            </div>
        </section>
    </main>
    
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Contacto</h3>
                <p><i class="fas fa-envelope"></i> contacto@reporteseguro.com</p>
                <p><i class="fas fa-phone"></i> +123 456 7890</p>
            </div>
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <a href="denuncia.php">Nueva Denuncia</a>
                <a href="informacion.php">Preguntas Frecuentes</a>
                <a href="politicas.php">Políticas de Privacidad</a>
            </div>
            <div class="footer-section">
                <h3>Síguenos</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>Sistema de Denuncias &copy; <span id="current-year"><?= date('Y') ?></span> - Hans Melendez. Todos los derechos reservados.</p>
            <p class="version">v2.1.0</p>
        </div>
    </footer>

    <script>
        // Slider de testimonios
        let currentTestimonial = 0;
        const testimonials = document.querySelectorAll('.testimonial');
        const dotsContainer = document.querySelector('.slider-dots');
        
        // Crear puntos de navegación
        testimonials.forEach((_, index) => {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            if(index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => showTestimonial(index));
            dotsContainer.appendChild(dot);
        });
        
        function showTestimonial(index) {
            testimonials.forEach(testimonial => testimonial.classList.remove('active'));
            document.querySelectorAll('.dot').forEach(dot => dot.classList.remove('active'));
            
            currentTestimonial = index;
            testimonials[currentTestimonial].classList.add('active');
            document.querySelectorAll('.dot')[currentTestimonial].classList.add('active');
        }
        
        document.querySelector('.slider-next').addEventListener('click', () => {
            let nextIndex = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(nextIndex);
        });
        
        document.querySelector('.slider-prev').addEventListener('click', () => {
            let prevIndex = (currentTestimonial - 1 + testimonials.length) % testimonials.length;
            showTestimonial(prevIndex);
        });
        
        // Auto-rotación del slider
        setInterval(() => {
            let nextIndex = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(nextIndex);
        }, 5000);
        
        // Animación de contadores
        const statNumbers = document.querySelectorAll('.stat-number');
        const statsSection = document.querySelector('.stats');
        
        function animateNumbers() {
            const sectionTop = statsSection.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;
            
            if(sectionTop < screenPosition) {
                statNumbers.forEach(stat => {
                    const target = parseInt(stat.getAttribute('data-count'));
                    const increment = target / 50;
                    let current = 0;
                    
                    const timer = setInterval(() => {
                        current += increment;
                        if(current > target) {
                            stat.textContent = target;
                            clearInterval(timer);
                        } else {
                            stat.textContent = Math.floor(current);
                        }
                    }, 20);
                });
                
                window.removeEventListener('scroll', animateNumbers);
            }
        }
        
        window.addEventListener('scroll', animateNumbers);
        
        // Actualizar año en el copyright
        document.getElementById('current-year').textContent = new Date().getFullYear();
    </script>
</body>
</html>