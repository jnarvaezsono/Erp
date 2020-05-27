<style>
    .table-striped{
        margin-bottom: 18px !important;
    }
    .btn-box-tool{margin-left: 40px;}
    .box.box-primary { border-top-color: #5f5aa6; }
</style>
<?php
foreach ($listButton as $modulo => $sub) :?>
        <div class="box box-primary collapsed-box">
            <div class="box-header with-border" style="text-align: left;">
                <h3 class="box-title"><?=$modulo?></h3>
                
                <div class="box-tools pull-right">
                    
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
            </div>
            
            <div class="box-body">
                <?php foreach ($sub as $ch) : ?>
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td><?=$ch['name']?></td>
                                <td style="text-align: right;"><input   class="minimal-red pull-right" id="ch-<?=$ch['id_button']?>" type="checkbox" value="" name=""></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>
        </div>
        <?php

endforeach;
?>