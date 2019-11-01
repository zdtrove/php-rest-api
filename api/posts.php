<?php

if ($method === 'GET') {
    if ($id) {
        $data = DB::query("SELECT * FROM $tableName WHERE id=:id", array(':id' => $id));
        if ($data != null) {
            echo json_encode($data[0]);
        } else {
            echo json_encode(['message' => 'Currently there are no posts in the database.']);
        }
    } else {
        $data = DB::query("SELECT * FROM $tableName");
        echo json_encode($data);
    }
} elseif ($method === 'POST') {
    if ($_POST != null && !$id) {
        extract($_POST);
        DB::query("INSERT INTO $tableName VALUES(null, :title, :body, :author, null)", 
            array(':title' => $title, ':body' => $body, ':author' => $author)
        );
        $data = DB::query("SELECT * FROM $tableName ORDER BY id DESC LIMIT 1");
        echo json_encode([
            'message' => 'Post added to the database successfully.', 
            'success' => true, 
            'post' => $data[0]
        ]);
    } else {
        echo json_encode([
            'message' => 'Please pill in all the credentials.', 
            'success' => false
        ]);
    }
}