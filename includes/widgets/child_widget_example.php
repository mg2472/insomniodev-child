<?php

if (!defined('ABSPATH')) exit; //Exit if accessed directly.

/**
 * Widget that shown a list of custom posts type categories
 *
 * @package WordPress
 * @subpackage InsomnioDEV
 * @since 1.0
 * @version 1.0
 *
 */

class IDT_Child_Widget_Example extends WP_Widget
{

    /**
     * Register widget with WordPress.
     */
    function __construct() {
	    parent::__construct(
		    'idt-widget-cptc',  // Base ID
		    __('InsomnioDEV Custom post type categories list', 'insomniodev'),   // Name
            [] // Args
	    );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        extract($args);
        $categoriesArgs = [];

        if (isset($instance['order_by']) && $instance['order_by'] != '') {
            $categoriesArgs['orderby'] = $instance['order_by'];
        }
        if (isset($instance['order']) && $instance['order'] != '') {
            $categoriesArgs['order'] = $instance['order'];
        }
        if (isset($instance['taxonomy']) && $instance['taxonomy'] != '') {
            $categoriesArgs['taxonomy'] = $instance['taxonomy'];
        }

        $categories = get_categories($categoriesArgs);
        $cssClass = (isset($instance['css_class']) && $instance['css_class'] != '') ? $instance['css_class'] : '';
        $cssID = (isset($instance['css_id']) && $instance['css_id'] != '') ? $instance['css_id'] : '';
        ?>
        <section class="idt-widget <?php echo $cssClass;?>" id="<?php echo $cssID;?>">
            <?php if (isset($instance['title']) && $instance['title'] != '' ): ?>
                <h2 class="idt-widget-title">
                    <?php echo $instance['title']; ?>
                </h2>
            <?php endif; ?>
            <ul>
                <?php foreach ( $categories as $category ): ?>
                    <li class="cat-item cat-item-<?php echo $category->term_id;?>">
                        <a href="<?= get_term_link( $category->term_id ) ?>">
                            <?php echo $category->name; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $args = [
            'title' => (isset($instance['title'])) ? $instance['title'] : __('New title', 'insomniodev'),
            'css_class' => (isset($instance['css_class'])) ? $instance['css_class'] : '',
            'css_id' => (isset($instance['css_id'])) ? $instance['css_id'] : '',
            'taxonomy' => (isset($instance['taxonomy'])) ? $instance['taxonomy'] : 'category',
            'order_by' => (isset($instance['order_by'])) ? $instance['order_by'] : 'name',
            'order' => (isset($instance['order'])) ? $instance['order'] : 'ASC',
        ];
        $taxonomies = get_taxonomies();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php echo __('Title', 'insomniodev') . ':'; ?>
            </label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>"
                   type="text"
                   value="<?php echo esc_attr($args['title']);?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('taxonomy'); ?>">
                <?php echo __('Taxonomy', 'insomniodev') . ':'; ?>
            </label>
            <select class="widefat tags-input"
                    id="<?php echo $this->get_field_id('taxonomy'); ?>"
                    name="<?php echo $this->get_field_name('taxonomy' ); ?>">
                <option value=""><?php _e('Select a taxonomy', 'insomniodev'); ?></option>
                <?php foreach ($taxonomies as $taxonomy): ?>
                    <option value="<?php echo $taxonomy; ?>"
                        <?php echo ($taxonomy == $args['taxonomy']) ? 'selected' : ''; ?>>
                        <?php echo $taxonomy; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('order_by');?>">
                <?php echo __('Order by', 'insomniodev') . ':';?>
            </label>
            <select class="widefat tags-input"
                    id="<?php echo $this->get_field_id('order_by'); ?>"
                    name="<?php echo $this->get_field_name('order_by'); ?>">
                <option value=""><?php _e('Select a order by', 'insomniodev'); ?></option>
                <option value="name"
                    <?php echo (strtolower($args['order_by']) == 'name') ? 'selected' : ''; ?>>
                    <?php _e('Name', 'insomniodev');?>
                </option>
                <option value="id"
                    <?php echo (strtolower($args['order_by']) == 'id') ? 'selected' : ''; ?>>
                    <?php _e('ID', 'insomniodev');?>
                </option>
                <option value="slug"
                    <?php echo (strtolower($args['order_by']) == 'slug') ? 'selected' : ''; ?>>
                    <?php _e('Slug', 'insomniodev');?>
                </option>
                <option value="term_id"
                    <?php echo (strtolower($args['order_by']) == 'term_id') ? 'selected' : ''; ?>>
                    <?php _e('Term ID', 'insomniodev');?>
                </option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('order'); ?>">
                <?php echo __('Order', 'insomniodev') . ':'; ?>
            </label>
            <select class="widefat tags-input"
                    id="<?php echo $this->get_field_id('order'); ?>"
                    name="<?php echo $this->get_field_name('order' ); ?>">
                <option value=""><?php _e('Select a order', 'insomniodev'); ?></option>
                <option value="ASC"
                    <?php echo (strtolower($args['order']) == 'asc') ? 'selected' : ''; ?>>
                    <?php _e('Asc', 'insomniodev');?>
                </option>
                <option value="DESC"
                    <?php echo (strtolower($args['order']) == 'desc') ? 'selected' : ''; ?>>
                    <?php _e('Desc', 'insomniodev');?>
                </option>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('css_class'); ?>">
                <?php echo __('CSS Class', 'insomniodev') . ':'; ?>
            </label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id('css_class'); ?>"
                   name="<?php echo $this->get_field_name('css_class'); ?>"
                   type="text"
                   value="<?php echo esc_attr($args['css_class']); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('css_id'); ?>">
                <?php echo __('CSS ID', 'insomniodev') . ':'; ?>
            </label>
            <input class="widefat"
                   id="<?php echo $this->get_field_id('css_id'); ?>"
                   name="<?php echo $this->get_field_name('css_id'); ?>"
                   type="text"
                   value="<?php echo esc_attr($args['css_id']); ?>"/>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['taxonomy'] = strip_tags($new_instance['taxonomy']);
        $instance['order'] = strip_tags($new_instance['order']);
        $instance['order_by'] = strip_tags($new_instance['order_by']);
        $instance['css_class'] = strip_tags($new_instance['css_class']);
        $instance['css_id'] = strip_tags($new_instance['css_id']);

        return $instance;
    }
}
