<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        $viewData = [
            'users' => $users
        ];

        return view('admin.pages.user.index', $viewData);
    }

    public function edit($id)
    {
        $user = User::find($id);
        $viewData = [
            'user' => $user
        ];

        return view('admin.pages.user.update', $viewData);
    }

    public function update($id, Request $request)
    {
        try {
            $data               = $request->except('_token');
            $data['updated_at'] = Carbon::now();
            User::find($id)->update($data);

            return redirect()->route('get_admin.user.index');
        } catch (\Exception $exception) {
            Log::error("---------------------  " . $exception->getMessage());
            return redirect()->back();
        }
    }
}
