<?php

namespace App\Http\Requests;

use App\Models\Designer;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DesignerRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            //'name' => ['sometimes', 'required', 'string', 'max:255', 'unique:designers'],
            'avatar' => ['sometimes', 'image'],
            /*'password_original' => [
                'sometimes',
                'required',
                'string',
                'min:6',
                'required_with:password',
                function ($attribute, $value, $fail) {
                    $designer = $this->user()->makeVisible('password')->toArray();
                    if (! Hash::check($value, $designer['password'])) {
                        $fail('原密码不正确');
                    }
                },
            ],*/
            'password' => 'sometimes|required|string|min:6|confirmed',
            'email' => [
                'sometimes', 'nullable', 'string', 'email', 'max:255',
                Rule::unique('designers')->ignore($this->route()->designer->id),
            ],
            'real_name' => 'sometimes|nullable|string',
            'gender' => [
                'sometimes',
                'string',
                Rule::in(['male', 'female']),
            ],
            'qq' => 'sometimes|nullable|string',
            'wechat' => 'sometimes|nullable|string',
            /*暂不支持修改手机号码*/
            /*'country_code' => 'sometimes|required_with:phone|string',
            'phone' => [
                'sometimes',
                'required_with:country_code',
                'string',
                function ($attribute, $value, $fail) {
                    if ($this->has('country_code')) {
                        if (! Designer::where([
                            'country_code' => $this->input('country_code'),
                            'phone' => $value,
                        ])->exists()
                        ) {
                            $fail('对不起，该手机号码尚未注册~');
                        }
                    }
                }
            ],*/
            'facebook' => 'sometimes|nullable|string',
        ];
    }

    public function attributes()
    {
        if (!App::isLocale('zh-CN')) {
            return [];
        }
        return [
            'name' => '姓名',
            'avatar' => '头像',
            'email' => '邮箱',
            // 'password_original' => '原密码',
            'password' => '密码',
            'real_name' => '真实姓名',
            'gender' => '性别:male|female',
            'qq' => 'QQ',
            'wechat' => '微信',
            /*暂不支持修改手机号码*/
            // 'country_code' => '国家|地区码',
            // 'phone' => '手机',
            'facebook' => 'Facebook',
        ];
    }
}
