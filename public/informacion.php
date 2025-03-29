<?php 
include '../includes/config.php';
include 'header.php';

// Datos de las instituciones (podrían venir de una base de datos)
$instituciones = [
    [
        'nombre' => 'Ministerio de la Mujer y Poblaciones Vulnerables',
        'logo' => '../assets/img/mujer_1.jpg',
        'descripcion' => 'Encargado de las políticas públicas para la igualdad de género y protección de poblaciones vulnerables.',
        'contactos' => [
            'Línea 100' => 'tel:100',
            'Central telefónica' => 'tel:(01)6261600',
            'Web' => 'https://www.gob.pe/mimp'
        ],
        'servicios' => ['Violencia de género', 'Protección familiar', 'Acoso sexual']
    ],
    [
        'nombre' => 'SUNEDU',
        'logo' => '../assets/img/sunedu.png',
        'descripcion' => 'Superintendencia Nacional de Educación Superior Universitaria que vela por la calidad educativa.',
        'contactos' => [
            'Central telefónica' => 'tel:(01)5003930',
            'Web' => 'https://www.sunedu.gob.pe',
            'Correo' => 'mailto:consultas@sunedu.gob.pe'
        ],
        'servicios' => ['Denuncias por mala calidad educativa', 'Irregularidades en universidades']
    ],
    [
        'nombre' => 'Defensoría del Pueblo',
        'logo' => '../assets/img/pueblo.png',
        'descripcion' => 'Institución autónoma que supervisa el cumplimiento de derechos constitucionales.',
        'contactos' => [
            'Línea gratuita' => 'tel:080015170',
            'Web' => 'https://www.defensoria.gob.pe',
            'WhatsApp' => 'https://wa.me/51989001234'
        ],
        'servicios' => ['Derechos humanos', 'Abusos de autoridad', 'Acceso a servicios públicos']
    ],
    [
        'nombre' => 'INDECOPI',
        'logo' => '../assets/img/indecopi.png',
        'descripcion' => 'Protege los derechos de los consumidores y promueve la competencia leal.',
        'contactos' => [
            'Línea gratuita' => 'tel:080040440',
            'Web' => 'https://www.indecopi.gob.pe',
            'App' => 'https://play.google.com/store/apps/details?id=gob.indecopi.app'
        ],
        'servicios' => ['Derechos del consumidor', 'Competencia desleal', 'Propiedad intelectual']
    ]
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos para Denuncias | Sistema de Reportes</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/informacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <main class="informacion-container">
        <section class="hero-informacion">
            <div class="hero-content">
                <h1>Recursos Institucionales</h1>
                <p>Encuentra aquí los canales oficiales para realizar denuncias en diferentes instituciones del Estado</p>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Buscar institución...">
                    <button><i class="fas fa-search"></i></button>
                </div>
            </div>
            <div class="hero-image">
                <img src="../assets/img/chica.webp" alt="Recursos de ayuda">
            </div>
        </section>

        <section class="instituciones-section">
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">Todas</button>
                <button class="filter-btn" data-filter="mujer">Mujer</button>
                <button class="filter-btn" data-filter="educacion">Educación</button>
                <button class="filter-btn" data-filter="derechos">Derechos</button>
                <button class="filter-btn" data-filter="consumidor">Consumidor</button>
            </div>

            <div class="instituciones-grid" id="institucionesContainer">
                <?php foreach ($instituciones as $institucion): ?>
                <div class="institucion-card" 
                     data-categories="<?= 
                        strtolower(str_replace(' ', '', $institucion['nombre'])) ?> 
                        <?= in_array('Violencia de género', $institucion['servicios']) ? 'mujer' : '' ?>
                        <?= strpos($institucion['nombre'], 'SUNEDU') !== false ? 'educacion' : '' ?>
                        <?= in_array('Derechos humanos', $institucion['servicios']) ? 'derechos' : '' ?>
                        <?= in_array('Derechos del consumidor', $institucion['servicios']) ? 'consumidor' : '' ?>">
                    <div class="card-header">
                        <div class="institucion-logo">
                            <img src="<?= $institucion['logo'] ?>" alt="<?= $institucion['nombre'] ?>">
                        </div>
                        <h3><?= $institucion['nombre'] ?></h3>
                    </div>
                    <div class="card-body">
                        <p><?= $institucion['descripcion'] ?></p>
                        
                        <div class="servicios-list">
                            <h4>Servicios:</h4>
                            <ul>
                                <?php foreach ($institucion['servicios'] as $servicio): ?>
                                <li><i class="fas fa-check-circle"></i> <?= $servicio ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h4>Contactos:</h4>
                        <div class="contactos-grid">
                            <?php foreach ($institucion['contactos'] as $tipo => $valor): ?>
                            <a href="<?= $valor ?>" class="contacto-item">
                                <i class="<?= 
                                    strpos($valor, 'tel:') === 0 ? 'fas fa-phone' : 
                                    (strpos($valor, 'http') === 0 ? 'fas fa-globe' : 
                                    (strpos($valor, 'mailto') === 0 ? 'fas fa-envelope' : 'fab fa-whatsapp')) ?>"></i>
                                <div>
                                    <strong><?= $tipo ?></strong>
                                    <span><?= str_replace(['tel:', 'mailto:', 'https://', 'http://'], '', $valor) ?></span>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="faq-section">
            <h2>Preguntas Frecuentes</h2>
            <div class="faq-container">
                <div class="faq-item">
                    <button class="faq-question">
                        <span>¿Cómo sé qué institución corresponde a mi denuncia?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Nuestro sistema puede orientarte. Al iniciar una denuncia, te haremos preguntas para determinar la naturaleza del caso y te sugeriremos la institución más adecuada. También puedes revisar los servicios que ofrece cada institución en esta sección.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span>¿Puedo denunciar anónimamente en estas instituciones?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Muchas instituciones como el Ministerio de la Mujer (Línea 100) aceptan denuncias anónimas. Sin embargo, algunas investigaciones pueden requerir tu identificación para dar seguimiento al caso. Cada tarjeta muestra los canales disponibles.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <button class="faq-question">
                        <span>¿Qué información debo preparar antes de denunciar?</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="faq-answer">
                        <p>Te recomendamos tener a mano:</p>
                        <ul>
                            <li>Fechas y lugares exactos de los hechos</li>
                            <li>Nombres de personas involucradas (si los conoces)</li>
                            <li>Pruebas o evidencias (fotos, documentos, mensajes)</li>
                            <li>Tus datos de contacto (a menos que sea anónimo)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>


    <script>
        // Filtrado de instituciones
        const filterButtons = document.querySelectorAll('.filter-btn');
        const institutionCards = document.querySelectorAll('.institucion-card');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Actualizar botones activos
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                const filterValue = button.dataset.filter;
                
                // Filtrar instituciones
                institutionCards.forEach(card => {
                    if (filterValue === 'all' || card.dataset.categories.includes(filterValue)) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
        
        // Búsqueda de instituciones
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('keyup', () => {
            const searchTerm = searchInput.value.toLowerCase();
            
            institutionCards.forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                const description = card.querySelector('p').textContent.toLowerCase();
                const services = card.querySelector('ul').textContent.toLowerCase();
                
                if (name.includes(searchTerm) || description.includes(searchTerm) || services.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
        
        // FAQ Acordeón
        const faqQuestions = document.querySelectorAll('.faq-question');
        
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                const icon = question.querySelector('i');
                
                // Cerrar otras respuestas
                document.querySelectorAll('.faq-answer').forEach(item => {
                    if (item !== answer && item.style.maxHeight) {
                        item.style.maxHeight = null;
                        item.previousElementSibling.querySelector('i').classList.replace('fa-chevron-up', 'fa-chevron-down');
                    }
                });
                
                // Alternar la respuesta actual
                if (answer.style.maxHeight) {
                    answer.style.maxHeight = null;
                    icon.classList.replace('fa-chevron-up', 'fa-chevron-down');
                } else {
                    answer.style.maxHeight = answer.scrollHeight + 'px';
                    icon.classList.replace('fa-chevron-down', 'fa-chevron-up');
                }
            });
        });
        
        // Abrir la primera pregunta por defecto
        if (faqQuestions.length > 0) {
            faqQuestions[0].click();
        }
    </script>
</body>
</html>