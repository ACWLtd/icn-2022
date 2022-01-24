<?php

namespace ICN;

use Helpers\Str;

class Snippets
{
    /**
     * Get Breadcrumbs and Social Media Snippet
     * @param $breadcrumbs
     * @return string
     */
    static function getCrumbSocial($breadcrumbs)
    {
        $html = "";

        if ( strlen($breadcrumbs) ) {
            $html .= "\n\t\t<div class='row'>";
            $html .= "\n\t\t\t<div class='col-sm-12 col-md-6 breadcrumbs'>";
            $html .= "\n\t\t\t\t$breadcrumbs";
            $html .= "\n\t\t\t</div>";
            $html .= "<div class='col-sm-12 col-md-6 text-md-right social-share' id='social-share'>";
            $html .= "<div class='col-sm-6 col-md-10 col-addthis'>";
            $html .= "<div class=\"addthis_inline_share_toolbox\"></div>";
            $html .= "</div>";
            $html .= "<div class='col-sm-6 col-md-2 text-sm-left col-font-change no-padding'>";
            $html .= "<ul id='font-change-list'>";
            $html .= "<li><a href='#' class='icon-font' id='decrfont'><img src='".get_template_directory_uri()."/assets/img/icon/Decrease_Font.png'/></a></li>";
            $html .= "<li><a href='#' class='icon-font' id='incrfont'><img src='".get_template_directory_uri()."/assets/img/icon/Increase_Font.png'/></a></li>";
            $html .= "</ul>";
            $html .= "</div>";
            $html .= "</div>";
            $html .= "</div>";
        }

        return $html;
    }

    /**
     * Get sidebar accordion snippet
     * @param $contentArr
     * @return string
     */
    static function getSidebarAccordion($contentArr)
    {
        $accordionId = 'sidebarAccordion';
        $html = "";

        if ( is_array($contentArr) && count($contentArr) ) {
            $html .= '<div id="' . $accordionId . '" role="tablist" aria-multiselectable="true">';

            foreach ( $contentArr as $key => $layout ) {
                $html .= '<div class="card">';
                $html .= '<div class="card-header" role="tab" id="heading-' . $key . '">';
                $html .= '<h4>';
                $html .= '<a class="collapse" data-toggle="collapse" data-parent="#' . $accordionId . '" href="#content-' . $key . '" aria-expanded="false" aria-controls="content-' . $key . '">';
                $html .= $layout['content_title'];
                $html .= '</a>';
                $html .= '</h4>';
                $html .= '</div>';
                $html .= '<div id="content-' . $key . '" class="collapse" role="tabpanel" aria-labelledby="heading-' . $key . '">';
                $html .= '<div class="card-block">';
                $html .= $layout['content_body'];
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }

            $html .= '</div>';
        }

        return $html;
    }

    /**
     * Generate the accordion for the event single page
     * @param $fields
     * @return string
     */
    static function getEventSidebarAccordion($fields)
    {
        $accordionId = 'sidebarAccordion';
        $html = "";
        $fields = (array) $fields;

        $html .= '<div id="' . $accordionId . '" role="tablist" aria-multiselectable="true">';
        foreach ( $fields as $title => $value ) {
            if ( $value ) {
                $key = Str::slug($title);

                $html .= '<div class="card">';
                $html .= '<div class="card-header" role="tab" id="heading-' . $key . '">';
                $html .= '<h4>';
                $html .= '<a class="collapse" data-toggle="collapse" data-parent="#' . $accordionId . '" href="#content-' . $key . '" aria-expanded="true" aria-controls="content-' . $key . '">';
                $html .= _x($title, 'theme', 'wma');
                $html .= '</a>';
                $html .= '</h4>';
                $html .= '</div>';
                $html .= '<div id="content-' . $key . '" class="collapse in" role="tabpanel" aria-labelledby="heading-' . $key . '">';
                $html .= '<div class="card-block">';
                $html .= $value;
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</div>';
            }
        }

        $html .= '</div>';

        return $html;
    }

    /**
     * Get the archived policies snippet
     * @param $contentArr
     * @return string
     */
    static function getArchivedPolicies($contentArr)
    {
        $html = '';

        if ( is_array($contentArr) && count($contentArr) ) {

            foreach ( $contentArr as $layout ) {
                $html .= '<div class="policy-block">';
                $html .= '<h3>' . $layout['title'] . '</h3>';

                if ( array_key_exists('policies', $layout) && is_array($layout['policies']) && count($layout['policies']) ) {
                    $html .= '<ul>';

                    foreach ( $layout['policies'] as $policy )
                        $html .= '<li><a href="' . get_permalink($policy['policy']->ID) . '">' . $policy['policy']->post_title . '</a></li>';

                    $html .= '</ul>';
                }

                $html .= '</div>';
            }

        }

        return $html;
    }
}