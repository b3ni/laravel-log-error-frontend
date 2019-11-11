<?php
namespace Brarcos\LogErrorFrontend\Controllers;

use Brarcos\LogErrorFrontend\Models\ErrorFrontend;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LogErrorFrontendController extends Controller
{
    public function log(Request $request)
    {
        if (!$request->ajax()) {
            abort(404);
        }

        $error = ErrorFrontend::create([
            'user_id' => \Auth::check() ? \Auth::user()->id : null,
            'url' => $request->url(),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'ip' => $request->ip(),
            'error' => $request->get('errorMsg'),
            'error_data' => json_encode($request->all()),
        ]);

        return '';
    }
}
