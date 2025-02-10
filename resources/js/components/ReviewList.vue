<template>
    <div class="review-list-container">
        <h2>📌 Lista recenzji</h2>
        
        <select v-model="selectedBookId">
            <option value="">Wszystkie książki</option>
            <option v-for="book in books" :key="book.id" :value="book.id">
                {{ book.title }}
            </option>
        </select>

        
        <div class="filter-options">
            <label>Filtruj według oceny:</label>
            
            <select v-model="selectedRating">
                <option value="">Wszystkie</option>
                <option v-for="star in 5" :key="star" :value="star">{{ star }} ⭐</option>
            </select>
        </div>
        <div class="review-grid">
            <div v-for="review in filteredReviews" :key="review.id" class="review-card">
                <p><strong>Tytuł:📚 {{ review.book_title }}</strong></p>
                <p><strong>Osoba:{{ review.reviewed_by }}</strong></p>
                <p> {{ review.rating }} ⭐</p>
            
                
                <div v-if="review.isEditing">
                    <label>⭐ Zmień ocenę:</label>
                    <select v-model="review.updatedRating">
                        <option v-for="star in 5" :key="star" :value="star">{{ star }} ⭐</option>
                    </select>

                    <textarea v-model="review.updatedContent"></textarea>
                    <button @click="saveReview(review)">💾 Zapisz</button>
                    <button @click="cancelEdit(review)">❌ Anuluj</button>
                </div>
                <p v-else>{{ review.content }}</p>

                
                <button :disabled="!isAuthor(review)" @click="editReview(review)" class="delete-btn">✏️ Edytuj</button>

                
                <button :disabled="!isAuthor(review)" @click="deleteReview(review.id)" class="delete-btn">🗑 Usuń</button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        user_name: String
    },
    data() {
        return {
            reviews: [],
            books: [],
            selectedBookId: '',
            selectedRating: '' 
        };
    },
    created() {
        this.fetchReviews();
        this.fetchBooks();
    },
    computed: {
        filteredReviews() {
            return this.reviews
                .filter(r => (this.selectedBookId ? r.book_id == this.selectedBookId : true))
                .filter(r => (this.selectedRating ? r.rating == this.selectedRating : true)); 
        }
    },
    methods: {
        fetchReviews() {
            axios.get(`/reviews`)
                .then(response => {
                    console.log("📥 Otrzymane recenzje:", response.data); // Debugowanie
                    this.reviews = response.data.map(review => ({
                        ...review,
                        isEditing: false,
                        updatedContent: review.content,
                        updatedRating: review.rating 
                    }));
                });
        },
        fetchBooks() {
            axios.get(`/books`).then(response => {
                console.log("📚 Otrzymane książki:", response.data); // Debugowanie
                this.books = response.data;
            });
        },
        addReviewToList(newReview) {
        console.log("➕ Dodano nową recenzję:", newReview); // Debugowanie
        this.reviews.unshift(newReview); 
    },

        isAuthor(review) {
            return review.reviewed_by && this.user_name
                ? review.reviewed_by.trim().toLowerCase() === this.user_name.trim().toLowerCase()
                : false;
        },
        editReview(review) {
            review.isEditing = true;
        },
        cancelEdit(review) {
            review.isEditing = false;
        },
        saveReview(review) {
            axios.put(`/reviews/${review.id}?reviewed_by=${encodeURIComponent(this.user_name)}`, {
                content: review.updatedContent,
                rating: review.updatedRating 
            })
            .then(response => {
                console.log("✅ Recenzja zaktualizowana:", response.data);
                review.content = response.data.review.content;
                review.rating = response.data.review.rating; 
                review.isEditing = false;
            })
            .catch(error => console.error("❌ Błąd edycji recenzji:", error.response)); // Debugowanie
        },
        deleteReview(reviewId) {
            if (!confirm("❗ Czy na pewno chcesz usunąć tę recenzję?")) return; // Debugowanie

            axios.delete(`/reviews/${reviewId}?reviewed_by=${encodeURIComponent(this.user_name)}`)
                .then(() => {
                    this.reviews = this.reviews.filter(r => r.id !== reviewId);
                    console.log("🗑 Recenzja usunięta"); // Debugowanie
                })
                .catch(error => console.error("❌ Błąd usuwania recenzji:", error.response)); // Debugowanie
        }
    }
};
</script>

<style scoped>
.review-list-container {
    width: 50%;
    align-self: top;
    /* margin: 0 auto; */
}

.filter-options {
    margin-top: 10px;
    display: flex;
    gap: 10px;
}

.review-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.review-card {
    margin-bottom: 10px;
    border: 2px solid #ccc;
    padding: 15px;
    background-color: #f9f9f9;
    border-radius: 8px;
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    position: relative;
}

.review-card:hover {
    transform: scale(1.02);
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
}

.delete-btn {
    background-color: #ff4d4d;
    padding: 8px 12px;
    font-size: 14px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: opacity 0.3s, background-color 0.3s;
    margin-right: 5px;
}

.delete-btn:hover {
    background-color: #cc0000;
}
.delete-btn:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
</style>
