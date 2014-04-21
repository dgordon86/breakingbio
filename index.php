<?php

$kopaCurrentSetting = KopaLayout::get_current_setting();
$kopaCurrentLayout = $kopaCurrentSetting['layout_slug'];
$kopaCurrentSidebars = $kopaCurrentSetting['sidebars'][$kopaCurrentLayout];

include_once trailingslashit(get_template_directory()) . "/layouts/{$kopaCurrentLayout}.php";