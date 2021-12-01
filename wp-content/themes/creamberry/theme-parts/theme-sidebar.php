<aside class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
    <div class="blog-sidebar default-sidebar">
        <?php if (is_active_sidebar('aside')) :
            ob_start();
        ?>
            <?php
            dynamic_sidebar('aside');
            ?>
        <?php
            echo ob_get_clean();
        endif;
        ?>
        
    </div>
</aside>
<script>
if(document.querySelector('input[type="submit"].search-submit') != null){
document.querySelector('input[type="submit"].search-submit').value = "🔍";
}
</script>