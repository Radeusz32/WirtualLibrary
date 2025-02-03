
# Wirtualna Biblioteka

## Cele Projektu
Projekt ma na celu umożliwienie użytkownikom dodawania książek oraz informacji dotyczących tych książek. Ponadto użytkownicy mogą wystawiać recenzje do poszczególnych książek, dodając ocenę oraz treść recenzji. Każdy użytkownik może edytować oraz usuwać dodane przez siebie książki i recenzje. Projekt realizuje podstawowe operacje CRUD na bazie danych.

## Technologie
- **JavaScript**
- **PHP**
- **Laravel**
- **Vue.js**

## Opis Projektu
1. **Dodawanie Książek i Recenzji**
   - Użytkownik podczas dodawania książki lub recenzji podaje swoje imię, które jest przekazywane do bazy danych.
   - Po dodaniu nowej książki lista książek jest automatycznie aktualizowana na podstawie zawartości bazy danych.

2. **Edycja i Usuwanie**
   - Użytkownik może edytować oraz usuwać swoje książki i recenzje **tylko** jeśli poda swoje imię w polu "logowania" na górze strony.

3. **Baza Danych**
   - Wszystkie dodane książki i recenzje są na bieżąco zapisywane w bazie danych.

## Problemy i Ograniczenia
- **Brak dynamicznego odświeżania** zawartości combo-boxa w panelu listy recenzji po dodaniu nowej książki.
- **Brak dynamicznego odświeżania** tytułu książki w panelu listy recenzji po dodaniu nowej recenzji.
- Z powodu błędów w architekturze projektu, tymczasowym rozwiązaniem tych problemów jest dodanie **przycisków odświeżania** w odpowiednich komponentach.

## Jak Uruchomić Projekt?
1. **Sklonuj repozytorium**:
   ```sh
   git clone https://github.com/WirtualLibrary.git
   cd virtual-library

2. **Zainstaluj zależności backendowe**:
   ```sh
   composer install
3. **Zainstaluj zależności frontendowe**:
   ```sh
   npm install
4. **Skonfiguruj bazę danych w pliku .env**
5. **Uruchom migracje**:
   ```sh
   php artisan migrate
6. **Uruchom serwer backendu**:
   ```sh
   php artisan serve
7. **Uruchom serwer frontendu**:
   ```sh
   npm run dev
 

