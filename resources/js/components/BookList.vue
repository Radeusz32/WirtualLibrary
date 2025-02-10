<template>
    <div class="book-list">
        <h2>Lista książek</h2>

        <div>
            <label>Sortuj według:</label>
            <select v-model="sortBy" @change="fetchBooks">
                <option value="title">Tytuł</option>
                <option value="author">Autor</option>
                <option value="year">Rok wydania</option>
                <option value="added_by">Dodane przez</option>
            </select>

            <button @click="toggleSortDirection">
                {{ sortDirection === 'asc' ? '⬆️ Rosnąco' : '⬇️ Malejąco' }}
            </button>
        </div>

        <ul>
            <li v-for="book in sortedBooks" :key="book.id" class="book-item">
                <h3><strong>ID:</strong> {{ book.id }}</h3>

                <!-- 🔥 Tryb edycji -->
                <div v-if="book.isEditing">
                    Tytuł:<input v-model="book.updatedTitle" placeholder="Nowy tytuł" />
                    Autor:<input v-model="book.updatedAuthor" placeholder="Nowy autor" />
                    Rok:<input v-model="book.updatedYear" type="number" placeholder="Nowy rok wydania" />
                    Opis:<textarea v-model="book.updatedDescription" placeholder="Nowy opis"></textarea>
                    
                    <button @click="saveBook(book)">💾 Zapisz</button>
                    <button @click="cancelEdit(book)">❌ Anuluj</button>
                </div>

                
                <div v-else>
                    <h3><strong>Tytuł:</strong> {{ book.title }}</h3>
                    <p>Autor: {{ book.author }} ({{ book.year }})</p>
                    <p><strong>Dodane przez:</strong> {{ book.added_by }}</p>
                    <p><strong>Opis:</strong> {{ book.description ? book.description : 'Brak opisu' }}</p>

                    <button :disabled="!isAuthor(book)" class="action-btn" @click="editBook(book)">✏️ Edytuj </button>

                    <button :disabled="!isAuthor(book)" class="action-btn" @click="deleteBook(book.id)">🗑 Usuń </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        user_name: String // ✅ Przekazywane imię użytkownika
    },
    data() {
        return {
            books: [],
            sortBy: 'title',
            sortDirection: 'asc',
        };
    },
    computed: {
        sortedBooks() {
            return [...this.books].sort((a, b) => {
                let modifier = this.sortDirection === 'asc' ? 1 : -1;
                let valueA = a[this.sortBy];
                let valueB = b[this.sortBy];

                if (typeof valueA === 'string' && typeof valueB === 'string') {
                    return valueA.localeCompare(valueB) * modifier;
                }
                return (valueA - valueB) * modifier;
            });
        }
    },
    created() {
        this.fetchBooks();
    },
    methods: {
        fetchBooks() {
            axios.get(`/books`)
                .then(response => {
                    this.books = response.data.map(book => ({
                        ...book,
                        isEditing: false,
                        updatedTitle: book.title,
                        updatedAuthor: book.author,
                        updatedYear: book.year,
                        updatedDescription: book.description
                    }));
                })
                .catch(error => console.error("❌ Błąd podczas pobierania książek:", error)); // Debugowanie
        },
        addNewBook(book) {
        console.log("📖 Dodano nową książkę:", book);
        if (!this.books.find(b => b.id === book.id)) {
            this.books.push(book);
            this.$emit('booksUpdated', this.books);
            
        }
    },
        toggleSortDirection() {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        },
        isAuthor(book) {
            return book.added_by && this.user_name 
                ? book.added_by.trim().toLowerCase() === this.user_name.trim().toLowerCase()
                : false;
        },
        editBook(book) {
            book.isEditing = true;
        },
        cancelEdit(book) {
            book.isEditing = false;
        },
        saveBook(book) {
            axios.put(`/books/${book.id}`, {
                title: book.updatedTitle,
                author: book.updatedAuthor,
                year: book.updatedYear,
                description: book.updatedDescription,
                user_name: this.user_name
            })
            .then(response => {
                book.title = response.data.title;
                book.author = response.data.author;
                book.year = response.data.year;
                book.description = response.data.description;
                book.isEditing = false;
            })
            .catch(error => console.error("❌ Błąd edycji książki:", error)); // Debugowanie
        },
        deleteBook(bookId) {
            if (!confirm("❗ Czy na pewno chcesz usunąć tę książkę?")) return; 

            axios.delete(`/books/${bookId}`)
                .then(() => {
                    this.books = this.books.filter(book => book.id !== bookId);
                })
                .catch(error => console.error("❌ Błąd usuwania książki:", error)); // Debugowanie
        }
    }
};
</script>

<style scoped>
.book-list {
    width: 50%;
}
.book-item {
    border: 2px solid #ccc;
    padding: 15px;
    margin-bottom: 10px;
    background-color: #f9f9f9;
    border-radius: 8px;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.book-item:hover {
    transform: scale(1.02);
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}
ul {
    list-style: none;
    padding: 0;
}

.action-btn {
    background-color: #ff4d4d;
    padding: 8px 12px;
    font-size: 14px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: opacity 0.3s, background-color 0.3s;
    margin-right: 5px;
}
.action-btn:hover {
    background-color: #cc0000;
}
.action-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: #ccc;
}

input, textarea {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
</style>
