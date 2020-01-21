<?php

namespace Sandwave\Http\Controllers;

use Illuminate\Routing\Controller;
use Sandwave\PhonePinChecker\PhonePinChecker;

class PhonePinCheckerController extends Controller
{
    /**
     * Show the profile for the given user.
     *
     * @return string
     */
    public function create()
    {
        $code = app(PhonePinChecker::class)->create();

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
        $valid = app(PhonePinChecker::class)->check($request->code);

        $return = '';

        if ($valid) {
            $return = 'ACK';
        } else {
            $return = 'NAK';
        }

        return $return;
    }
}
