<?php
/**
 * Only to be used within wordpress as it makes use of core wordpress functionality
 */
namespace ICN;

use Helpers\Str;

class Menu
{
    /**
     * Variable to hold the supplied current post ID
     * @var
     */
    public $currentId;

    /**
     * Variable to hold the supplied Wordpress menu location
     * @var string
     */
    public $menuLocation;

    /**
     * Variable to hold the menu items
     * @var
     */
    public $items;

    /**
     * @var string
     */
    protected $moreIconHtml;

    /**
     * \n\t\t\t\t\t
     * @var
     */
    protected $tabs;

    /**
     * @var
     */
    protected $descriptionLimit;

    /**
     * Menu constructor.
     * @param string $menu_location
     */
    public function __construct($current_id, $menu_location = 'primary')
    {
        $this->currentId = $current_id;
        $this->menuLocation = $menu_location;
        $this->moreIconHtml = "<i class='fa fa-plus'></i>";
        $this->tabs = "\n\t\t\t\t\t";
        $this->descriptionLimit = 48;
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

        return $this->items;
    }

    /**
     * Generate HTML for the menu - custom for GPEI
     * @return string
     */
    public function getMenuHtml()
    {
        $tree =  $this->getMenuTree();
        $html = "<ul class='main-ul animated hidden-md-down'>";

        if ( $tree ) {
            foreach ( $tree as $item ) {
                $spotlight = $this->getSectionSpotlight( (int) $item->object_id);

                $css_classes = "level-1 ";
                $css_classes .= $item->is_current_item ? 'current-menu-item ' : '';
                $css_classes .= $item->is_current_ancestor ? 'current-menu-ancestor ' : '';
                $target = strlen($item->target) ? '_blank' : '_self';

                $html .= "$this->tabs<li class='$css_classes'>$this->tabs\t<a href='$item->url' target='$target'>$item->title</a>";

                if ( count($item->children) )
                    $html .= $this->getSecondLevelMenuHtml($item->children, $spotlight);

                $html .= "$this->tabs</li> <!-- End li -->";
            }
        }

        $html .= "\n\t\t\t\t</ul>";
        $html .= "\n\t\t\t\t<a class='mobile-menu-icon animated hidden-lg-up' href=''><i class='fa fa-bars fa-2x'></i></a>";
        $html .= "\n\t\t\t\t<a class='mobile-menu-close animated hidden-lg-up hidden' href=''><i class='fa fa-times-circle fa-2x'></i></a>";
        $html .= "\n";

        return $html;
    }

    /**
     * Get the HTML for second level menus
     * @param $childrenTree
     * @param $spotlight
     * @return string
     */
    protected function getSecondLevelMenuHtml($childrenTree, $spotlight)
    {
        $num = count($childrenTree);
        $menuItemsCols = $spotlight ? '9' : '12';

        $html = "$this->tabs\t<div class='level-2'>$this->tabs\t\t<div class='container'>$this->tabs\t\t\t<div class='row'> <!-- Main Row -->";
        $html .= "$this->tabs\t\t\t\t<div class='col-lg-$menuItemsCols'> <!-- Menu Items -->";

        if ( $num ) {
            foreach ( $childrenTree as $key => $item ) {
                if ( $key % 3 == 0 )
                    $html .= "$this->tabs\t\t\t\t\t<div class='row'> <!-- Level 2 Child Row -->";

                $css_classes = "col-md-4 ";
                $css_classes .= $item->is_current_item ? 'current-menu-item ' : '';
                $css_classes .= $item->is_current_ancestor ? 'current-menu-ancestor ' : '';
                $target = strlen($item->target) ? '_blank' : '_self';

                $html .= "$this->tabs\t\t\t\t\t\t<div class='$css_classes'><a href='$item->url' target='$target'><span class='big-plus'>&#x0002B; </span>$item->title</a>";

//                if ( $item->description ) {
//                    $html .= "$this->tabs\t\t\t\t\t\t\t<div class='menu-description'>";
//                    $html .= "$this->tabs\t\t\t\t\t\t\t\t" . Str::limit($item->description, $this->descriptionLimit);
//                    $html .= "$this->tabs\t\t\t\t\t\t\t</div>";
//                }

                if (count($item->children))
                    $html .= $this->getLowerLevelMenuHtml($item->children, $level = 3);

                $html .= "$this->tabs\t\t\t\t\t\t</div>";

                if ( ( $key % 3 == 2) || ( $key == $num - 1 ) )
                    $html .= "$this->tabs\t\t\t\t\t</div> <!-- End Level 2 Child Row -->";
            }
        }

        $html .= "$this->tabs\t\t\t\t</div> <!-- End Menu Items -->";

        if ( $spotlight ) {
            $sp = strtoupper(_x('Spotlight', 'theme', 'wma'));

            $html .= "$this->tabs\t\t\t\t<div class='col-lg-3'> <!-- Spotlight -->";
            $html .= "$this->tabs\t\t\t\t\t<div class='spotlight-header'>$sp</div>";
            $html .= "$this->tabs\t\t\t\t\t<div class='the-spotlight-image'>
                    <a href='" . $spotlight['link'] . "'><img class='img-fluid' src='" . $spotlight['image'] . "' alt='$sp' /></a></div>";
            $html .= "$this->tabs\t\t\t\t\t<div class='the-spotlight-title'><a href='" . $spotlight['link'] . "'>" . $spotlight['title'] . "</a></div>";

            $html .= "$this->tabs\t\t\t\t</div> <!-- End spotlight -->";
        }

        $html .= "$this->tabs\t\t\t</div> <!-- End Main Row -->";
        $html .= "$this->tabs\t\t</div> <!-- End Container -->";
        $html .= "$this->tabs\t</div> <!-- End Level-2 -->";

        return $html;
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
        $html = "<ul class='level-$level'>";

        if ( $num ) {
            foreach ( $childrenTree as $item ) {
                $css_classes = "";
                $css_classes .= $item->is_current_item ? 'current-menu-item ' : '';
                $css_classes .= $item->is_current_ancestor ? 'current-menu-ancestor ' : '';
                $target = strlen($item->target) ? '_blank' : '';
                $more = '';
                $childrenHtml = '';

                if ( count($item->children) ) {
                    $more = "<span class='see-more-icon plus'>$this->moreIconHtml</span>";
                    $childrenHtml = $this->getLowerLevelMenuHtml($item->children, $level+1);
                }
                else
                    $css_classes .= 'no-children ';

                $html .= "<li class='$css_classes'>$more<a href='$item->url' target='$target'>$item->title</a>";
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
            foreach ( $highestLevelItems as $root ) {
                $root->children = [];
                $root->is_current_item =  ( $this->currentId == (int) $root->object_id );
                $root->is_current_ancestor = false;
                $children = $this->getChildrenTree($root, $root);

                if ( $children ) {
                    foreach ( $children as $child ) {
                        if ( $this->currentId == (int) $child->object_id ) {
                            $child->is_current_item = true;
                            $root->is_current_ancestor = true;
                            break;
                        }
                    }
                    $root->children = $children;
                }

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

        if ( $this->items ) {
            foreach ( $this->items as $key => $item ) {
                if ( (int) $item->menu_item_parent == 0 )
                    $highestLevelItems[] = $item;
            }
        }

        return $highestLevelItems;
    }

    /**
     * Get the children tree of a given parent
     * @param $parent
     * @param $root
     * @return array
     */
    protected function getChildrenTree($parent, $root)
    {
        $childrenTree = [];
        $children = $this->getDirectChildren($parent);

        if ( $children ) {
            foreach ($children as $child) {
                $child->children = [];
                $child->is_current_item = $this->currentId == (int) $child->object_id ? true : false;
                $child->is_current_ancestor = false;
                $subChildren = null; //$this->getChildrenTree($child, $root); DISABLE THIS AS WE ONLY WANT FIRST LEVEL CHILDREN

                if ( $subChildren ) {
                    foreach ( $subChildren as $subChild ) {
                        if ( $this->currentId == (int) $subChild->object_id ) {
                            $subChild->is_current_item = true;
                            $child->is_current_ancestor = true;
                            $root->is_current_ancestor = true;
                            break;
                        }
                    }
                    $child->children = $subChildren;
                }

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

    /**
     * Get Section spotlight
     * @param int $rootId
     * @return mixed|null
     */
    protected function getSectionSpotlight( $rootId = 0 )
    {
        $spotlight = get_field('section_spotlight', $rootId);
        return is_array($spotlight) ? $spotlight[0] : null;
    }

}
