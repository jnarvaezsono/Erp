<style>
    .item{
        text-align: center;
        float: left;
        margin: 20px;
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-gears"></i> FORMATOS
            <small>sonovista</small>
        </h1>
    </section>
    <section class="content">
        <?php foreach ($rows as $v) : ?>
            <div class="item" onclick="goto(<?=$v->id_tipo?>)">
                <img src="<?=base_url().'dist/img/icon-image/form.png'?>" alt="user image" class="offline">
                <p><?=$v->descripcion?></p>
            </div>
        <?php endforeach; ?>
    </section>
</div>
<script>
    $(function () {

    });
    function goto(type){
        window.location = 'GetTableFormat/'+type;
    }
</script>