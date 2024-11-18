@extends('layouts.app')

@section('title', 'Editar Feedback')

@section('content')
    <div class="mb-4">
        <h1 class="mb-10 text-5xl font-bold text-black">Editar Feedback</h1>
        <form action="{{ route('feedback.update', $feedback->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">
                    {{ __('Título del Feedback') }}
                    <input type="text" name="title" id="title" 
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Escribe aquí el título"
                    value="{{ old('title', $feedback->title) }}" required>
                </label>
            </div>
            
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">
                    {{ __('Descripción del Feedback') }}
                    <textarea name="description" id="description" rows="4"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Escribe aquí la descripción" required>{{ old('description', $feedback->description) }}</textarea>
                </label>
            </div>
            
            <div class="flex items-center justify-end gap-x-4">
                <button type="submit" 
                class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    {{ __('Modificar Feedback') }}
                </button>
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-gray-700">Cancelar</a>
            </div>
        </form>
    </div>
@endsection