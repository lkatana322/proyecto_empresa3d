<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Cotizador 3D</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url('assets_cliente/vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets_cliente/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets_cliente/vendor/aos/aos.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets_cliente/vendor/glightbox/css/glightbox.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets_cliente/vendor/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets_cliente/css/main.css'); ?>" rel="stylesheet">

    <style>
        .uploader {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            margin-top: 20px;
        }
        .uploader:hover {
            background-color: #f9f9f9;
        }
        #viewer {
            width: 100%;
            height: 500px;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-top: 20px;
        }
        #loadingModal .modal-dialog {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        #loadingModal .modal-content {
            background-color: transparent;
            border: none;
        }
        #loadingModal .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body>

<main class="main">

    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>Cotizador 3D</h1>
                        <p class="mb-0">Sube tu archivo 3D para obtener una cotización y visualizar el modelo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Page Title -->

    <!-- Upload Section -->
    <section id="upload" class="upload section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="uploader" onclick="document.getElementById('file-input').click();">
                        <input type="file" id="file-input" accept=".stl" style="display:none" onchange="handleFile(this.files)">
                        <p>Arrastra y suelta tu archivo STL aquí o haz clic para seleccionar</p>
                    </div>
                    <div id="viewer"></div>
                </div>
            </div>
        </div>
    </section><!-- End Upload Section -->

</main><!-- End Main -->

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
    </div>
</div>

<!-- Three.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three/examples/js/loaders/STLLoader.js"></script>

<script>
    function handleFile(files) {
        const file = files[0];
        if (!file.name.endsWith('.stl')) {
            alert('Por favor, sube un archivo STL válido.');
            return;
        }

        $('#loadingModal').modal('show');

        const reader = new FileReader();
        reader.onload = function(event) {
            try {
                const contents = event.target.result;
                const geometry = new THREE.STLLoader().parse(contents);
                const material = new THREE.MeshNormalMaterial();
                const mesh = new THREE.Mesh(geometry, material);

                const viewerElement = document.getElementById('viewer');
                viewerElement.innerHTML = ''; // Clear previous content

                const scene = new THREE.Scene();
                const camera = new THREE.PerspectiveCamera(75, viewerElement.clientWidth / viewerElement.clientHeight, 0.1, 1000);
                const renderer = new THREE.WebGLRenderer();
                renderer.setSize(viewerElement.clientWidth, viewerElement.clientHeight);
                viewerElement.appendChild(renderer.domElement);

                scene.add(mesh);
                camera.position.z = 5;

                const animate = function() {
                    requestAnimationFrame(animate);
                    mesh.rotation.x += 0.01;
                    mesh.rotation.y += 0.01;
                    renderer.render(scene, camera);
                };

                animate();
                $('#loadingModal').modal('hide');
            } catch (error) {
                $('#loadingModal').modal('hide');
                alert('Hubo un error al cargar el archivo STL.');
            }
        };
        reader.onerror = function() {
            $('#loadingModal').modal('hide');
            alert('Hubo un error al leer el archivo.');
        };
        reader.readAsArrayBuffer(file);
    }
</script>

<!-- Vendor JS Files -->
<script src="<?php echo base_url('assets_cliente/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_cliente/vendor/php-email-form/validate.js'); ?>"></script>
<script src="<?php echo base_url('assets_cliente/vendor/aos/aos.js'); ?>"></script>
<script src="<?php echo base_url('assets_cliente/vendor/glightbox/js/glightbox.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_cliente/vendor/purecounter/purecounter_vanilla.js'); ?>"></script>
<script src="<?php echo base_url('assets_cliente/vendor/swiper/swiper-bundle.min.js'); ?>"></script>

<!-- Main JS File -->
<script src="<?php echo base_url('assets_cliente/js/main.js'); ?>"></script>

</body>
</html>
