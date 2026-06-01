<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Buscar por nombre o correo
        if ($request->filled('buscar')) {

            $query->where(function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->buscar . '%')
                ->orWhere('email', 'like', '%' . $request->buscar . '%');

            });

        }

        // Filtrar por estado
        if ($request->filled('activo')) {

            $query->where('activo', $request->activo);

        }

        // Filtrar por rol
        if ($request->filled('rol')) {

            $query->role($request->rol);

        }

        $usuarios = $query
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $roles = Role::orderBy('name')->get();

        return view('usuarios.index', compact('usuarios', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('usuarios.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'role' => 'required'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'El correo electrónico ya se encuentra registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'role.required' => 'Debe seleccionar un rol.'
        ]);
        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'activo' => $request->has('activo')
        ]);

        $usuario->assignRole($request->role);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        $roles = Role::orderBy('name')->get();

        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'role' => 'required'
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'El correo ya se encuentra registrado.',
            'role.required' => 'Debe seleccionar un rol.'
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'activo' => $request->has('activo')
        ]);

        $usuario->syncRoles([$request->role]);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        if ($usuario->id === auth()->id()) {

            return redirect()
                ->route('usuarios.index')
                ->with('error', 'No puede modificar su propio estado.');

        }

        $usuario->update([
            'activo' => !$usuario->activo
        ]);

        return redirect()
            ->route('usuarios.index')
            ->with(
                'success',
                $usuario->activo
                    ? 'Usuario activado correctamente.'
                    : 'Usuario desactivado correctamente.'
            );
    }
}
