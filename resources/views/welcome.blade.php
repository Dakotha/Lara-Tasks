<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Tasks</title>

        @vite('resources/css/app.css')
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">

                <div class="my-16">
                    <div class="prose max-w-full">
                        <div class="scale-100 p-6 text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="flex justify-between items-center">
                                    <h1 class="text-gray-800 dark:text-gray-200">Zadanie rekrutacyjne</h1>
                                    <a class="px-4 py-2 border dark:border-gray-800 text-white no-underline bg-green-400 rounded-md hover:bg-green-600 transition-colors" href="{{ route('platform.projects.list') }}">Logowanie</a>
                                </div>
                                
                                <p>
                                    Celem zadania jest stworzenie prostego systemu do zarządzania projektami w oparciu o Laravel i Orchid (<a class="text-green-600" href="https://orchid.software/" target="_blank">https://orchid.software/</a>). System powinien umożliwiać:
                                </p>

                                <ul>
                                    <li>Tworzenie, edycję i usuwanie projektów</li>
                                    <li>Tworzenie, edycję i usuwanie zadań w ramach projektów</li>
                                    <li>Przypisywanie zadań do użytkowników</li>
                                    <li>Przypisywanie zadań do użytkowników</li>
                                    <li>Określanie statusu zadań (np. &quot;do zrobienia&quot;, &quot;w trakcie&quot;, &quot;zakończone&quot;)</li>
                                </ul>

                                <p>
                                    Projekty powinny mieć następujące pola:
                                </p>

                                <ul>
                                    <li>Nazwa</li>
                                    <li>Opis</li>
                                    <li>Data rozpoczęcia</li>
                                    <li>Data zakończenia (opcjonalnie)</li>
                                </ul>
                                
                                <p>
                                    Zadania powinny mieć następujące pola:    
                                </p>
                                
                                <ul>
                                    <li>Nazwa</li>
                                    <li>Opis</li>
                                    <li>Data rozpoczęcia</li>
                                    <li>Data zakończenia (opcjonalnie)</li>
                                    <li>Status</li>
                                    <li>Przypisany użytkownik (opcjonalne)</li>
                                </ul>
                                
                                <p>
                                    System powinien umożliwiać filtrowanie i sortowanie projektów oraz zadań według nazwy, daty rozpoczęcia i zakończenia oraz statusu.
                                </p>

                                <p>
                                    System powinien używać bazy danych (dowolnej - SQLite, MySQL, PgSQL) do przechowywania informacji o projektach i zadaniach oraz mieć przygotowane migracje dla bazy danych.
                                </p>

                                <p>
                                    Aby rozpocząć <a class="text-green-600" href="{{ route('platform.projects.list') }}">Zaloguj się</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
