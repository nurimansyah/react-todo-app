<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Todo;

class TodoTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Tes apakah, jika saya mengunjungi URL [GET] /api/v1/todo, maka akan tampil data-data
     * semua todo beserta deskripsinya.
     *
     * @return void
     */
    public function testGetAllTodo()
    {
        // Pertama, kita coba untuk insert data
        $insert = [
            ['description' => 'Saya ingin mencoba todo app dengan react.', 'done' => FALSE],
            ['description' => 'Ini adalah todo kedua saya.', 'done' => FALSE],
            ['description' => 'Dan ini adalah todo ketiga saya.', 'done' => FALSE]
        ];
        foreach ($insert as $row)
        {
            $row = (Object) $row;
            $data = new Todo;
            $data->description = $row->description;
            $data->done = $row->done;
            $data->save();
        }

        // Expektasi
        $this->json('GET', '/api/v1/todo')->seeJson(['description' => 'Saya ingin mencoba todo app dengan react.', 'done' => 0]);
        $this->json('GET', '/api/v1/todo')->seeJson(['description' => 'Ini adalah todo kedua saya.', 'done' => 0]);
        $this->json('GET', '/api/v1/todo')->seeJson(['description' => 'Dan ini adalah todo ketiga saya.', 'done' => 0]);
    }

    /**
     * Tes, jika saya mengisi payload data:
     * - description
     * - title
     * Dan mengirimkan via POST /api/v1/todo, maka data todo akan tersimpan
     * dan memberikan response JSON.
     *
     * @return void
     */
    public function testCreateNewTodo()
    {
        // Tes Input
        $input = [
            'description' => 'Menambah todo baru',
            'done' => FALSE
        ];

        // Cek JSON
        $this->post('/api/v1/todo', $input)->seeJsonEquals([
            'success' => 200
        ]);

        // Expektasi
        $this->seeInDatabase('todos', ['description' => 'Menambah todo baru', 'done' => FALSE]);
    }

    /**
     * Test untuk update todo yang terseleksi (single atau multiple)
     *
     * @return void
     */
    public function testUpdateTodo()
    {
        // Test single data
        // ------------------------------------------------------------------------------------------------

        // Pertama kita create dulu datanya
        $todo = new Todo;
        $todo->description = 'Test todo';
        $todo->done = FALSE;
        $todo->save();

        // Lalu set data update dan kita update "done" menjadi true
        $update = [
            'todos' => [
                ['id' => $todo->id, 'done' => TRUE]
            ]
        ];

        // Untuk proses update, kita menggunakan metode PUT
        $this->json('PUT', '/api/v1/todo', $update)->seeJson([
            'success' => 200
        ]);

        // Test multiple data
        // ------------------------------------------------------------------------------------------------
        $data = [
            (Object) ['description' => 'Test todo #1', 'done' => FALSE],
            (Object) ['description' => 'Test todo #2', 'done' => FALSE],
            (Object) ['description' => 'Test todo #3', 'done' => FALSE],
        ];
        // Insert
        foreach ($data as $row)
        {
            $todo = new Todo;
            $todo->description = $row->description;
            $todo->done = $row->done;
            $todo->save();
        }

        // Update todo 2 dan 3, set done menjadi TRUE
        $update = [
            'todos' => [
                ['id' => 2, 'done' => TRUE],
                ['id' => 3, 'done' => TRUE]
            ]
        ];

        // Untuk proses update, kita menggunakan metode PATCH karena mungkin tidak semua field yang akan kita update
        $this->json('PUT', '/api/v1/todo', $update)->seeJson([
            'success' => 200
        ]);
    }

    /**
     * Tes untuk menghapus todo yang terseleksi (single)
     *
     * @return void;
     */
    public function testDeleteSingleTodo()
    {
        // Test single data
        // ------------------------------------------------------------------------------------------------
        $data = (Object) ['description' => 'Test Todo', 'done' => FALSE];
        $todo = new Todo;
        $todo->description = $data->description;
        $todo->done = $data->done;
        $todo->save();

        // Set Target
        $target = [
            'todos' => [
                ['id' => $todo->id]
            ]            
        ];

        // Hapus Data
        $this->json('DELETE', '/api/v1/todo', $target)->seeJson(['success' => 200]);
    }

    /**
     * Tes untuk menghapus todo yang terseleksi (multiple)
     *
     * @return void
     */
    public function testDeleteMultipleTodo()
    {
        // Test multiple data
        // ------------------------------------------------------------------------------------------------
        $data = [
            (Object) ['description' => 'Test Todo 1', 'done' => FALSE],
            (Object) ['description' => 'Test Todo 2', 'done' => FALSE],
            (Object) ['description' => 'Test Todo 3', 'done' => FALSE]
        ];
        foreach ($data as $row)
        {
            $todo = new Todo;
            $todo->description = $row->description;
            $todo->done = $row->done;
            $todo->save();
        }

        // Set Target
        $target = [
            'todos' => [
                ['id' => 1],
                ['id' => 2]
            ]            
        ];

        // Hapus Data
        $this->json('DELETE', '/api/v1/todo', $target)->seeJson(['success' => 200]);

        // Lihat data terakhir
        $this->json('GET', '/api/v1/todo')->seeJson(['description' => 'Test Todo 3', 'done' => 0]);
    }
}
