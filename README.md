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
