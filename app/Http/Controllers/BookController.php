<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $sortBy = $request->query('sortBy', 'title');
        $direction = $request->query('direction', 'asc');

        if (!in_array($sortBy, ['title', 'author', 'year', 'added_by'])) {
            return response()->json(['error' => 'Nieprawidłowe pole sortowania'], 400);
        }

        $books = Book::orderBy($sortBy, $direction)->get();

        return response()->json($books);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer|min:1000|max:2100',
            'description' => 'nullable|string',
            'added_by' => 'required|string|max:255', // Teraz wymagamy imienia użytkownika!
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }
    public function destroy($id)
{
    $book = Book::find($id);
    if (!$book) {
        return response()->json(['message' => 'Książka nie została znaleziona'], 404);
    }

    $book->delete();
    return response()->json(['message' => 'Książka usunięta pomyślnie']);
}
public function update(Request $request, $id)
{
    $book = Book::find($id);

    if (!$book) {
        return response()->json(['error' => 'Książka nie istnieje'], 404);
    }

    // Sprawdzenie, czy użytkownik jest autorem
    if ($request->user_name !== $book->added_by) {
        return response()->json(['error' => 'Brak uprawnień do edycji'], 403);
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        'year' => 'required|integer',
        'description' => 'nullable|string',
    ]);

    $book->update($validated);

    return response()->json($book, 200);
}
}
