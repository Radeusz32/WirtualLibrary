<template>
    <div class="book-form-container">
        <h2>📚 Dodaj nową książkę</h2>
        <form @submit.prevent="addBook">
            <div class="input-group">
                <label>👤 Twoje Imię</label>
                <input v-model="user_name" placeholder="Wpisz swoje imię" required />
            </div>

            <div class="input-group">
                <label>📖 Tytuł książki</label>
                <input v-model="title" placeholder="Wpisz tytuł książki" required />
            </div>

            <div class="input-group">
                <label>✍️ Autor</label>
                <input v-model="author" placeholder="Wpisz autora" required />
            </div>

            <div class="input-group">
                <label>📅 Rok wydania</label>
                <input v-model="year" type="number" placeholder="Podaj rok wydania od 1000-2100" required />
            </div>

            <div class="input-group">
                <label>📝 Opis</label>
                <textarea v-model="description" placeholder="Dodaj krótki opis książki"></textarea>
            </div>

            <button type="submit">➕ Dodaj książkę</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            user_name: '',
            title: '',
            author: '',
            year: '',
            description: ''
        };
    },
    methods: { // 🟢 Teraz `methods` jest we właściwym miejscu
        addBook() {
            const bookData = {
                added_by: this.user_name,
                title: this.title,
                author: this.author,
                year: this.year,
                description: this.description  
            };

            console.log("📤 Wysyłane dane:", bookData); // Debugowanie

            axios.post('/books', bookData)
                .then(response => {
                
                console.log("✅ Książka dodana:", response.data); // 🟢 Logowanie sukcesu
                if (!response.data.id) {
                        console.error("❌ Błąd: Brak `id` w odpowiedzi z serwera!");
                        return;
                }
                console.log("📢 Emitowanie zdarzenia `bookAdded`", response.data);
                this.$emit('bookAdded', response.data); // 🟢 Emitowanie nowej książki
                this.resetForm();
                })
                .catch(error => {
                    console.error("❌ Błąd podczas dodawania książki:", error.response);
                });
            },
        resetForm() {
                this.user_name = ''; // Resetowanie pól
                this.title = '';
                this.author = '';
                this.year = '';
                this.description = '';
        }
            
        }
    };
</script>
<style scoped>
.book-form-container {
    width: 100%;
    
    margin: auto;
    padding: 20px;
    border: 2px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.input-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 15px;
}

label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

input, textarea {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    background-color: #fff;
}

textarea {
    resize: vertical;
    min-height: 80px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    font-size: 16px;
    font-weight: bold;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.2s;
}

button:hover {
    background-color: #0056b3;
}
</style>