<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //  
        $users = User::where('name', 'LIKE', '%' . $request->search_akun . '%')->orderBy('name', 'ASC')->simplePaginate(5);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $password = substr($request->email, 0, 4) . substr($request->name, 0, 4);

        $request->validate(
            [
                'name' => 'required|max:200',
                'email' => 'required|max:200|email|unique:users',
                'role' => 'required|min:3',
            ],
            [
                'name.required' => 'Nama tidak boleh kosong!',
                'email.required' => 'Email tidak boleh kosong!',
                'email.email' => 'Email harus berformat email!',
                'email.unique' => 'Email sudah terdaftar!',
                'role.required' => 'Role tidak boleh kosong!',
            ]
        );

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data akun');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $users = User::where('id', $id)->first();

        return view('user.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd untuk melihat password tanpa enskripsi
        if ($request->filled('password')) {
            $request->validate(
                [
                    'name' => 'required|max:200',
                    'email' => 'required|max:200|email|unique:users,email,' . $id,
                    'password' => 'min:8',
                    'role' => 'required|min:3',
                ],
                [
                    'name.required' => 'Nama tidak boleh kosong!',
                    'email.required' => 'Email tidak boleh kosong!',
                    'email.email' => 'Email harus berformat email!',
                    'email.unique' => 'Email sudah terdaftar!',
                    'role.required' => 'Role tidak boleh kosong!',
                ]
            );

            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);
        } else {
            $request->validate(
                [
                    'name' => 'required|max:200',
                    'email' => 'required|max:200|email|unique:users,email,' . $id,
                    'role' => 'required|min:3',
                ],
                [
                    'name.required' => 'Nama tidak boleh kosong!',
                    'email.required' => 'Email tidak boleh kosong!',
                    'email.email' => 'Email harus berformat email!',
                    'email.unique' => 'Email sudah terdaftar!',
                    'role.required' => 'Role tidak boleh kosong!',
                ]
            );

            User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
        }

        return redirect()->route('akun.daftar_akun')->with('success', 'Data Akun Berhasil di Update');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $deleteData = User::where('id', $id)->delete();

        if ($deleteData) {
            return redirect()->back()->with('deleted', 'Menghapus data akun!');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus data akun!');
        }
    }

    // make login
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        $users = $request->only(['email', 'password']);
        if (Auth::attempt($users)) {
            return redirect()->route('home');
        } else {
            return redirect()->back()->with('error', 'Email atau Password salah!');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login.auth');
    }
}
