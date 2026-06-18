<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolController extends Controller
{
    public function index()
    {
        $roles = Role::withCount(
            'users'
        )->get();

        return view(
            'roles.index',
            compact('roles')
        );
    }

    public function create()
    {
        $permisosAgrupados = [

            'Parásitos' => Permission::where(
                'name',
                'like',
                '%parasitos%'
            )->get(),

            'Mapas Epidemiológicos' => Permission::where(
                'name',
                'like',
                '%mapas%'
            )->get(),

            'Partes Anatómicas' => Permission::where(
                'name',
                'like',
                '%partes%'
            )->get(),

            'Quiz' => Permission::where(
                'name',
                'like',
                '%quiz%'
            )->get(),

            'Usuarios' => Permission::where(
                'name',
                'like',
                '%usuarios%'
            )->get(),

            'Roles' => Permission::where(
                'name',
                'like',
                '%roles%'
            )->get(),

            'Asistente IA' => Permission::where(
                'name',
                'like',
                '%ia%'
            )->get(),

        ];

        return view(
            'roles.create',
            compact(
                'permisosAgrupados'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate(

            [

                'name' => 'required|string|max:255|unique:roles,name',

                'permissions' => 'required|array|min:1'

            ],

            [

                'name.required' =>
                    'El nombre del rol es obligatorio.',

                'name.unique' =>
                    'Ya existe un rol con ese nombre.',

                'permissions.required' =>
                    'Debe seleccionar al menos un permiso.'

            ]

        );

        $role = Role::create([

            'name' => $request->name

        ]);

        $role->syncPermissions(
            $request->permissions
        );

        return redirect()
            ->route('roles.index')
            ->with(
                'success',
                'Rol creado correctamente.'
            );
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        $permisosAgrupados = [

            'Parásitos' => [
                'ver parasitos',
                'crear parasitos',
                'editar parasitos',
                'eliminar parasitos',
            ],

            'Mapas Epidemiológicos' => [
                'ver mapas',
                'crear mapas',
                'editar mapas',
                'eliminar mapas',
            ],

            'Partes Anatómicas' => [
                'ver partes',
                'crear partes',
                'editar partes',
                'eliminar partes',
            ],

            'Quiz' => [
                'ver quiz',
                'crear quiz',
                'editar quiz',
                'eliminar quiz',
            ],

            'Usuarios' => [
                'ver usuarios',
                'crear usuarios',
                'editar usuarios',
                'eliminar usuarios',
            ],

            'Roles' => [
                'ver roles',
                'crear roles',
                'editar roles',
                'eliminar roles',
            ],

            'Asistente IA' => [
                'ver asistente ia',
            ],

        ];

        return view(
            'roles.show',
            compact(
                'role',
                'permisosAgrupados'
            )
        );
    }

    public function edit(Role $role)
    {
        $role->load('permissions');

        $permisosAgrupados = [

            'Parásitos' => Permission::where('name', 'like', '%parasitos%')->get(),

            'Mapas Epidemiológicos' => Permission::where('name', 'like', '%mapas%')->get(),

            'Partes Anatómicas' => Permission::where('name', 'like', '%partes%')->get(),

            'Quiz' => Permission::where('name', 'like', '%quiz%')->get(),

            'Usuarios' => Permission::where('name', 'like', '%usuarios%')->get(),

            'Roles' => Permission::where('name', 'like', '%roles%')->get(),

            'Asistente IA' => Permission::where('name', 'like', '%ia%')->get(),

        ];

        return view(
            'roles.edit',
            compact(
                'role',
                'permisosAgrupados'
            )
        );
    }

    public function update(Request $request,Role $role)
    {
        $request->validate([

            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,

        ]);

        $role->update([

            'name' => $request->name

        ]);

        $role->syncPermissions(
            $request->permissions ?? []
        );

        return redirect()
            ->route('roles.index')
            ->with(
                'success',
                'Rol actualizado correctamente.'
            );
    }

    public function destroy(Role $role)
    {
        if ($role->users()->count() > 0)
        {
            return redirect()
                ->route('roles.index')
                ->with(
                    'error',
                    'No es posible eliminar este rol porque tiene usuarios asignados.'
                );
        }

        if ($role->name === 'Administrador')
        {
            return redirect()
                ->route('roles.index')
                ->with(
                    'error',
                    'El rol Administrador no puede eliminarse.'
                );
        }

        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with(
                'success',
                'Rol eliminado correctamente.'
            );
    }
}