<footer id="footer" class="footer light-background">
  <div class="container footer-top">
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6 footer-about">
        <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center mb-3">
          <img src="<?php echo base_url('assets_admin/img/logo.png'); ?>" alt="3D Print Shop Logo" class="me-2" style="width: 50px;">
          <span class="sitename">3DPrintShop</span>
        </a>
        <p>Transformando tus ideas en realidad con nuestra avanzada tecnología de impresión 3D.</p>
        <div class="footer-contact mt-3">
          <p><i class="bi bi-geo-alt"></i> Calle Ejemplo 123, Ciudad, País</p>
          <p><i class="bi bi-phone"></i> <strong>Teléfono:</strong> +123 456 7890</p>
          <p><i class="bi bi-envelope"></i> <strong>Email:</strong> info@printmaster3d.com</p>
        </div>
        <div class="social-links d-flex mt-4">
          <a href="#" class="bi bi-twitter"></a>
          <a href="#" class="bi bi-facebook"></a>
          <a href="#" class="bi bi-instagram"></a>
          <a href="#" class="bi bi-linkedin"></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Enlaces Útiles</h4>
        <ul>
          <li><a href="#">Inicio</a></li>
          <li><a href="#">Nosotros</a></li>
          <li><a href="#">Servicios</a></li>
          <li><a href="#">Términos de servicio</a></li>
          <li><a href="#">Política de privacidad</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Nuestros Servicios</h4>
        <ul>
          <li><a href="#">Diseño 3D</a></li>
          <li><a href="#">Impresión 3D</a></li>
          <li><a href="#">Prototipado Rápido</a></li>
          <li><a href="#">Consultoría</a></li>
          <li><a href="#">Soporte Técnico</a></li>
        </ul>
      </div>

      <div class="col-lg-4 col-md-12 footer-newsletter">
        <h4>Suscríbete a Nuestro Boletín</h4>
        <p>Recibe las últimas novedades y ofertas exclusivas directamente en tu bandeja de entrada.</p>
        <form action="#" method="post">
          <div class="input-group">
            <input type="email" class="form-control" name="email" placeholder="Tu correo electrónico" required>
            <button class="btn btn-primary" type="submit">Suscribirse</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="container text-center mt-4">
    <p>© <strong>3DPrintShop</strong> Todos los Derechos Reservados</p>
  </div>
</footer>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Bootstrap JS -->
  <script src="<?php echo base_url('assets_cliente/js/bootstrap.bundle.min.js'); ?>"></script>

  <!-- Main JS File -->
  <script src="<?php echo base_url('assets_cliente/js/main.js'); ?>"></script>

  <!-- AOS JS -->
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.1/dist/aos.js"></script>

  <!-- Inicializar AOS -->
  <script>
    AOS.init({
      duration: 1700, // Duración de la animación en milisegundos
      once: true, // La animación solo se ejecutará una vez al desplazarse
    });
  </script>

</div>
</body>
</html>
