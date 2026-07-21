<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'เฉพาะ Super Admin เท่านั้นที่สามารถจัดการผู้ใช้ได้');
        }

        $query = User::query();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('central_admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'เฉพาะ Super Admin เท่านั้นที่สามารถจัดการสิทธิ์ได้');
        }

        $validated = $request->validate([
            'role' => 'required|in:customer,admin,super_admin',
        ]);

        // Prevent self-demotion
        if ($user->id === auth()->id() && $validated['role'] !== 'super_admin') {
            return back()->with('error', 'ไม่สามารถลดสิทธิ์บัญชีตนเองได้');
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', "อัปเดตสิทธิ์ของ {$user->name} เป็น {$validated['role']} เรียบร้อยแล้ว");
    }

    public function toggleStatus(User $user)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'เฉพาะ Super Admin เท่านั้นที่สามารถเปลี่ยนสถานะผู้ใช้ได้');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'ไม่สามารถปิดการใช้งานบัญชีตนเองได้');
        }

        $user->update(['is_active' => !$user->is_active]);

        $statusText = $user->is_active ? 'เปิดใช้งาน' : 'ระงับการใช้งาน';
        return back()->with('success', "{$statusText} บัญชี {$user->name} เรียบร้อยแล้ว");
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'เฉพาะ Super Admin เท่านั้นที่สามารถสร้างบัญชีแอดมิน/ผู้ใช้ใหม่ได้');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:customer,admin,super_admin',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'is_active' => true,
        ]);

        return back()->with('success', "สร้างบัญชีใหม่สำหรับ {$validated['name']} ({$validated['role']}) เรียบร้อยแล้ว");
    }

    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'เฉพาะ Super Admin เท่านั้นที่สามารถลบผู้ใช้ได้');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'ไม่สามารถลบบัญชีตนเองได้');
        }

        $user->delete();

        return back()->with('success', "ลบบัญชี {$user->name} เรียบร้อยแล้ว");
    }
}
