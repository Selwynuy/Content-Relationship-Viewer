<?php
class Related_Posts_Carousel_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'related_posts_carousel';
    }

    public function get_title() {
        return __('Related Posts Carousel', 'college-department');
    }

    public function get_icon() {
        return 'eicon-carousel';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_script_depends() {
        return ['slick-carousel', 'related-posts-carousel'];
    }

    public function get_style_depends() {
        return ['slick-carousel', 'slick-carousel-theme', 'related-posts-carousel'];
    }

    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'college-department'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'relationship_field',
            [
                'label' => __('ACF Relationship Field', 'college-department'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_acf_relationship_fields(),
                'description' => __('Select the ACF relationship field', 'college-department'),
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __('Show Title', 'college-department'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'title_alignment',
            [
                'label' => __('Title Alignment', 'college-department'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'college-department'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'college-department'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'college-department'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .carousel-item h3' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => __('Show Excerpt', 'college-department'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_acf_fields',
            [
                'label' => __('Show ACF Fields', 'college-department'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        // Add Virtual Tour and Prospectus controls
        $this->add_control(
            'virtual_tour_field',
            [
                'label' => __('Virtual Tour Field', 'college-department'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_all_acf_fields(),
                'description' => __('Select the ACF relationship field for Virtual Tour', 'college-department'),
            ]
        );

        $this->add_control(
            'prospectus_field',
            [
                'label' => __('Prospectus Field', 'college-department'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_all_acf_fields(),
                'description' => __('Select the ACF field for Prospectus (File or URL)', 'college-department'),
            ]
        );

        $this->add_control(
            'button_style',
            [
                'label' => __('Button Style', 'college-department'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'college-department'),
                    'outline' => __('Outline', 'college-department'),
                    'flat' => __('Flat', 'college-department'),
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'field_name',
            [
                'label' => __('Field', 'college-department'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => array_merge(
                    ['post_title' => __('Post Title', 'college-department')],
                    $this->get_all_acf_fields()
                ),
            ]
        );

        $repeater->add_control(
            'field_label',
            [
                'label' => __('Custom Label', 'college-department'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Leave empty to use field label', 'college-department'),
            ]
        );

        // Style controls for each field
        $repeater->add_control(
            'field_text_color',
            [
                'label' => __('Text Color', 'college-department'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .field-value' => 'color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_control(
            'field_bg_color',
            [
                'label' => __('Background Color', 'college-department'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .field-value' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $repeater->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'field_typography',
                'selector' => '{{WRAPPER}} {{CURRENT_ITEM}} .field-value',
            ]
        );

        $repeater->add_control(
            'field_alignment',
            [
                'label' => __('Alignment', 'college-department'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'college-department'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'college-department'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'college-department'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'field_image_width',
            [
                'label' => __('Image Width (px)', 'college-department'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 1000,
                'step' => 1,
                'default' => 120,
                'condition' => [
                    'field_name!' => '',
                ],
            ]
        );
        $repeater->add_control(
            'field_image_height',
            [
                'label' => __('Image Height (px)', 'college-department'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 10,
                'max' => 1000,
                'step' => 1,
                'default' => '',
                'condition' => [
                    'field_name!' => '',
                ],
            ]
        );
        $repeater->add_control(
            'field_image_object_fit',
            [
                'label' => __('Image Object Fit', 'college-department'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'cover' => __('Cover', 'college-department'),
                    'contain' => __('Contain', 'college-department'),
                    'fill' => __('Fill', 'college-department'),
                    'none' => __('None', 'college-department'),
                    'scale-down' => __('Scale Down', 'college-department'),
                ],
                'default' => 'cover',
                'condition' => [
                    'field_name!' => '',
                ],
            ]
        );

        $repeater->add_control(
            'display_location',
            [
                'label' => __('Display Location', 'college-department'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'inside' => __('Inside Card', 'college-department'),
                    'outside' => __('Outside Card', 'college-department'),
                    'both' => __('Both', 'college-department'),
                ],
                'default' => 'inside',
            ]
        );

        $this->add_control(
            'selected_fields',
            [
                'label' => __('Fields to Display', 'college-department'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [],
                'title_field' => '{{{ field_name }}}',
                'condition' => [
                    'show_acf_fields' => 'yes',
                ],
            ]
        );

        // Background ACF field control
        $this->add_control(
            'background_acf_field',
            [
                'label' => __('Background ACF Field', 'college-department'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $this->get_all_acf_fields(),
                'default' => '',
                'description' => __('Select an ACF image field from the related posts to use as the background for each slide.', 'college-department'),
            ]
        );

        $this->end_controls_section();

        // Carousel Settings
        $this->start_controls_section(
            'carousel_settings',
            [
                'label' => __('Carousel Settings', 'college-department'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'slides_to_show',
            [
                'label' => __('Slides to Show', 'college-department'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3,
                'min' => 1,
                'max' => 10,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __('Autoplay', 'college-department'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => __('Autoplay Speed', 'college-department'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style', 'college-department'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background',
            [
                'label' => __('Card Background', 'college-department'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .carousel-item' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'college-department'),
                'selector' => '{{WRAPPER}} .carousel-item h3',
            ]
        );

        $this->end_controls_section();

        // Active Slide Style Section
        $this->start_controls_section(
            'section_active_slide',
            [
                'label' => esc_html__('Active Slide', 'college-department'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'active_slide_background',
                'label' => esc_html__('Background', 'college-department'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .swiper-slide.is-active',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'active_slide_border',
                'label' => esc_html__('Border', 'college-department'),
                'selector' => '{{WRAPPER}} .swiper-slide.is-active',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'active_slide_box_shadow',
                'label' => esc_html__('Box Shadow', 'college-department'),
                'selector' => '{{WRAPPER}} .swiper-slide.is-active',
            ]
        );

        $this->add_control(
            'active_slide_scale',
            [
                'label' => esc_html__('Scale', 'college-department'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1.5,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1.05,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide.is-active' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->add_control(
            'active_slide_transition',
            [
                'label' => esc_html__('Transition Duration', 'college-department'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-slide' => 'transition: all {{SIZE}}{{UNIT}} ease-in-out;',
                ],
            ]
        );

        $this->end_controls_section();

        // Outside Fields Style Section
        $this->start_controls_section(
            'outside_fields_style_section',
            [
                'label' => __('Outside Fields', 'college-department'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'outside_fields_alignment',
            [
                'label' => __('Alignment', 'college-department'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'college-department'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'college-department'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'college-department'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .acf-fields-outside-card' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'outside_fields_typography',
                'label' => __('Typography', 'college-department'),
                'selector' => '{{WRAPPER}} .acf-fields-outside-card, {{WRAPPER}} .acf-fields-outside-card .field-outside',
            ]
        );

        $this->add_control(
            'outside_fields_text_color',
            [
                'label' => __('Text Color', 'college-department'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-fields-outside-card, {{WRAPPER}} .acf-fields-outside-card .field-outside' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'outside_fields_bg_color',
            [
                'label' => __('Background Color', 'college-department'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .acf-fields-outside-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        if (empty($settings['relationship_field'])) {
            return;
        }

        $related_posts = get_field($settings['relationship_field']);
        
        if (!$related_posts) {
            return;
        }

        $carousel_settings = [
            'slidesToShow' => $settings['slides_to_show'],
            'autoplay' => $settings['autoplay'] === 'yes',
            'autoplaySpeed' => $settings['autoplay_speed'],
        ];
        ?>
        <div class="swiper related-posts-carousel" data-settings='<?php echo esc_attr(json_encode($carousel_settings)); ?>'>
            <div class="swiper-wrapper">
            <?php 
            $outside_fields_data = [];
            foreach ($related_posts as $index => $post): 
                $post_id = is_object($post) ? $post->ID : $post;
                $bg_url = '';
                if (!empty($settings['background_acf_field'])) {
                    $bg_field = get_field_object($settings['background_acf_field'], $post_id);
                    if ($bg_field) {
                        $bg_value = $bg_field['value'];
                        if ($bg_field['type'] === 'image') {
                            if (is_array($bg_value) && isset($bg_value['url'])) {
                                $bg_url = $bg_value['url'];
                            } elseif (is_string($bg_value)) {
                                $bg_url = $bg_value;
                            }
                        } elseif ($bg_field['type'] === 'url' && is_string($bg_value)) {
                            $bg_url = $bg_value;
                        }
                    }
                }
                // Debug output
                if (current_user_can('administrator')) {
                    echo '<!-- Debug: Post ID: ' . esc_html($post_id) . ' -->';
                    echo '<!-- Debug: BG URL: ' . esc_html($bg_url) . ' -->';
                }
                ?>
                <div class="swiper-slide"<?php if ($bg_url) echo ' data-bg="' . esc_url($bg_url) . '"'; ?>>
                  <div class="carousel-item">
                    <?php if ($settings['show_title'] === 'yes'): ?>
                        <h3><?php echo get_the_title($post_id); ?></h3>
                    <?php endif; ?>

                    <?php if ($settings['show_excerpt'] === 'yes'): ?>
                        <div class="excerpt">
                            <?php echo get_the_excerpt($post_id); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($settings['show_acf_fields'] === 'yes' && !empty($settings['selected_fields'])): ?>
                        <div class="acf-fields">
                            <?php foreach ($settings['selected_fields'] as $field): 
                                if (!isset($field['display_location']) || in_array($field['display_location'], ['inside', 'both'])) {
                                $field_obj = get_field_object($field['field_name'], $post_id);
                                $value = $field_obj['value'];
                                if (!$value) continue;
                                $label = $field['field_label'] ?: $field_obj['label'];
                                $style = '';
                                if (!empty($field['field_text_color'])) $style .= 'color:' . esc_attr($field['field_text_color']) . ';';
                                if (!empty($field['field_bg_color'])) $style .= 'background-color:' . esc_attr($field['field_bg_color']) . ';';
                                $img_style = '';
                                if ($field_obj['type'] === 'image') {
                                    if (!empty($field['field_image_width'])) $img_style .= 'width:' . intval($field['field_image_width']) . 'px;';
                                    if (!empty($field['field_image_height'])) $img_style .= 'height:' . intval($field['field_image_height']) . 'px;';
                                    if (!empty($field['field_image_object_fit'])) $img_style .= 'object-fit:' . esc_attr($field['field_image_object_fit']) . ';';
                                }
                                echo '<div class="field elementor-repeater-item-' . esc_attr($field['_id']) . '" style="' . esc_attr($style) . '">';
                                switch ($field_obj['type']) {
                                    case 'image':
                                        if (is_array($value) && isset($value['url'])) {
                                            echo '<img src="' . esc_url($value['url']) . '" alt="' . esc_attr($value['alt'] ?? $label) . '" style="max-width:100%;height:auto;' . esc_attr($img_style) . '" />';
                                        } elseif (is_string($value)) {
                                            echo '<img src="' . esc_url($value) . '" alt="' . esc_attr($label) . '" style="max-width:100%;height:auto;' . esc_attr($img_style) . '" />';
                                        }
                                        break;
                                    case 'url':
                                        echo '<a href="' . esc_url($value) . '" target="_blank" rel="noopener">' . esc_html($value) . '</a>';
                                        break;
                                    case 'file':
                                        if (is_array($value) && isset($value['url'])) {
                                            echo '<a href="' . esc_url($value['url']) . '" target="_blank" rel="noopener">' . esc_html($value['filename'] ?? $label) . '</a>';
                                        } elseif (is_string($value)) {
                                            echo '<a href="' . esc_url($value) . '" target="_blank" rel="noopener">' . esc_html($value) . '</a>';
                                        }
                                        break;
                                    case 'email':
                                        echo '<a href="mailto:' . esc_attr($value) . '">' . esc_html($value) . '</a>';
                                        break;
                                    case 'textarea':
                                    case 'text':
                                    case 'number':
                                    case 'select':
                                    case 'radio':
                                    case 'true_false':
                                    case 'checkbox':
                                        if (is_array($value)) {
                                            echo esc_html(implode(', ', $value));
                                        } else {
                                            echo esc_html($value);
                                        }
                                        break;
                                    default:
                                        if (is_array($value)) {
                                            echo esc_html(json_encode($value));
                                        } else {
                                            echo esc_html($value);
                                        }
                                        break;
                                }
                                echo '</div>';
                                }
                            endforeach; ?>
                        </div>
                    <?php endif; ?>
                  </div>
                </div>
                <?php
                // Collect outside fields/buttons data for JS
                $fields_html = '';
                if ($settings['show_acf_fields'] === 'yes' && !empty($settings['selected_fields'])) {
                    $fields_html .= '<div class="acf-fields-outside-card">';
                    foreach ($settings['selected_fields'] as $field) {
                        if (!isset($field['display_location']) || !in_array($field['display_location'], ['outside', 'both'])) continue;
                        if ($field['field_name'] === 'post_title') {
                            $fields_html .= '<div class="field-outside elementor-repeater-item-' . esc_attr($field['_id']) . '"><span class="field-value">' . esc_html(get_the_title($post_id)) . '</span></div>';
                            continue;
                        }
                        $field_obj = get_field_object($field['field_name'], $post_id);
                        if (!$field_obj) continue;
                        $value = $field_obj['value'];
                        if (!$value) continue;
                        $style = '';
                        if (!empty($field['field_text_color'])) $style .= 'color:' . esc_attr($field['field_text_color']) . ';';
                        if (!empty($field['field_bg_color'])) $style .= 'background-color:' . esc_attr($field['field_bg_color']) . ';';
                        $img_style = '';
                        if ($field_obj['type'] === 'image') {
                            if (!empty($field['field_image_width'])) $img_style .= 'width:' . intval($field['field_image_width']) . 'px;';
                            if (!empty($field['field_image_height'])) $img_style .= 'height:' . intval($field['field_image_height']) . 'px;';
                            if (!empty($field['field_image_object_fit'])) $img_style .= 'object-fit:' . esc_attr($field['field_image_object_fit']) . ';';
                        }
                        $fields_html .= '<div class="field-outside elementor-repeater-item-' . esc_attr($field['_id']) . '" style="' . esc_attr($style) . '">';
                        switch ($field_obj['type']) {
                            case 'image':
                                if (is_array($value) && isset($value['url'])) {
                                    $fields_html .= '<img class="field-value" src="' . esc_url($value['url']) . '" alt="" style="max-width:100%;height:auto;' . esc_attr($img_style) . '" />';
                                } elseif (is_string($value)) {
                                    $fields_html .= '<img class="field-value" src="' . esc_url($value) . '" alt="" style="max-width:100%;height:auto;' . esc_attr($img_style) . '" />';
                                }
                                break;
                            case 'url':
                                $fields_html .= '<a class="field-value" href="' . esc_url($value) . '" target="_blank" rel="noopener">' . esc_html($value) . '</a>';
                                break;
                            case 'file':
                                if (is_array($value) && isset($value['url'])) {
                                    $fields_html .= '<a class="field-value" href="' . esc_url($value['url']) . '" target="_blank" rel="noopener">' . esc_html($value['filename'] ?? basename($value['url'])) . '</a>';
                                } elseif (is_string($value)) {
                                    $fields_html .= '<a class="field-value" href="' . esc_url($value) . '" target="_blank" rel="noopener">' . esc_html(basename($value)) . '</a>';
                                }
                                break;
                            case 'email':
                                $fields_html .= '<a class="field-value" href="mailto:' . esc_attr($value) . '">' . esc_html($value) . '</a>';
                                break;
                            case 'textarea':
                            case 'text':
                            case 'number':
                            case 'select':
                            case 'radio':
                            case 'true_false':
                            case 'checkbox':
                                if (is_array($value)) {
                                    $fields_html .= '<span class="field-value">' . esc_html(implode(', ', $value)) . '</span>';
                                } else {
                                    $fields_html .= '<span class="field-value">' . esc_html($value) . '</span>';
                                }
                                break;
                            default:
                                if (is_array($value)) {
                                    $fields_html .= '<span class="field-value">' . esc_html(json_encode($value)) . '</span>';
                                } else {
                                    $fields_html .= '<span class="field-value">' . esc_html($value) . '</span>';
                                }
                                break;
                        }
                        $fields_html .= '</div>';
                    }
                    $fields_html .= '</div>';
                }
                // Add Virtual Tour and Prospectus buttons
                $buttons_html = '';
                if (!empty($settings['virtual_tour_field']) || !empty($settings['prospectus_field'])) {
                    $buttons_html .= '<div class="department-buttons ' . esc_attr($settings['button_style']) . '">';
                    // Virtual Tour Button
                    if (!empty($settings['virtual_tour_field'])) {
                        $virtual_tour = get_field($settings['virtual_tour_field'], $post_id);
                        if ($virtual_tour) {
                            $tour_url = get_permalink($virtual_tour);
                            $buttons_html .= '<a href="' . esc_url($tour_url) . '" class="virtual-tour-btn" target="_blank">' . __('Virtual Tour', 'college-department') . '</a>';
                        }
                    }
                    // Prospectus Button
                    if (!empty($settings['prospectus_field'])) {
                        $prospectus = get_field($settings['prospectus_field'], $post_id);
                        if ($prospectus) {
                            $prospectus_url = is_array($prospectus) ? $prospectus['url'] : $prospectus;
                            $buttons_html .= '<a href="' . esc_url($prospectus_url) . '" class="prospectus-btn" target="_blank">' . __('Prospectus', 'college-department') . '</a>';
                        }
                    }
                    $buttons_html .= '</div>';
                }
                $outside_fields_data[] = [
                    'fields_html' => $fields_html,
                    'buttons_html' => $buttons_html
                ];
            endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <div id="carousel-outside-fields"></div>
        <script>
        window.collegeDeptCarouselOutsideFields = <?php echo json_encode($outside_fields_data); ?>;
        </script>
        <?php
    }

    private function get_acf_relationship_fields() {
        $fields = [];
        
        if (function_exists('acf_get_field_groups')) {
            $field_groups = acf_get_field_groups();
            
            foreach ($field_groups as $group) {
                $group_fields = acf_get_fields($group);
                
                if ($group_fields) {
                    foreach ($group_fields as $field) {
                        if ($field['type'] === 'relationship') {
                            $fields[$field['name']] = $field['label'];
                        }
                    }
                }
            }
        }
        
        return $fields;
    }

    private function get_all_acf_fields() {
        $fields = [];
        
        if (function_exists('acf_get_field_groups')) {
            $field_groups = acf_get_field_groups();
            
            foreach ($field_groups as $group) {
                $group_fields = acf_get_fields($group);
                
                if ($group_fields) {
                    foreach ($group_fields as $field) {
                        if ($field['type'] !== 'relationship') { // Exclude relationship fields
                            $fields[$field['name']] = $field['label'];
                        }
                    }
                }
            }
        }
        
        return $fields;
    }
} 