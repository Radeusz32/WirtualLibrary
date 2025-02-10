<template>
    <div>
        <h1>Wirtualna Biblioteka 📚</h1>
        <label>👤 Użytkownik:</label>
        <input v-model="user_name" placeholder="Wpisz swoje imię" />

        <div class="app-container">
    
            <div class="forms-container">
                <BookForm @bookAdded="handleNewBook"  />
                <ReviewForm ref="reviwf"
                    :bookId="selectedBookId"
                    :user_name="user_name"
                    :books="books" 
                    @reviewAdded="addReviewToList" 
                />
            </div>

            
            <div class="content-container">
                <BookList ref="bookList" :user_name="user_name" @booksUpdated="updateBooks" />
                <ReviewList ref="reviewList" :user_name="user_name" />
            </div>
        </div>
    </div>
</template>

<script>
import BookList from './components/BookList.vue';
import BookForm from './components/BookForm.vue';
import ReviewForm from './components/ReviewForm.vue'
import ReviewList from './components/ReviewList.vue'
export default {
    components: { BookList, BookForm, ReviewForm, ReviewList },
    data() {
        return {
            books: [],
            selectedBookId: null,
            user_name: '' 
        };
    },
    created() {
    this.fetchBooks();
  },
    methods: {
        updateBooks(books) {
        
        this.$refs.reviwf.books = books;
        
    },
        fetchBooks() {
      axios.get('/books')
        .then(response => {
          this.books = response.data;
        })
        .catch(error => console.error("❌ Błąd pobierania książek:", error));
    },
        handleNewBook(book) {
            console.log("📥 Otrzymano zdarzenie `bookAdded` w App.vue:", book);
            if (this.$refs.bookList) {
                console.log("📝 Dodawanie książki do listy w BookList.vue");
                this.$refs.bookList.addNewBook(book);
                // if (this.$refs.reviwf)
                //     this.$refs.reviwf.fetchBooks();
            
            

            } else { 
                console.error("❌ `bookList` nie jest poprawnie zainicjalizowane!");
            }
        },
        addReviewToList(newReview) {
            
            console.log("🔄 Przekazanie nowej recenzji do ReviewList.vue:", newReview);
            this.$refs.reviewList.addReviewToList(newReview);
            // if (this.$refs.reviewList)
                    // this.$refs.reviewList.fetchReviews();
        }
        
    }
};
</script>

<style scoped>
.app-container {
    display: flex;
    flex-direction: column;
    /* align-items: center; */
    padding: 20px;
}

.forms-container, .content-container {
    display: flex;
    /* justify-content: space-between; */
    width: 100%;
    padding: 10px;
    border: 2px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    gap: 20px;
    flex:1;
}
.content-container{
    display: flex;
}
</style>
