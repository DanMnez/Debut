<?php

namespace app\Controllers;

use app\Models\User;
use core\Auth;
use core\Controller;
use core\View;

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios
     *
     * @return void
     */
    public function index()
    {
        if (Auth::check()) {

            $users = User::all();

            View::template('users/index.html', [
                'users' => $users,
            ]);

        } else {
            return redirect('/');
        }
        
    }

    /**
     * Muestra un formulario para crear un nuevo
     * usuario
     *
     * @return void
     */
    public function create()
    {
        View::template('users/create.html');
    }

    /**
     * Obtiene los datos de un formulario y crea el
     * usuario
     *
     * @return void
     */
    public function store()
    {
        $user = new User();

        // Recuerda validar
        $user->email    = $_POST["email"];
        $user->name     = $_POST["name"];
        $user->lastname = $_POST["lastname"];
        $user->username = $_POST["username"];
        $user->password = md5($_POST["pass"]);
        $user->age      = $_POST["age"];
        
// Objetivo -->
//        $user->email    = $request->input('email');
        
        if ($user->save()) {
            return redirect('/users');
        } else {
            throw new \Exception('No se ha podido crear el usuario', 500);
        }
    }

    /**
     * Muestra un formulario con los datos del
     * usuario indicado
     *
     * @param  int $id El identificador
     *
     * @return void
     */
    public function edit($id)
    {
        $user = User::find($id);
        
        View::template('users/edit.html', [
            'user' => $user,
        ]);
    }

    /**
     * Actualiza el usuario con los nuevos datos
     * pasados
     *
     * @param  int $id El identificador
     *
     * @return void
     */
    public function update($id)
    {
        $user = User::find($id);

        // Recuerda validar
        $user->email    = $_POST["email"];
        $user->name     = $_POST["name"];
        $user->lastname = (empty($_POST['lastname'])) ? null : $_POST['lastname'];
        $user->username = $_POST["username"];
        $user->password = md5($_POST["pass"]);
        $user->age      = (empty($_POST['age'])) ? null : $_POST['age'];
        
        if ($user->update()) {
            return redirect('/users');
        } else {
            throw new \Exception('No se ha podido actualizar el usuario', 500);
        }

    }

    /**
     * Borra el usuario indicado
     *
     * @param  int $id El identificador
     *
     * @return void
     */
    public function destroy($id)
    {
        $user = User::find($id);
        
        if ($user->delete()) {
            return redirect('/users');
        } else {
            throw new \Exception('No se ha podido borrar el usuario', 500);
        }
    }
}
