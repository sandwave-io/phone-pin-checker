<?php

namespace Sandwave\PhonePinChecker\Http\Controllers;

use Illuminate\Routing\Controller;
use Sandwave\PhonePinChecker\PhonePinChecker;
use Sandwave\PhonePinChecker\Http\Requests\CheckRequest;

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
     * @param  string        $code
     * @return string
     */
    public function check(CheckRequest $request, $code)
    {
        $valid = app(PhonePinChecker::class)->check($code);

        $return = '';

        if ($valid) {
            $return = 'ACK';
        } else {
            $return = 'NAK';
        }

        return 'status='.$return;
    }
}
