<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            
        @endif
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-50 text-black/50">
            <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
                <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                    <header class="flex items-end py-10">
                        
                        @if (Route::has('login'))
                            <nav class="flex justify-end flex-1 -mx-3">
                                @auth
                                <div class="hidden sm:flex sm:items-center sm:ms-6">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                                                <div>{{ Auth::user()->name }}</div>
                    
                                                <div class="ms-1">
                                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>
                    
                                        <x-slot name="content">
                    
                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                    
                                                <x-dropdown-link :href="route('logout')"
                                                        onclick="event.preventDefault();
                                                                    this.closest('form').submit();">
                                                    {{ __('Desconectar') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] "
                                    >
                                        Log in
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] "
                                        >
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main class="max-w-2xl m-auto mt-6">

                    <div class="mb-10">
                        @if (session('success'))
                            <div class="p-4 text-white bg-green-500 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="p-4 text-white bg-red-500 rounded-lg">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>

                        @auth    
                            <div class="mb-4">
                                <h1 class="mb-10 text-5xl font-bold text-black">Añade un nuevo Feedback</h1>
                                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4">
                                    @csrf <!-- Token de seguridad para formularios en Laravel -->
                                    
                                    <!-- Campo para el título -->
                                    <div>
                                        <label for="title" class="block text-sm font-medium text-gray-700">
                                            {{ __('Título del Feedback') }}
                                            <input type="text" name="title" id="title" 
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('title') border-red-500 @enderror"
                                            placeholder="Escribe un título"  value="{{ old('title') }}" required>
                                        </label>
                                            @error('title')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    
                                    <!-- Campo para la descripción -->
                                    <div>
                                        <label for="description" class="block text-sm font-medium text-gray-700">
                                            {{ __('Descripción del Feedback') }}
                                            <textarea name="description" id="description" rows="4"
                                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-500 @enderror"
                                            placeholder="Escribe una descripción" required>{{ old('description') }}</textarea>
                                        </label>
                                            @error('description')
                                                <p class="text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                    </div>
                                    
                                    <!-- Botón de envío -->
                                    <div class="flex justify-end">
                                        <button type="submit" 
                                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        {{ __('Publicar Feedback') }}
                                    </button>
                                </div>
                            </form>
                            
                        </div>
                    @endauth

                        <div class="flex flex-col gap-2">
                            <h1 class="mb-10 text-5xl font-bold text-black">Feedbacks</h1>
                            @foreach ($feedback as $feed)
                                <div class="flex flex-col items-start gap-4 rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] lg:pb-10">
                                    <div class="w-full pt-0">
                                        @canany(['delete','update'], $feed)
                                        <div class="flex items-center justify-end gap-x-2">
                                            <a href="{{ route('feedback.edit', $feed->id) }}" class="my-0 text-sm text-indigo-500 hover:underline hover:underline-offset-2">Editar</a>
                                            <form action="{{ route('feedback.destroy', $feed->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este feedback?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="my-0 text-sm text-red-500 hover:underline hover:underline-offset-2">Eliminar</button>
                                            </form>
                                        </div>
                                        @endcanany
                                        
                                        <h2 class="text-xl font-semibold text-black">
                                            {{ $feed->title }}
                                        </h2>

                                        <p class="mt-4 text-sm/relaxed">
                                            {{ $feed->description }}
                                        </p>
                                    </div>
                                    <div class="flex flex-row items-end justify-end w-full gap-x-4">
                                        <div class="flex flex-row">
                                            <p><span class="font-semibold">{{ $feed->votes_count }}</span> votos</p>
                                        </div>

                                        <form action="{{ route( 'vote.store', $feed->id ) }}" method="POST" class="flex justify-end mt-4">
                                            @csrf
                                            
                                            <button 
                                            type="submit" 
                                            class="px-4 py-2 font-semibold text-white transition duration-200 bg-indigo-600 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-600"
                                            >
                                            {{ __('Votar') }}
                                        </button>
                                    </form>
                                    </div >
                                </div>
                            @endforeach
                        </div>
                        <div class="my-4">
                            {{ $feedback->links() }}
                        </div>
                    </main>

                    <footer class="py-16 text-sm text-center text-black">
                        FeedApp, conoce el feedback de tu comunidad - Hecho con amor por un Malandriner &#129505;
                    </footer>
                </div>
            </div>
        </div>
    </body>
</html>
