# Wirtutalna biblioteka

## Cele projektu
Projekt ma na celu umożliwienie użytkownikowi dodania książki oraz informacji dotyczących książki. 
Ponadto użytkownik ma możliwość wystawienia recenzji do danej książki wraz z oceną oraz treścią recenzji.
Dany użytkownik może edytować oraz usuwać dodane książki oraz recenzje.
Projekt realizuje podstawe podstawowe operacje CRUD na bazie danych.

### Technologie
* JavaScript
* PHP
* Laravel
* Vue.js

## Opis projektu
Użytkownik podczas dodawania ksiązki, bądź recenzji wprowadza swoje imie, które przekazywane jest do bazy danych.
Użytkownik może edytować lub usuwać swoje książki/recenzje TYLKO jeśli wpisze swoje imie w pole "logowania" na górze strony. 
Dodane książki, lub recenzje na bieżąco są zapisywane do bazy danych.
Po wykonaniu akcji "Dodaj ksiażkę" lista książek jest aktualizowana na podstawie zawartości bazy danych.
Projekt posiada kilka wad t.j brak dynamicznego odświeżania zawartości kontrolki combo-box w panelu lista recenzji po dodaniu książki, oraz brak dynamicznego odświeżania tytułu książki w panelu listy recenzji po dodaniu recenzji.
Z uwagi na błędy popełnione podczas projektowania architektury projektu, opisane problemy zostały tymczasowo rozwiązane poprzez dodanie przycisków odświeżania wspomnianych komponentów.

# Virtualna Biblioteka

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

## Znane Problemy i Ograniczenia
- **Brak dynamicznego odświeżania** zawartości combo-boxa w panelu listy recenzji po dodaniu nowej książki.
- **Brak dynamicznego odświeżania** tytułu książki w panelu listy recenzji po dodaniu nowej recenzji.
- Z powodu błędów w architekturze projektu, tymczasowym rozwiązaniem tych problemów jest dodanie **przycisków odświeżania** w odpowiednich komponentach.

## Jak Uruchomić Projekt?
1. **Sklonuj repozytorium**:
   ```sh
   git clone https://github.com/twoje-repozytorium.git
   cd virtual-library

