<!-- SweetAlert2 JS -->
<script src="<?= base_url('assets_admin/sweetalert2/sweetalert2.min.js'); ?>"></script>

<?php if ($this->session->flashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '<?php echo $this->session->flashdata('success'); ?>'
    });
</script>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '<?php echo $this->session->flashdata('error'); ?>'
    });
</script>
<?php endif; ?>

<!-- application/views/admin/template/footer.php -->
<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>3DPrintShop</span></strong>. Todos los Derechos Reservados
  </div>
  <div class="credits">
    Diseñado por <a href="https://bootstrapmade.com/">BootstrapMade</a>
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?php echo base_url('assets_admin/vendor/apexcharts/apexcharts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_admin/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_admin/vendor/chart.js/chart.umd.js'); ?>"></script>
<script src="<?php echo base_url('assets_admin/vendor/echarts/echarts.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_admin/vendor/quill/quill.js'); ?>"></script>
<script src="<?php echo base_url('assets_admin/vendor/simple-datatables/simple-datatables.js'); ?>"></script>
<script src="<?php echo base_url('assets_admin/vendor/tinymce/tinymce.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_admin/vendor/php-email-form/validate.js'); ?>"></script>

<!-- Custom JS Files -->
<script src="<?= base_url('assets_admin/js/validaciones_usuario.js'); ?>"></script>

<!-- Template Main JS File -->
<script src="<?php echo base_url('assets_admin/js/main.js'); ?>"></script>

</body>
</html>
