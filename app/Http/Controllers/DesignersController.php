<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\DesignerRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Designer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignersController extends Controller
{
    // GET 主页
    public function home(Request $request)
    {
        if (Auth::check()) {
            $designer = Auth::user();
            return view('designers.home', [
                'designer' => $designer,
            ]);
        } else {
            return redirect()->back();
        }
    }

    // GET 编辑个人信息页面
    public function edit(Designer $designer)
    {
        $this->authorize('update', $designer);

        return view('designers.edit', [
            'designer' => $designer,
        ]);
    }

    // GET 修改密码页面
    public function password(Designer $designer)
    {
        $this->authorize('update', $designer);

        return view('designers.password', [
            'designer' => $designer,
        ]);
    }

    // GET 修改密码成功页面
    public function passwordSuccess(Designer $designer)
    {
        $this->authorize('update', $designer);

        return view('designers.password_success', [
            'designer' => $designer,
        ]);
    }

    // PUT 修改密码
    public function updatePassword(UpdatePasswordRequest $request, Designer $designer)
    {
        $this->authorize('update', $designer);

        $designer->update([
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->route('designers.password_success', [
            'designer' => $designer->id,
        ]);
    }

    // PUT 编辑个人信息提交 & 修改密码提交 & 修改手机提交 & 绑定手机提交
    public function update(DesignerRequest $request, Designer $designer, ImageUploadHandler $imageUploadHandler)
    {

        $this->authorize('update', $designer);

        $data = $request->only('avatar', 'email', 'password', 'real_name', 'gender', 'qq', 'wechat', 'country_code', 'phone', 'facebook');

        if ($request->hasFile('avatar')) {
            // $data['avatar'] = $imageUploadHandler->uploadOriginal($request->avatar);
            $data['avatar'] = $imageUploadHandler->uploadAvatar($request->avatar);
        }

        if ($request->has('password') && $designer->password != $data['password']) {
            $data['password'] = bcrypt($data['password']);
        }

        $designer->update($data);

        return redirect()->route('designers.home');
    }

    // POST logout
    public function logout()
    {
        Auth::logout();
    }
}
