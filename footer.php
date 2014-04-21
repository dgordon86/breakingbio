
<?php
$footer_infor = KopaOptions::get_option('copyright');
if ($footer_infor):
    ?>
    <footer id="kp-page-footer" class="text-center">
        <div class="kopa-copyright"><?php echo $footer_infor; ?></div>
    </footer>
<?php endif; ?>

</div>
<p id="back-top"><a href="#top"><i class="kpf-arrow-up"></i></a></p>    
        <?php wp_footer(); ?>
</body>
</html>