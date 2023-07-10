# Zadanie rekrutacyjne

## Opis zadania

Celem zadania jest stworzenie prostego systemu do zarządzania projektami w oparciu o
Laravel i Orchid (https://orchid.software/). System powinien umożliwiać:

* Tworzenie, edycję i usuwanie projektów
* Tworzenie, edycję i usuwanie zadań w ramach projektów
* Przypisywanie zadań do użytkowników
* Określanie statusu zadań (np. &quot;do zrobienia&quot;, &quot;w trakcie&quot;, &quot;zakończone&quot;)

Projekty powinny mieć następujące pola:

* Nazwa
* Opis
* Data rozpoczęcia
* Data zakończenia (opcjonalne)

Zadania powinny mieć następujące pola:

* Nazwa
* Opis
* Data rozpoczęcia
* Data zakończenia (opcjonalne)
* Status
* Przypisany użytkownik (opcjonalne)

System powinien umożliwiać filtrowanie i sortowanie projektów oraz zadań według nazwy,
daty rozpoczęcia i zakończenia oraz statusu.

System powinien używać bazy danych (dowolnej – SQLite, MySQL, PgSQL) do
przechowywania informacji o projektach i zadaniach oraz mieć przygotowane migracje dla
bazy danych.

## Jak uruchomić projekt?

Aby uruchomić projekt, wykonaj następujące kroki:

* Edytuj plik .env.example i zapisz go jako .env
* Uzupełnij dane dostępowe do wcześniej przygotowanej bazy danych

W terminalu wpisz następujące komendy:

```
composer install
php artisan key:generate
npm install
npm run build
php artisan migrate
```

Aby dodać przykładowego użytkownika, wykonaj następującą komendę (WAŻNE: użytkownika trzeba dodać przed wykonaniem następnej komendy):
```
php artisan orchid:admin
```

Aby wypełnić bazę danych przykładowymi danymi, wykonaj następującą komendę:

```
php artisan db:seed
```

Aplikacja jest gotowa do działania. Uruchom serwer za pomocą komendy:

```
php artisan serve
```

Aby rozpocząć zaloguj się używając danych podczas rejestracji przykładowego użytkownika.

## DEMO

Demo: https://lara-tasks.robb.cfolks.pl/
