<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;

class TodoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * API untuk menghapus data todo
     *
     * @return string
     */
    public function deleteTodos(Request $request)
    {
        // Set error
        $error = 0;

        // Pertama kita loop data
        $todos = $request->todos;

        foreach ($todos as $todo)
        {
            // Set Object
            $todo = (Object) $todo;

            // Ambil data todo per object
            $data = Todo::find($todo->id);

            // Hapus
            if (!$data->delete()) $error++;
        }

        // Check error
        if ($error > 0) return response()->json(['error' => 500], 500);

        // Return
        return response()->json(['success' => 200]);
    }

    /**
     * API untuk mengupdate data todo
     *
     * @return string
     */
    public function updateTodos(Request $request)
    {
        // Set error
        $error = 0;

        // Pertama kita loop data
        $todos = $request->todos;
        foreach ($todos as $todo)
        {
            // Set Object
            $todo = (Object) $todo;

            // Ambil data todo per object
            $data = Todo::find($todo->id);
            if ($todo->done) $data->done = $todo->done;

            // Save
            if (!$data->save()) $error++;
        }

        // Check error
        if ($error > 0) return response()->json(['error' => 500], 500);

        // Return
        return response()->json(['success' => 200]);
    }

    /**
     * API Untuk menampilkan semua data todo
     *
     * @return string
     */
    public function getTodos()
    {
        return response()->json(Todo::get());
    }

    /**
     * API Untuk membuat todo baru
     *
     * @return string
     */
    public function createTodo(Request $request)
    {
        // Set data
        $todo = new Todo;
        $todo->description = $request->description;
        $todo->done = $request->done;

        // Cek
        if ($todo->save()) return response()->json(['success' => 200]);
        else return response()->json(['error' => 500], 500);
    }
}
