<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    /***************************************************************************/
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'menu_items';

    /***************************************************************************/

    use Translatable;

    public $translatedAttributes = ['name', 'compact_name'];

    protected $fillable = [
        'name', 'compact_name', 'parent_item_id', 'url', 'font_awesome_class', 'route', 'type', 'menu_id', 'order',
    ];

    /***************************************************************************/

    /**
     * Return the items of the menu in a tree format (multidimensional array)
     * If $menuId is 0 return all the items.
     * https://stackoverflow.com/questions/4196157/create-array-tree-from-array-list.
     *
     * @param  $menuId
     * @return array
     */
    public static function getItemsTree($menuId)
    {
        $menuItems = self::
                        when($menuId, function ($query, $menuId) {
                            return $query->where('menu_id', $menuId);
                        })
                        ->orderBy('order', 'ASC')
                        ->get();

        $new = [];
        foreach ($menuItems as $menuItem) {
            $new[$menuItem['parent_item_id']][] = $menuItem;
        }
        if (! empty($new)) {
            $ret = self::createTree($new, $new[0]);
        } else {
            $ret = [];
        }
        //dump($ret);

        return $ret;
    }

    /***************************************************************************/

    /**
     * Create array tree from array list - it support more than 1 parentid[0] element
     * https://stackoverflow.com/questions/4196157/create-array-tree-from-array-list.
     *
     * @param  array $list
     * @param  array $parent
     * @return array
     */
    public static function createTree(&$list, $parent)
    {
        $tree = [];
        foreach ($parent as $k=>$l) {
            if (isset($list[$l['id']])) {
                $l['children'] = self::createTree($list, $list[$l['id']]);
            }
            $tree[] = $l;
        }

        return $tree;
    }

    /***************************************************************************/

    /**
     * Return the access level name
     * https://stackoverflow.com/questions/4196157/create-array-tree-from-array-list.
     *
     * @param  int $accessId
     * @return string
     */
    public static function getAccessName($accessId)
    {
        $accessLevels = [
            '1' => 'Public',
            '2' => 'Guest',
            '3' => 'Manager',
            '4' => 'Administrator',
            '5' => 'Super Administrator',
        ];

        $ret = $accessLevels[$accessId];

        return $ret;
    }

    /***************************************************************************/

    /**
     * Check if the user group with the access level and return true if the user is authorized to see the menu item.
     *
     * @return bool
     */
    public function authorized()
    {
        $ret = false;
        $user = Auth::user();

        switch ($this->access) {
            case '1':   // Public
                $ret = true;
                break;
            case '2':   // Guest - not authenticated user
                if (! $user) {
                    $ret = true;
                }
                break;
            case '3':   // Manager
                if ($user) {
                    $ret = true;
                }
                break;
            case '4':   // Admin
                if ($user) {
                    if ($user->isSuperAdmin() || $user->isAdmin()) {
                        $ret = true;
                    }
                }
                break;
            case '5':   // Super Admin
                if ($user) {
                    if ($user->isSuperAdmin()) {
                        $ret = true;
                    }
                }
                break;
        }

        return $ret;
    }
}
