<form method="get" id="<?php echo "search-form-" . rand(0, 9999); ?>" class="search-form clearfix" action="<?php echo trailingslashit(home_url()); ?>">                            
    <input autocomplete="off" type="text" onBlur="if ('' === this.value)
                this.value = this.defaultValue;" onFocus="if (this.value === this.defaultValue)
                this.value = '';" value="<?php _e('Enter your keyword', kopa_get_domain()); ?>" name="s" class="search-text" maxlength="20">
    <button type="submit" class="search-submit"><i class="kpf-search"></i></button>
</form><!-- search-form -->