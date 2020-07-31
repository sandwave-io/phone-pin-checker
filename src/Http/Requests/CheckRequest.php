<?php declare(strict_types = 1);

namespace Sandwave\PhonePinChecker\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $did
 * @property string $callerid
 * @property string $callername
 * @property string $code
 */
class CheckRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'did'           => 'string', // called number
            'callerid'      => 'required|string', // number calling
            'callername'    => 'string',
            'code'          => 'required|numeric',
        ];
    }

    /**
     * New in L5.5, and required for those fancy middlewares.
     *
     * @see https://github.com/laravel/framework/blob/master/src/Illuminate/Http/Request.php#L471
     */
    public function setJson($json)
    {
        $this->json = $json;

        return $this;
    }
}
