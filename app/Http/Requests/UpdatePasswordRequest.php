<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'password_original' => [
                'bail',
                'required',
                'string',
                'min:6',
                function ($attribute, $value, $fail) {
                    $designerData = $this->user()->makeVisible('password')->toArray();
                    if (!Hash::check($value, $designerData['password'])) {
                        if (App::isLocale('zh-CN')) {
                            $fail('原密码不正确');
                        } else {
                            $fail('The original password is wrong.');
                        }
                    }
                },
            ],
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     * @return array
     */
    public function attributes()
    {
        if (!App::isLocale('zh-CN')) {
            return [
                'password_original' => 'original password',
                'password' => 'new password',
            ];
        }
        return [
            'password_original' => '原密码',
            'password' => '新密码',
        ];
    }
}
