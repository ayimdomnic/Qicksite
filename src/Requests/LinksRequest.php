<?php

namespace Ayimdomnic\QuickSite\Requests;

use Auth;
use Ayimdomnic\QuickSite\Models\Link;
use Gate;
use Illuminate\Foundation\Http\FormRequest;

class LinksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (env('APP_ENV') !== 'testing') {
            return Gate::allows('quicksite', Auth::user());
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Link::$rules;
    }
}
