<?php
/**
 * Only to be used within wordpress as it makes use of core wordpress functionality
 */
namespace ICN;

class Sitemap
{
    /**
     * Supplied Wordpress menu location
     * @var string
     */
    public $menuLocation;

    /**
     * Menu items
     * @var
     */
    public $items;

    /**
     * Extra items (not in the menu)
     * @var
     */
    public $extraItems;

    /**
     * Sitemap constructor.
     * @param $extraItems
     * @param string $menu_location
     */
    public function __construct($extraItems, $menu_location = 'primary')
    {
        $this->extraItems = $extraItems;
        $this->menuLocation = $menu_location;
        $this->getMenuItems();
    }

    /**
     * Get the Wordpress menu items for the supplied menu location
     * @return array|false
     */
    protected function getMenuItems()
    {
        $locations = get_nav_menu_locations();
        if ( $locations && isset($locations[$this->menuLocation]) ) {
            $menu = wp_get_nav_menu_object($locations[$this->menuLocation]);

            if ( $menu )
                $this->items = wp_get_nav_menu_items($menu->term_id);
        }
    }

    /**
     * Generate HTML for the menu - custom for GPEI
     * @return string
     */
    public function getMenuHtml()
    {
        $tree =  $this->getMenuTree();
        $html = "";

        if ( $tree || $this->extraItems ) {
            $html .= "<ul class='sitemap-list sitemap-level-1'>";
            $html .= "<li><a href='" . get_home_url() . "'>" . _x('Home', 'theme', 'wma') . "</a></li>"; //There you go Mr. Home Page. Take a bow, son

            if ( $tree ) {
                foreach ($tree as $item) {
                    $target = strlen($item->target) ? '_blank' : '';
                    $html .= "<li><a href='$item->url' target='$target'>$item->title</a>";

                    if (count($item->children))
                        $html .= $this->getSecondLevelMenuHtml($item->children);

                    $html .= "</li>";
                }
            }

            if ( $this->extraItems ) {
                foreach( $this->extraItems as $item ) {
                    $permalink = get_permalink($item->ID);
                    $html .= "<li><a href='$permalink'>$item->post_title</a></li>";
                }
            }

            $html .= "</ul>";
        }

        return $html;
    }

    /**
     * Get the HTML for second level menus
     * @param $childrenTree
     * @return string
     */
    protected function getSecondLevelMenuHtml($childrenTree)
    {
        $html = "<ul class='sitemap-level-2'>";

        if ( count($childrenTree) ) {
            foreach ($childrenTree as $item) {
                $target = strlen($item->target) ? '_blank' : '';
                $html .= "<li><a href='$item->url' target='$target'>$item->title</a>";

                if (count($item->children))
                    $html .= $this->getLowerLevelMenuHtml($item->children, $level = 3);

                $html .= "</li>";
            }
        }

        return $html . "</ul>";
    }

    /**
     * Get lower level menu HTML (Iterator)
     * @param $childrenTree
     * @param $level
     * @return string
     */
    protected function getLowerLevelMenuHtml($childrenTree, $level)
    {
        $num = count($childrenTree);
        $html = "<ul class='sitemap-level-$level'>";

        if ( $num ) {
            foreach ( $childrenTree as $item ) {
                $target = strlen($item->target) ? '_blank' : '';
                $childrenHtml = '';

                if ( count($item->children) )
                    $childrenHtml = $this->getLowerLevelMenuHtml($item->children, $level+1);

                $html .= "<li><a href='$item->url' target='$target'>$item->title</a>";
                $html .= $childrenHtml;
                $html .= "</li>";

            }
        }

        return $html . "</ul>";
    }

    /**
     * Get Menu tree array
     * @return array
     */
    protected function getMenuTree()
    {
        $highestLevelItems = $this->getHighestLevelMenuItems();
        $tree = [];

        if ( $highestLevelItems ) {
            foreach ($highestLevelItems as $root) {
                $root->children = [];
                $children = $this->getChildrenTree($root);

                if ( $children )
                    $root->children = $children;

                $tree[] = $root;
            }
        }

        return $tree;
    }

    /**
     * Get top level menu items
     * @return array
     */
    protected function getHighestLevelMenuItems()
    {
        $highestLevelItems = [];

        foreach( $this->items as $key => $item ) {
            if ( (int) $item->menu_item_parent == 0 )
                $highestLevelItems[] = $item;
        }

        return $highestLevelItems;
    }

    /**
     * Get the children tree of a given parent
     * @param $parent
     * @return array
     */
    protected function getChildrenTree($parent)
    {
        $childrenTree = [];
        $children = $this->getDirectChildren($parent);

        if ( $children ) {
            foreach ($children as $child) {
                $child->children = [];
                $subChildren = $this->getChildrenTree($child);

                if ( $subChildren )
                    $child->children = $subChildren;

                $childrenTree[] = $child;
            }
        }

        return $childrenTree;
    }

    /**
     * Get the direct children of a given parent
     * @param $parent
     * @return array
     */
    public function getDirectChildren($parent)
    {
        $children = [];

        foreach ( $this->items as $child ) {
            if ( (int) $child->menu_item_parent == $parent->ID )
                $children[] = $child;
        }
        return $children;
    }

    /**
     * Get the menu parent of a given menu child
     * @param $child
     * @return mixed
     */
    protected function getMenuParent($child)
    {
        $menu_parent = $child;

        foreach ( $this->items as $item ) {
            if ( $item->ID == (int) $child->menu_item_parent ) {
                $menu_parent = $item;
                break;
            }
        }

        return $menu_parent;
    }

}
