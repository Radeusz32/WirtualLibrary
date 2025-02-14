<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Book;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('book')->get();

        return response()->json($reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'book_id' => $review->book_id ?? 0, 
                'book_title' => $review->book ? $review->book->title : "Nieznana książka",
                'reviewed_by' => $review->reviewed_by,
                'rating' => $review->rating,
                'content' => $review->content
            ];
        }));
    }


public function store(Request $request)
{
    $validatedData = $request->validate([
        'book_id' => 'required|exists:books,id',
        'reviewed_by' => 'required|string|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'content' => 'required|string',
    ]);

    $review = Review::create($validatedData);
    $review->load('book'); // 🔥 Pobieramy informacje o książce

    return response()->json([
        'id' => $review->id,
        'book_id' => $review->book_id,
        'book_title' => $review->book ? $review->book->title : "Nieznana książka", // 📚 Dodajemy tytuł książki!
        'reviewed_by' => $review->reviewed_by,
        'rating' => $review->rating,
        'content' => $review->content
    ], 201);
}

public function destroy($id, Request $request)
{
    $book = Book::find($id);
    if (!$book) {
        return response()->json(['message' => 'Książka nie została znaleziona'], 404);
    }

    // Pobranie użytkownika z requesta
    $userName = $request->query('added_by');

    // Sprawdzenie, czy użytkownik ma uprawnienia do usunięcia książki (ignorując wielkość liter)
    if (!$userName || strcasecmp($book->added_by, $userName) !== 0) {
        return response()->json(['error' => 'Brak uprawnień do usunięcia książki.'], 403);
    }

    // Usunięcie książki
    $book->delete();
    return response()->json(['message' => 'Książka usunięta pomyślnie']);
}



    public function update(Request $request, $id)
{
    $review = Review::findOrFail($id);

    // Pobieramy użytkownika z query string (?reviewed_by=ss)
    $userName = $request->query('reviewed_by');

    // Sprawdzamy, czy użytkownik jest autorem recenzji
    if ($review->reviewed_by !== $userName) {
        return response()->json(['error' => 'Brak uprawnień do edycji recenzji.'], 403);
    }

    // Walidacja danych wejściowych
    $validatedData = $request->validate([
        'rating' => 'integer|min:1|max:5',
        'content' => 'string',
    ]);

    // Aktualizacja recenzji
    $review->update($validatedData);

    return response()->json(['message' => 'Recenzja została zaktualizowana.', 'review' => $review]);
}
}