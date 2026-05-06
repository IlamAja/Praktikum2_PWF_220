<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $todos = $request->user()->todos()->latest()->get();

        return view('todo.index', [
            'todos' => $todos,
        ]);
    }
}
