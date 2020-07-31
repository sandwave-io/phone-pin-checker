<?php

namespace Sandwave\PhonePinChecker\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Sandwave\PhonePinChecker\Domain\IncomingCall;
use Sandwave\PhonePinChecker\Events\PinOkay;
use Sandwave\PhonePinChecker\PhonePinChecker;
use Sandwave\PhonePinChecker\Http\Requests\CheckRequest;

class PhonePinCheckerController extends Controller
{
    /** @var PhonePinChecker */
    private $checker;

    public function __construct(PhonePinChecker $checker)
    {
        $this->checker = $checker;
    }

    /**
     * Show the profile for the given user.
     *
     * @param  Request  $request
     * @return string
     */
    public function create(Request $request)
    {
        $authorization = $this->checker->create(null, $request->get('reference'));

        return $authorization->getPin();
    }

    /**
     * Show the profile for the given user.
     *
     * @param  CheckRequest  $request
     * @return Application|Response|ResponseFactory
     */
    public function check(CheckRequest $request)
    {
        $call = new IncomingCall($request->code, $request->callerid, $request->callername, $request->did);

        $authorization = $this->checker->check($call->getCode());

        if ($authorization) {
            event(new PinOkay($call, $authorization));
        }

        // Depending on if an authorization is given, return these values.
        $status = ($authorization) ? 'ACK' : 'NAK';

        return response('status='.$status, 200)
            ->header('Content-Type', 'text/plain');
    }
}
