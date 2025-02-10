<template>
    <div class="review-form-container">
        <h2>📌 Dodaj recenzję</h2>
        <div></div>
        <form @submit.prevent="addReview">
            <div class="input-group">
                <label>📖 Wybierz książkę:</label>
        
                <select v-model="selectedBookId" required > 
                     <!-- @focus="fetchBooks" -->
                    <option v-for="book in books" :key="book.id" :value="book.id">
                        {{ book.title }} (ID: {{ book.id }})
                    </option>
                </select>
            </div>

                
            <div class="input-group">
                <label>👤 Twoje Imię:</label>
                <input v-model="user_name" placeholder="Twoje Imię" required />
            </div>
            <div class="input-group">
                <label>⭐ Ocena:</label>
                <select v-model="rating" required>
                    <option v-for="star in 5" :key="star" :value="star">{{ star }} ⭐</option>
                </select>
            </div>
            <div class="input-group">
                <label>✍️ Treść recenzji:</label>
                <textarea v-model="content" placeholder="Treść recenzji" required></textarea>

                <button type="submit" class="action-button">➕ Dodaj recenzję</button>
            </div>
            
        </form>
    </div>
</template>

<script>
import axios from 'axios';

export default {

    data() {
        return {
            books: [],
            selectedBookId: null,
            user_name: '',
            rating: 5,
            content: ''
        };
    },
    created() {
        this.fetchBooks();
    },
    methods: {
        fetchBooks() {
            console.log("🔍 book_id:", this.selectedBookId); // Debugowanie
            console.log("🔍 reviewed_by:", this.user_name); // Debugowanie
            console.log("🔍 rating:", this.rating); // Debugowanie
            console.log("🔍 content:", this.content); // Debugowanie
            axios.get(`/books`)
                .then(response => {
                    this.books = response.data;
                    if (this.books.length > 0) {
                        this.selectedBookId = this.books[0].id;
                    }
                })
                .catch(error => {
                    console.error("❌ Błąd podczas pobierania książek:", error);
                });
        },
        addReview() {
            if (!this.selectedBookId) {
                alert("❗ Wybierz książkę do recenzji!"); // Debugowanie
                return;
            }

            const reviewData = {
                book_id: this.selectedBookId,
                reviewed_by: this.user_name,
                rating: this.rating,
                content: this.content
            };
            console.log("📤 Wysyłanie recenzji:", reviewData); // Debugowanie
            axios.post(`/reviews`, reviewData)
                .then(response => {
                    console.log("✅ Recenzja dodana:", response.data); // Debugowanie
                    this.$emit('reviewAdded', response.data);
                    this.resetForm();
                })
                .catch(error => console.error("❌ Błąd dodawania recenzji:", error.response)); // Debugowanie
        },
        resetForm() {
            this.user_name = '';
            this.rating = 5;
            this.content = '';
        }
    }
};
</script>

<style scoped>
.review-form-container {
    width: 100%;
    /* margin: auto; */
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

input, textarea, select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    background-color: #fff;
}

textarea {
    resize: vertical;
    min-height: 80px;
    margin-bottom: 5px;
}

.action-button {
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
