<?php

namespace Sandwave\PhonePinChecker\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Sandwave\PhonePinChecker\Events\PinOkay;
use Sandwave\PhonePinChecker\PhonePinChecker;
use Sandwave\PhonePinChecker\Http\Requests\CheckRequest;

class PhonePinCheckerController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @param  Request  $request
     * @return string
     */
    public function create(Request $request)
    {
        $optionalData = $request->only(
            config('phone-pin-checker.optional_data')
        );

        $code = app(PhonePinChecker::class)->create(null, $optionalData);

        return $code;
    }

    /**
     * Show the profile for the given user.
     *
     * @param  CheckRequest  $request
     * @return string
     */
    public function check(CheckRequest $request)
    {
        $check = app(PhonePinChecker::class)->check($request->code);

        $return = '';

        if ($check) {
            $return = 'ACK';

            event(new PinOkay([
                'did'           => $request->did,
                'callerid'      => $request->callerid,
                'callername'    => $request->callername,
                'optional_data' => $check['optional_data'],
                'expire'        => $check['expire'],
            ]));
        } else {
            $return = 'NAK';
        }

        return 'status='.$return;
    }
}
