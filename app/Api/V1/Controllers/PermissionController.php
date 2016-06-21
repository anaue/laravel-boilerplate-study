<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use Acl;
use App\Models\Acl\Permission as Permission;

use App\Http\Requests;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    use Helpers;

    public function grantUserPermission()
    {
        $currentUser = $this->currentUser();
        $permission = Permission::all()->first();
        return Acl::grantUserPermission($permission, $currentUser,["create"], true);
    }

    public function grantGroupPermission()
    {
        $currentUser = $this->currentUser();
        $permission = $this->currentUser()->getPermissions()->first();
        $group =  $currentUser->getGroup()->first();
        return Acl::grantGroupPermission($permission, $group , "create", true );
    }


    public function isAllow(Request $request, $resource)
    {
        $currentUser = $this->currentUser();
        if( Acl::isAllow($resource, $currentUser) )
            return 'true';
        else
            return 'false';
    }

    public function createPermission(Request $request )
    {
        $zone = $request->get('zone');
        $permissionName = $request->get('permission_name');
        $actions = $request->get('actions');
        $description = $request->get('description');
        return Acl::createPermission( $zone, $permissionName, $actions, $description);
    }


    private function currentUser() {
        return JWTAuth::parseToken()->authenticate();
    }
}
