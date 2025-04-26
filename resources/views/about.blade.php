@extends('layouts.app')
@section('content')
<div class="min-h-screen bg-gradient-to-b from-indigo-50 to-blue-100 flex items-center justify-center p-4">
  <div class="bg-white p-8 rounded-3xl shadow-lg w-full max-w-2xl border border-indigo-100">
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center bg-indigo-100 rounded-full p-3 mb-4">
        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7"></path>
        </svg>
      </div>
      <h1 class="text-3xl font-bold text-indigo-800 mb-3">About Dropout Analyser</h1>
      <div class="h-1 w-24 bg-gradient-to-r from-indigo-400 to-purple-500 mx-auto mb-6 rounded-full"></div>
      <p class="text-gray-600 mb-8 max-w-xl mx-auto leading-relaxed">
        Dropout Analyser is an intelligent system designed to help educators and administrators 
        monitor, predict, and prevent student dropouts through data-driven insights and early interventions.
      </p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
      <div class="bg-indigo-50 p-6 rounded-2xl border border-indigo-100 transform transition hover:scale-105 duration-300">
        <div class="flex items-center mb-4">
          <div class="bg-indigo-600 p-2 rounded-lg mr-3">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
          </div>
          <h2 class="text-lg font-bold text-indigo-800">Key Features</h2>
        </div>
        <ul class="space-y-3 text-gray-700">
          <li class="flex items-center">
            <svg class="w-4 h-4 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Real-time dropout prediction analytics
          </li>
          <li class="flex items-center">
            <svg class="w-4 h-4 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Dynamic charts and comprehensive reports
          </li>
          <li class="flex items-center">
            <svg class="w-4 h-4 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Student performance tracking dashboard
          </li>
          <li class="flex items-center">
            <svg class="w-4 h-4 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Interactive consultation system
          </li>
          <li class="flex items-center">
            <svg class="w-4 h-4 text-indigo-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Admin and Student role management
          </li>
        </ul>
      </div>
      
      <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100 transform transition hover:scale-105 duration-300">
        <div class="flex items-center mb-4">
          <div class="bg-blue-600 p-2 rounded-lg mr-3">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
            </svg>
          </div>
          <h2 class="text-lg font-bold text-blue-800">Technologies</h2>
        </div>
        <ul class="space-y-3 text-gray-700">
          <li class="flex items-center">
            <svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Laravel 10 Framework
          </li>
          <li class="flex items-center">
            <svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            React JS & TailwindCSS
          </li>
          <li class="flex items-center">
            <svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            MySQL Database
          </li>
          <li class="flex items-center">
            <svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Chart.js for data visualizations
          </li>
          <li class="flex items-center">
            <svg class="w-4 h-4 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            LarapexChart integration
          </li>
        </ul>
      </div>
    </div>
    
    <div class="bg-purple-50 p-6 rounded-2xl border border-purple-100 mb-8">
      <div class="flex items-center justify-center mb-4">
        <div class="bg-purple-600 p-2 rounded-lg mr-3">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
          </svg>
        </div>
        <h2 class="text-lg font-bold text-purple-800">Developer</h2>
      </div>
      <div class="text-center">
        <p class="text-gray-700">
          Developed by <span class="font-medium text-purple-700">[Your Name]</span>, a passionate college student 
          exploring web development and machine learning technologies to create impactful educational solutions.
        </p>
      </div>
    </div>
    
    <div class="flex justify-center space-x-4">
      <a href="/dashboard" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium rounded-full shadow-md hover:from-indigo-700 hover:to-purple-700 transition duration-300 transform hover:-translate-y-1">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
        Back to Dashboard
      </a>
      <a href="#" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-medium rounded-full shadow-md border border-indigo-200 hover:bg-indigo-50 transition duration-300 transform hover:-translate-y-1">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Learn More
      </a>
    </div>
  </div>
</div>
@endsection