<?php

namespace App\Http\Validators\Admin\Services;

use Illuminate\Support\Facades\Validator;

class CashfreeValidator
{
    
    /**
     * Validate form
     *
     * @param object $request
     * @return void
     */
    static function validate($request)
    {
        try {

            // Set rules
            $rules    = [
                'is_enabled'    => 'boolean',
                'name'          => 'required|max:60',
                'logo'          => 'nullable|image|mimes:png,jpg,jpeg',
                'currency'      => 'required|max:3|min:3',
                'exchange_rate' => 'required|numeric',
                'deposit_fee'   => 'required|integer',
                'app_id'        => 'required',
                'secret_key'    => 'required',
                'environment'   => 'required|in:development,production'
            ];

            // Set errors messages
            $messages = [
                'is_enabled.boolean'     => __('messages.t_validator_boolean'),
                'name.required'          => __('messages.t_validator_required'),
                'name.max'               => __('messages.t_validator_max', ['max' => 60]),
                'logo.image'             => __('messages.t_validator_image'),
                'logo.mimes'             => __('messages.t_validator_mimes'),
                'currency.required'      => __('messages.t_validator_required'),
                'currency.max'           => __('messages.t_validator_max', ['max' => 3]),
                'currency.min'           => __('messages.t_validator_min', ['min' => 3]),
                'exchange_rate.required' => __('messages.t_validator_required'),
                'exchange_rate.numeric'  => __('messages.t_validator_numeric'),
                'deposit_fee.required'   => __('messages.t_validator_required'),
                'deposit_fee.integer'    => __('messages.t_validator_integer'),
                'app_id.required'        => __('messages.t_validator_required'),
                'secret_key.required'    => __('messages.t_validator_required'),
                'environment.required'   => __('messages.t_validator_required'),
                'environment.in'         => __('messages.t_validator_in')
            ];

            // Set data to validate
            $data     = [
                'is_enabled'    => $request->is_enabled,
                'name'          => $request->name,
                'logo'          => $request->logo,
                'currency'      => $request->currency,
                'exchange_rate' => $request->exchange_rate,
                'deposit_fee'   => $request->deposit_fee,
                'app_id'        => $request->app_id,
                'secret_key'    => $request->secret_key,
                'environment'   => $request->environment
            ];

            // Validate data
            Validator::make($data, $rules, $messages)->validate();

            // Reset validation
            $request->resetValidation();

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
