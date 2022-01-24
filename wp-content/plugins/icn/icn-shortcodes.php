<?php

/**
 * Accordion Wrapper
 * @param $params
 * @param null $content
 * @return string
 */
function med_accordion_processor($params, $content = null)
{
    $code_arr = shortcode_atts( ['id' => '1'], $params, 'icn-accordion' );
    global $accordionId;
    $accordionId = "accordion_" . $code_arr['id'];

    $html = "<div id='$accordionId' class='icn-accordion' role='tablist' aria-multiselectable='true'>";
    $html .= do_shortcode($content);
    $html .= "</div>";

    unset($accordionId);

    return $html;
}

add_shortcode('icn-accordion','icn_accordion_processor');


/**
 * Accordion Item
 * @param $params
 * @param null $content
 * @return string
 */
function icn_accordion_title_processor($params, $content = null)
{
    $code_arr = shortcode_atts( ['title' => ''], $params, 'accordion-title' );
    global $accordionId;
    $html = \ICN\ShortCodeHTML::getAccordionPanelHtml($code_arr['title'], $content, $accordionId);
    return do_shortcode($html);
}

add_shortcode('accordion-item','icn_accordion_title_processor');
