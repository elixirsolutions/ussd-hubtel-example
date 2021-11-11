<?php

namespace App\Http\Controllers;

use Sparors\Ussd\Facades\Ussd;
use App\Http\Ussd\Welcome;

class UssdController extends Controller
{
    public function index()
    {
		$ussd = Ussd::machine()->set([
		    'phone_number' => request('Mobile'),
		    'network' => request('Operator'),
		    'session_id' => request('SessionId'),
		    'input' => request('Message')
		])
	    ->setInitialState(Welcome::class)
	    ->setResponse(function(string $message, string $action) {
		    return [
				'Mobile' => request('Mobile'),
                'SessionId' => request('SessionId'),
                'Message' => $message,
                'Type' => $action === 'prompt' ? 'Release' : 'Response'
		    ];
		});

	    return response()->json($ussd->run());
    }
}
