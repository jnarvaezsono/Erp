<div class="content-wrapper">
    <section class="content-header">
        <h1>Permisos
            <small>Menu</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-10 bhoechie-tab-container">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                        <div class="list-group">
                            <?php foreach ($roles as $r) : ?>
                                <a href="#" class="list-group-item  text-center" id="<?= $r->id_roles ?>" name="<?= $r->description ?>">
                                    <h4 class="glyphicon glyphicon-user"></h4><br/><?= $r->description ?>
                                </a>
                            <?php endforeach;
                            ?>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">

                        <div class="bhoechie-tab-content " id="div-<?= $r->id_roles ?>">
                            <center>
                                <h3 style="margin-top: 0;color:#55518a" id="title"></h3> <br />

                                <?=$tabmenus?>
                            </center>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        $('input[type="checkbox"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
        });
        
        $("div.bhoechie-tab-menu>div.list-group>a").click(function (e) {
            $('html, body').animate({scrollTop:0}, 1250);
            loadRolMenus($(this).attr('id'));
            e.preventDefault();
            $(this).siblings('a.active').removeClass("active");
            $(this).addClass("active");
            $('#title').html('<i class="fa fa-user"></i> ' + $(this).attr('name'));
//            var index = $(this).index();
//            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
//            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
            $(".bhoechie-tab-content").addClass("active");
        });
    });

    function loadRolMenus(rol) {
        $('.minimal-red').iCheck('destroy');
        $('.minimal-red').prop('checked',false);
    
        $.post('<?= base_url() ?>Parameters/Security/C_Security/loadRolMenus', {rol: rol}, function (data) {
            $.each(data.res,function(e,i){
                $('#ch-'+i.id_menu).prop('checked',true);
            });
            
            $('.minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
            }).on('ifChecked', function (event) {
                changePermissions(rol,'add',$(this).attr("id").substring(3));
            }).on('ifUnchecked', function (event) {
                changePermissions(rol,'remove',$(this).attr("id").substring(3));
            });
            
        }, 'json');
    }
    
    function changePermissions(rol,option,menu){
        $.post('<?= base_url() ?>Parameters/Security/C_Security/changePermissions', {rol: rol,option:option,menu:menu}, function (data) {
            if(data > 0){
                alertify.success('OK');
            }
        });
    }
</script>