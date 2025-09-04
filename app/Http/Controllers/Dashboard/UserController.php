<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): View
    {
        $users = $this->userService->getAllUsers();
        return view('dashboard.pages.users.index', compact('users'));
    }

    public function create(): View
    {
        $userTypes = $this->userService->getAllUserTypes();
        return view('dashboard.pages.users.create', compact('userTypes'));
    }

    public function store(UserRequest $request)
    {
        try {
            $this->userService->createUser($request->validated());
            return response()->json(['message' => 'تم إضافة المستخدم بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'فشل في إضافة المستخدم: ' . $e->getMessage()], 400);
        }
    }
    public function show($id)
    {
        $users = $this->userService->getAllUsers();
        return view('dashboard.pages.users.index', compact('users'));
    }
    public function edit($id): View
    {
        $user = $this->userService->getUserById($id);
        $userTypes = $this->userService->getAllUserTypes();
        return view('dashboard.pages.users.edit', compact('user', 'userTypes'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $this->userService->updateUser($id, $request->validated());
            return response()->json(['message' => 'تم تحديث المستخدم بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'فشل في تحديث المستخدم: ' . $e->getMessage()], 400);
        }
    }

     public function trashed(): View
    {
        $users = User::onlyTrashed()->with(['userType', 'businessInfo'])->get();
        return view('dashboard.pages.users.trashed', compact('users'));
    }

    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);
            return response()->json(['message' => 'تم حذف المستخدم بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'فشل في حذف المستخدم: ' . $e->getMessage()], 400);
        }
    }

    public function restore($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $user->restore();
            return response()->json(['message' => 'تم استعادة المستخدم بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'فشل في استعادة المستخدم: ' . $e->getMessage()], 400);
        }
    }

    public function forceDelete($id)
    {
        try {
            $user = User::onlyTrashed()->findOrFail($id);
            $this->userService->deleteUser($id);
            $user->forceDelete();
            return response()->json(['message' => 'تم حذف المستخدم نهائيًا بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'فشل في الحذف النهائي للمستخدم: ' . $e->getMessage()], 400);
        }
    }
}
