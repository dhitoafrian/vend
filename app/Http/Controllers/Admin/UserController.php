<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $users = User::query()
            ->where('role', 'petugas')
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->string('q');
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $validated['role'] = 'petugas';
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        $this->logAction($request, 'Menambah akun petugas baru');

        return redirect()->route('admin.users.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(User $user): View
    {
        abort_if($user->role !== 'petugas', 404);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        abort_if($user->role !== 'petugas', 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ]);

        if (blank($validated['password'] ?? null)) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $validated['role'] = 'petugas';
        $user->update($validated);

        $this->logAction($request, "Memperbarui akun petugas {$user->email}");

        return redirect()->route('admin.users.index')->with('success', 'Petugas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->role !== 'petugas') {
            return back()->with('error', 'Hanya akun petugas yang dapat dihapus dari menu ini.');
        }

        if ($request->user()?->id === $user->id) {
            return back()->with('error', 'Akun sendiri tidak bisa dihapus.');
        }

        $email = $user->email;
        $user->delete();

        $this->logAction($request, "Menghapus akun petugas {$email}");

        return redirect()->route('admin.users.index')->with('success', 'Petugas berhasil dihapus.');
    }

    private function logAction(Request $request, string $activity): void
    {
        LogAktivitas::create([
            'user_id' => $request->user()->id,
            'aktivitas' => $activity,
        ]);
    }
}
