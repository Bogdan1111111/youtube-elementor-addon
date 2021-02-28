<?php

use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;
use \Elementor\Utils;
use \Elementor\Repeater;

class Elementor_YouTube_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'youtube-elementor';
    }

    public function get_title()
    {
        return __('YouTube Oembeds');
    }

    public function get_icon()
    {
        return 'fa fa-youtube';
    }

    public function get_categories()
    {
        return ['basic'];
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes('title', 'advanced'); ?>
        <section>
            <h2 <?php echo $this->get_render_attribute_string('title') ?>>
                <?php echo $this->get_settings('title') ?>
            </h2>
            <div class="elementor-row  <?php echo esc_attr($settings['video_position']) ?>" data-id="<?php echo esc_attr($settings['video_id']) ?>">
                <div class="elementor-column frame-container">
                    <img src="<?php printf('https://img.youtube.com/vi/%s/hqdefault.jpg', esc_attr($settings['video_id'])) ?>" class="youtube-preview" alt="Video Preview">
                </div>
                <div class="elementor-column">
                    <?php foreach ($settings['timestams_repeater'] as $key => $value): ?>
                        <figure class="stamp">
                            <img src="<?php echo esc_url($value['stamp_image']['ur']) ?>" alt="Stamp Icon">
                            <span class="timestamp"><?php echo esc_html($value['time_stamp']) ?></span>
                            <span class="description"><?php echo esc_html($value['stamp_description']) ?></span>
                        </igure>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function _register_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Video'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Section Title'),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text'
            ]
        );

        $this->add_control(
            'video_id',
            [
                'label' => __('Video ID'),
                'type' => Controls_Manager::TEXT,
                'input_type' => 'text'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'timestamp_section',
            [
                'label' => __('TimeStamps'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'stamp_image',
            [
                'label' => __('Image'),
                'type' => Controls_Manager::MEDIA,
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'time_stamp',
            [
                'label' => __('Time Stamp'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => 'x:xx'
            ]
        );

        $repeater->add_control(
            'stamp_description',
            [
                'label' => __('Description'),
                'type' => Controls_Manager::WYSIWYG,
                'label_block' => true
            ]
        );

        $this->add_control(
            'timestams_repeater',
            [
                'label' => __('TimeStamps'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'stamp_image' => [
                            'url' => Utils::get_placeholder_image_src()
                        ],
                        'time_stamp' => '1:00',
                        'stamp_description'  => 'description'
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style_section',
            [
                'label' => __('Style'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'video_position',
            [
                'label' => __('Video position'),
                'type' => Controls_Manager::SELECT,
                'input_type' => 'string',
                'options' => [
                    'norm' => __('Left Column'),
                    'reverse' => __('Right  Column')
                ],
                'default' => 'norm'
            ]
        );

        $this->add_responsive_control(
            'timestamp_padding',
            [
                'label' => __('Timestamp Column Padding'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '.col-timestamp' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function _content_template()
    {
        ?>
    	<# view.addInlineEditingAttributes( 'title', 'advanced' ); #>
    	<div {{{ view.getRenderAttributeString( 'title' ) }}}>{{{ settings.title }}}</div>
    	<?php
    }
}
