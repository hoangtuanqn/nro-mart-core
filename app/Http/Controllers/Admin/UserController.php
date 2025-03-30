<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Danh sách user
    public function index()
    {
        $title = 'Danh sách người dùng';
        $users = User::orderBy('id', 'DESC')->get();
        return view('admin.users.index', compact('title', 'users'));
    }

    public function edit($id)
    {
        $title = 'Sửa người dùng #' . $id;
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('title', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:member,admin',
            'balance' => 'required|numeric|min:0',
            'banned' => 'required|in:0,1'
        ]);

        $user->update([
            'email' => $request->email,
            'role' => $request->role,
            'balance' => $request->balance,
            'banned' => $request->banned
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Cập nhật thông tin người dùng thành công!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Xóa thành viên thành công!'
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Xóa thành viên thành công!');
    }
}
