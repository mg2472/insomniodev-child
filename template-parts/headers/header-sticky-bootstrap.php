<?php

if (!defined('ABSPATH')) exit; //Exit if accessed directly.

/**
 * Header template part
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage InsomnioDev
 * @since 1.0
 * @version 1.0
 */
?>
<div class="idt-menu-mobile-layout idt-header-sticky" id="idt-header-1">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-4">
                <section class="idt-section idt-header-logo">
                    <div class="idt-section-wrap">
                        <?php get_template_part('template-parts/logos/logo', 'default'); ?>
                    </div>
                </section>
            </div>
            <div class="col-8 idt-display-flex">
                <section class="idt-section idt-mobile-menu">
                    <div class="idt-section-wrap">
                        <?php get_template_part('template-parts/menus/mobile/mobile-menu', 'trigger'); ?>
                    </div>
                </section>
            </div>
        </div>
        <?php get_template_part('template-parts/menus/mobile/mobile-menu', 'bootstrap'); ?>
    </div>
</div>