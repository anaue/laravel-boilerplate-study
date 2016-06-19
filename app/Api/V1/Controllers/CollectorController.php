<?php

namespace App\Api\V1\Controllers;

use JWTAuth;
use App\Collector;
use App\Http\Requests;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CollectorController extends Controller
{
	use Helpers;

	public function index()
	{
	    $currentUser = $this->currentUser();

	    return $currentUser
	        ->delegation()
	        ->orderBy('created_at', 'DESC')
	        ->get()
	        ->toArray();
	}

    public function show(Request $request, $id)
    {
    	syslog(LOG_INFO, "id $id");
        $collector = $this->currentUser()->delegation()->find($id);
        if(!$collector)
            throw new NotFoundHttpException; 
        return $collector;
    }
	public function store(Request $request)
	{
	    $currentUser = $this->currentUser();
	    $collector = new Collector();
	    $collector->name = $request->get('name');
	    if( $collector->save() ){
		    $currentUser->delegation()->associate( $collector );
		    if( $currentUser->save() )
		        return $this->response->created();
		    else
		        return $this->response->error('could_not_save_collector_user', 500);
	    }else
			return $this->response->error('could_not_create_collector', 500);
	}
	public function update(Request $request, $id)
    {
        $collector = $this->currentUser()->delegation();
        if(!$collector)
            throw new NotFoundHttpException;
        $collector->fill($request->all());
        if($collector->save())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_update_book', 500);
    }
	public function destroy($id)
	{
	    $collector = $this->currentUser()->delegation();
	    if(!$collector)
	        throw new NotFoundHttpException;

	    if($collector->delete())
	        return $this->response->noContent();
	    else
	        return $this->response->error('could_not_delete_book', 500);
	}

    private function currentUser() {
        return JWTAuth::parseToken()->authenticate();
    }
}
