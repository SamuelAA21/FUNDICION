<!-- 1) jQuery (uno solo) -->
<script src="js/jquery-3.4.1.min.js"></script>

<!-- 2) Plugins que dependen de jQuery -->
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- 3) DataTables -->
<script src="js/datatables.min.js"></script>

<!-- 4) SweetAlert -->
<script src="js/sweet_alert.min.js"></script>

<!-- 5) Bootstrap (BS4) -->
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- Extra -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.8.1/baguetteBox.min.js"></script>

<!-- 6) Scripts del template -->
<script src="js/custom.js"></script>

<?php if (isset($_GET['module']) && $_GET['module'] === 'Cliente') { ?>
  <script src="js/cliente.js"></script>
<?php } ?>