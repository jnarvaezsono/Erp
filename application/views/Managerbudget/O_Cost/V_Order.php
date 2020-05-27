<style>
    .td-estado{
        padding: 0 !important;
        vertical-align: middle !important;
    }
</style>
<div class="content-wrapper">
    <section class="content">
        <?php if($table == 2): ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Ordenes Por Cobrar</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?=$nReceivable?>
                    </div>
                </div>
            </div>
        </div>
        <?php elseif($table == 1): ?>
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-fw fa-table"></i> Ordenes Cobradas</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?=$nPaid?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </section>
</div>
<script>
    $(document).ready(function () {
        Cargar_Tabla('table1');
        Cargar_Tabla('table2');
    });

    function Cargar_Tabla(id) {

        var oTable = $('#'+id).dataTable({
            "processing": true,
            "order": [[ 1, "desc" ]],
            "pageLength": 50,
            "scrollY": "380px",
            "lengthChange": false,
            "searching": false,
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });

    }
    
    function OpenPrint(id,url){
        window.open('http://10.16.0.94/MEDIOS/views/'+url+id);
    }
</script>
