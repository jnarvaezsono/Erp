
<footer class="main-footer">
    <div class="container">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.1
        </div>
        <strong>Copyright &copy; 2019 <a href="<?= base_url() ?>">Sonovista</a>.</strong> All rights
        reserved.
    </div>
    <!-- /.container -->
</footer>

<?= isset($sidebar_tabs) ? $sidebar_tabs : "" ?>

<div class="control-sidebar-bg"></div>
</div>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url() ?>dist/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?= base_url() ?>dist/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url() ?>dist/jquery-ui/jquery-ui.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>dist/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url() ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>dist/js/demo.js"></script>
<script src="<?= base_url() ?>dist/push/bin/push.min.js"></script>

<script src="<?= base_url() ?>dist/js/jquery.blockUI.js"></script>
<script src="<?= base_url()?>dist/autonumeric/autoNumeric-min.js"></script>
<?php
if (isset($array_js)):
    foreach ($array_js as $js):
        ?>
        <script src="<?= base_url() ?>dist/<?= $js ?>"></script>
        <?php
    endforeach;
endif;
?>
        
<?php
    if (isset($btn_datatable)):
        $array = unserialize($btn_datatable);
        foreach ($array as $ajs):
            ?>
            <script src="<?= base_url() ?>dist/<?= $ajs ?>"></script>
        <?php
        endforeach;
    endif;
?>        
<script>
    var url = "<?= base_url() ?>";
    $(document).ready(function () {
        $('.sidebar-menu').tree();

        $("#radioLayaut").change(function () {
            var valor = ($("#radioLayaut").is(":checked")) ? "layout-boxed" : "";
            var campo = "layout";
            UpdatePreferences(campo, valor, url);
        });

        $("#radioSidebar").change(function () {
            var valor = ($("#radioSidebar").is(":checked")) ? "sidebar-collapse" : "";
            var campo = "sidebar";
            UpdatePreferences(campo, valor, url);
        });

        $('.preferences').click(function () {
            var valor = $(this).attr("data-skin");
            var campo = "skin";
            UpdatePreferences(campo, valor, url);
        });
        //LoadNotifications('<?= base_url()?>');
        LoadNotifications('<?= base_url()?>');
        setInterval(function() {
            LoadNotifications('<?= base_url()?>');
        },300000);
        
        if(!Push.Permission.GRANTED){
            Push.Permission.request();
        }
        
        if(sessionStorage.getItem('push1') || sessionStorage.getItem('push2')){
            
        }else{
            sessionStorage.setItem('push1', 1);
            sessionStorage.setItem('push2', 1);
        }
        
        var dt = new Date();
        var hora = dt.getHours();
        text = '';
        if(hora >= 8 && hora <= 12 && sessionStorage.getItem('push1') == 1){
            var text = 'Recuerda lavar tus manos constantemente, así reduces hasta un 50% el riesgo de contagio covid19.';
            var img = '<?=base_url()?>dist/img/emo1.png';
            sessionStorage.setItem('push1', 2);
            sessionStorage.setItem('push2', 1);
        }else if(hora > 12 && hora <= 18 && sessionStorage.getItem('push2') == 1){
            var text = 'Evita el contacto físico, esto disminuye la probabilidad de contagiarse.';
            var img = '<?=base_url()?>dist/img/pausa.png';
            sessionStorage.setItem('push2', 2);
            sessionStorage.setItem('push1', 1);
        }
        
        if(text != ''){
            setTimeout(function(){
                Push.create("Quedate en casa, salva vidas!", {
                    body: text,
                    icon: img,
                    timeout: 100000,
                    onClick: function () {
                        window.focus();
                        this.close();
                    }
                });

            },'10000');
        }
    });

    function RedirectLogin() {
        location.href = "<?= base_url() ?>";
    }
    
</script>
</body>
<div class="overlay_ajax"><div class="loader_ajax loader_ajax2"></div><i class="loader_ajax fa fa-refresh fa-spin fa-2x"></i></div>
</html>