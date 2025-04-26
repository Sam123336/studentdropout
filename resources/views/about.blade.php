@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
  <div class="bg-white p-6 rounded-2xl shadow-md w-full max-w-2xl text-center">
    <h1 class="text-2xl font-bold text-indigo-700 mb-4">📚 About Dropout Analyser</h1>
    
    <p class="text-gray-600 text-sm mb-6">
      Dropout Analyser is a smart system designed to help educators and administrators monitor, predict, and prevent student dropouts.
      Built with Laravel, React, and Tailwind CSS, it combines powerful data visualization and predictive insights.
    </p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-left mb-6">
      <div>
        <h2 class="text-indigo-600 font-semibold text-sm mb-2">Key Features</h2>
        <ul class="list-disc list-inside text-gray-700 text-xs">
          <li>Real-time dropout prediction</li>
          <li>Dynamic charts and reports</li>
          <li>Student performance tracking</li>
          <li>Interactive consultation system</li>
          <li>Admin and Student roles</li>
        </ul>
      </div>
      <div>
        <h2 class="text-indigo-600 font-semibold text-sm mb-2">Technologies</h2>
        <ul class="list-disc list-inside text-gray-700 text-xs">
          <li>Laravel 10</li>
          <li>React & TailwindCSS</li>
          <li>MySQL Database</li>
          <li>Chart.js for visualizations</li>
          <li>LarapexChart integration</li>
        </ul>
      </div>
    </div>

    <div class="text-center">
      <h2 class="text-indigo-600 font-semibold text-sm mb-2">Developer</h2>
      <p class="text-gray-700 text-xs">Developed by [Your Name], a passionate college student exploring web development and machine learning technologies.</p>
    </div>

    <div class="mt-6">
      <a href="/dashboard" class="inline-block bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-semibold py-2 px-4 rounded-full">Back to Dashboard</a>
    </div>
  </div>
</div>
@endsection
