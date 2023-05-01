<?php

/**
 * Create HTML list of nav menu items.
 * Replacement for the native Walker.
 *
 */
class IdtChildMenuWalkerExample extends Walker_Nav_Menu
{
    /**
     * Start the element output.
     *
     * @param  string $output Passed by reference. Used to append additional content.
     * @param  object $item Menu item data object.
     * @param  int $depth Depth of menu item. May be used for padding.
     * @param  array|object $args Additional strings. Actually always an instance of stdClass. But this is WordPress.
     * @return void
     */
    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        if (class_exists('ACF')) {
            $itemType = get_field('itemType', $item);
            $itemSize = get_field('itemSize', $item);
            $itemIcon = get_field('itemIcon', $item);
            $itemImage = get_field('itemImage', $item);

            if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
                $t = '';
                $n = '';
            } else {
                $t = "\t";
                $n = "\n";
            }

            $indent = ($depth) ? str_repeat($t, $depth) : '';

            $classes = empty($item->classes) ? [] : (array)$item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            $classes[] = 'idt-mega-menu__item';

            if (isset($itemType) && $itemType != '') {
                switch ($itemType) {
                    case 'sub-menu':
                        $classes[] = '';
                        break;
                    case 'item-style-1':
                        $classes[] = 'idt-mega-menu__item--style-1';
                        break;
                    case 'item-style-2':
                        $classes[] = 'idt-mega-menu__item--style-2';
                        break;
                    case 'item-style-3':
                        $classes[] = 'idt-mega-menu__item--style-3';
                        break;
                    case 'item-style-4':
                        $classes[] = 'idt-mega-menu__item--style-4';
                        break;
                    default:
                        break;
                }
            }

            if (isset($itemSize) && $itemSize != '') {
                $classes[] = $itemSize;
            }



//        / ** * Filtra los argumentos de un solo elemento del menú de navegación. * * @since 4.4.0 * * @param stdClass $ args Un objeto de argumentos wp_nav_menu (). * @param WP_Post $ item Objeto de datos de elemento de menú. * @param int $ depth Profundidad del elemento del menú. Utilizado para acolchado. * /
            $args = apply_filters('nav_menu_item_args', $args, $item, $depth);

//		/ ** * Filtra las clases CSS aplicadas al elemento del elemento de la lista de un elemento del menú. * * @since 3.0.0 * @since 4.1.0 Se agregó el parámetro `$ depth`. * * @param string [] $ classes Matriz de las clases CSS que se aplican al elemento `<li>` del elemento del menú. * @param WP_Post $ item El elemento de menú actual. * @param stdClass $ args Un objeto de argumentos wp_nav_menu (). * @param int $ depth Profundidad del elemento del menú. Utilizado para acolchado. * /
            $classNames = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            $classNames = $classNames ? ' class="' . esc_attr($classNames) . '"' : '';

//		/ ** * Filtra el ID aplicado al elemento de la lista de un elemento del menú. * * @since 3.0.1 * @since 4.1.0 Se agregó el parámetro `$ depth`. * * @param string $ menu_id El ID que se aplica al elemento `<li>` del elemento del menú. * @param WP_Post $ item El elemento de menú actual. * @param stdClass $ args Un objeto de argumentos wp_nav_menu (). * @param int $ depth Profundidad del elemento del menú. Utilizado para acolchado. * /
            $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';

            $output .= $indent . '<li' . $id . $classNames . '>';

            $atts = [];
            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            if ('_blank' === $item->target && empty($item->xfn)) {
                $atts['rel'] = 'noopener';
            } else {
                $atts['rel'] = $item->xfn;
            }
            $atts['href'] = !empty($item->url) ? $item->url : '';
            $atts['aria-current'] = $item->current ? 'page' : '';

//		/ ** * Filtra los atributos HTML aplicados al elemento de anclaje de un elemento de menú. * * @since 3.6.0 * @since 4.1.0 Se agregó el parámetro `$ depth`. * * @param array $ atts {* Los atributos HTML aplicados al elemento `<a>` del elemento del menú, las cadenas vacías se ignoran. * * @type string $ title Atributo de título. * @type string $ target Atributo de destino. * @type string $ rel El atributo rel. * @type string $ href El atributo href. * @type string $ aria-current El atributo aria-current. *} * @param WP_Post $ item El elemento actual del menú. * @paramstdClass $ args Un objeto de argumentos wp_nav_menu (). * @param int $ depth Profundidad del elemento del menú. Utilizado para acolchado. * /
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (is_scalar($value) && '' !== $value && false !== $value) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

//		/ ** Este filtro está documentado en wp-includes / post-template.php * /
            $title = apply_filters('the_title', $item->title, $item->ID);

//		/ ** * Filtra el título de un elemento de menú. * * @since 4.4.0 * * @param string $ title El título del elemento del menú. * @param WP_Post $ item El elemento de menú actual. * @param stdClass $ args Un objeto de argumentos wp_nav_menu (). * @param int $ depth Profundidad del elemento del menú. Utilizado para acolchado. * /
            $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

            $menuItem  = $args->before;

            switch ($itemType) {
                case 'item-style-2':
                    $menuItem .= '<a' . $attributes . ' class="row">';

                    if (isset($itemIcon) && !empty($itemIcon)) {
                        $menuItem .= '<span class="col-3">';
                        $menuItem .= '<img class="idt-mega-menu__item-icon" ';
                        $menuItem .= 'src="' . $itemIcon['url'] .'" ';
                        $menuItem .= 'alt="' . $itemIcon['alt'] .'" ';
                        $menuItem .= 'width="35" ';
                        $menuItem .= 'height="35" ';
                        $menuItem .= 'loading="lazy" ';
                        $menuItem .= '>';
                        $menuItem .= '</span>';
                    }

                    $menuItem .= '<span class="col-9">';
                    $menuItem .= $args->link_before . $title . $args->link_after;
                    $menuItem .= '</span>';
                    $menuItem .= '</a>';
                    break;
                case 'item-style-3':
                    $menuItem .= '<a' . $attributes . ' class="row">';

                    if (isset($itemIcon) && !empty($itemIcon)) {
                        $menuItem .= '<span class="col-3 idt-mega-menu__item-icon-container">';
                        $menuItem .= '<img class="idt-mega-menu__item-icon" ';
                        $menuItem .= 'src="' . $itemIcon['url'] .'" ';
                        $menuItem .= 'alt="' . $itemIcon['alt'] .'" ';
                        $menuItem .= 'width="48" ';
                        $menuItem .= 'height="48" ';
                        $menuItem .= 'loading="lazy" ';
                        $menuItem .= '>';
                        $menuItem .= '</span>';
                    }

                    $menuItem .= '<span class="col-9">';
                    $menuItem .= '<span class="idt-mega-menu__item-title">';
                    $menuItem .= $args->link_before . $title . $args->link_after;
                    $menuItem .= '</span>';

                    if (isset($item->description) && $item->description != '') {
                        $menuItem .= '<span class="idt-mega-menu__item-description">';
                        $menuItem .= $item->description;
                        $menuItem .= '</span>';
                    }

                    $menuItem .= '</span>';
                    $menuItem .= '</a>';
                    break;
                case 'item-style-4':
                    if (isset($itemIcon) && !empty($itemImage)) {
                        $menuItem .= '<span class="idt-mega-menu__item-image-container">';
                        $menuItem .= '<img class="idt-mega-menu__item-image" ';
                        $menuItem .= 'src="' . $itemImage['url'] .'" ';
                        $menuItem .= 'alt="' . $itemImage['alt'] .'" ';
                        $menuItem .= 'width="' . $itemImage['sizes']['medium-width'] . '" ';
                        $menuItem .= 'height="' . $itemImage['sizes']['medium-height'] . '" ';
                        $menuItem .= 'loading="lazy" ';
                        $menuItem .= '>';
                        $menuItem .= '</span>';
                    }
                    break;
                default:
                    $menuItem .= '<a' . $attributes . '>';
                    $menuItem .= $args->link_before . $title . $args->link_after;
                    $menuItem .= '</a>';
                    break;
            }

            $menuItem .= $args->after;

            $output .= apply_filters('walker_nav_menu_start_el', $menuItem, $item, $depth, $args);
        }
    }
}