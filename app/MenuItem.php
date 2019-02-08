<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'name', 'compact_name', 'parent_item_id', 'url', 'font_awesome_class', 'lang_string','route','type','menu_id','order'
    ];
    
    /***************************************************************************/
    /**
     * Return the items of the menu in a tree format (multidimensional array)
     * https://stackoverflow.com/questions/4196157/create-array-tree-from-array-list
     *
     * @param  $menuId - the menu id
     * @return array $ret - the multidimensional array with the tree
     */

    public static function getItemsTree($menuId){
    
        $menuItems = MenuItem::where('menu_id','=',$menuId)
                                ->orderBy('order','ASC')
                                ->get();
                                
        $new = array();
        foreach ($menuItems as $menuItem){
            $new[$menuItem['parent_item_id']][] = $menuItem;
        }
        if(!empty($new)){
            $ret = MenuItem::createTree($new, $new[0]); 
        }
        else{
            $ret = [];
        }
        return $ret;
    }
    
    
    /***************************************************************************/
    /**
     * Create array tree from array list - it support more than 1 parentid[0] element
     * https://stackoverflow.com/questions/4196157/create-array-tree-from-array-list
     *
     * @param  $list
     * @param  $parent
     * @return string $key - the index of the parent item
     */

    public static function createTree(&$list, $parent){
        $tree = array();
        foreach ($parent as $k=>$l){
            if(isset($list[$l['id']])){
                $l['children'] = MenuItem::createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        } 
        return $tree;
    }
    
    /***************************************************************************/
    /**
     * Return the access level name
     * https://stackoverflow.com/questions/4196157/create-array-tree-from-array-list
     *
     * @param  $accessId
     * @return string $ret - the string that describe the access 
     */

    public static function getAccessName($accessId){
        $accessLevels = [
            '1' => 'Public',
            '2' => 'Guest',
            '3' => 'Manager',
            '4' => 'Administrator',  
        ];
        
        $ret = $accessLevels[$accessId];
        
        
        
        
        return $ret;
    }
    
    
    
}
