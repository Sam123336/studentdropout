<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Post;
// use App\Models\Student;
// use ArielMejiaDev\LarapexCharts\LarapexChart;

// class BlogController extends Controller
// {
//     /**
//      * Display the blog index with optional prediction chart.
//      */
//     public function index()
//     {
//         $blogs = Post::latest()->get();
//         $percentage = null;
//         $chart = null;

//         return view('blog.index', compact('blogs', 'percentage', 'chart'));
//     }

//     /**
//      * Show the blog creation form.
//      */
//     public function create()
//     {
//         return view('blog.create');
//     }

//     /**
//      * Store a new blog post.
//      */
//     public function store(Request $request)
//     {
//         $request->validate([
//             'title'           => 'required|string|max:255',
//             'content'         => 'required|string',
//             'gender'          => 'required|string',
//             'age'             => 'required|integer',
//             'region'          => 'required|string',
//             'grade'           => 'required|string',
//             'dropout_status'  => 'required|string',
//         ]);

//         Post::create([
//             'title'   => $request->title,
//             'content' => $request->content,
//         ]);

//         return redirect()->route('blogs.index')->with('success', 'Blog submitted successfully!');
//     }
//     public function public()
//     {
//         // Fetch the posts you want to display publicly.
//         // For example, all blog posts or only those with a 'published' status.
//         $blogs = \App\Models\Post::latest()->get();
//         return view('blog.public', compact('blogs'));
//     }

//     /**
//      * Predict dropout risk based on user input.
//      */
//     public function predict(Request $request)
//     {
//         $request->validate([
//             'gender' => 'required|string',
//             'age'    => 'required|integer',
//             'region' => 'required|string',
//         ]);

//         $gender = strtolower($request->gender);
//         $region = strtolower($request->region);
//         $age = $request->age;

//         $matching = Student::whereRaw('LOWER(gender) = ?', [$gender])
//             ->where('age', $age)
//             ->whereRaw('LOWER(region) = ?', [$region]);

//         $total = $matching->count();

//         $dropouts = (clone $matching)->where(function ($query) {
//             $query->where('dropout_status', 1)
//                 ->orWhere('dropout_status', '1')
//                 ->orWhereRaw("LOWER(dropout_status) = 'yes'");
//         })->count();

//         $percentage = $total > 0 ? round(($dropouts / $total) * 100, 2) : 0;

//         $chart = (new LarapexChart)->pieChart()
//             ->setTitle('Dropout Probability')
//             ->addData([$percentage, 100 - $percentage])
//             ->setLabels(['Dropout', 'Not Dropout']);

//         $blogs = Post::latest()->get();

//         return view('blog.index', compact('blogs', 'percentage', 'chart'));
//     }
// }


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Student;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class BlogController extends Controller
{
    /**
     * Display the blog index with optional prediction chart.
     */
    public function index()
    {
        $blogs = Post::latest()->get();
        $percentage = null;
        $chart = null;

        return view('blog.index', compact('blogs', 'percentage', 'chart'));
    }

    /**
     * Show the blog creation form.
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a new blog post and redirect to the public blog page.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title'   => 'required|max:255',
        //     'content' => 'required',
        // ]);

        Post::create([
            'title'   => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('blogs.public')->with('success', 'Blog submitted!');
    }

    /**
     * Display all publicly available blog posts.
     */
    public function public()
    {
        $blogs = Post::latest()->get();
        return view('blog.public', compact('blogs'));
    }

    /**
     * Predict dropout risk based on user input.
     */
    public function predict(Request $request)
    {
        $request->validate([
            'gender' => 'required|string',
            'age'    => 'required|integer',
            'region' => 'required|string',
        ]);

        $gender = strtolower($request->gender);
        $region = strtolower($request->region);
        $age = $request->age;

        $matching = Student::whereRaw('LOWER(gender) = ?', [$gender])
            ->where('age', $age)
            ->whereRaw('LOWER(region) = ?', [$region]);

        $total = $matching->count();

        $dropouts = (clone $matching)->where(function ($query) {
            $query->where('dropout_status', 1)
                ->orWhere('dropout_status', '1')
                ->orWhereRaw("LOWER(dropout_status) = 'yes'");
        })->count();

        $percentage = $total > 0 ? round(($dropouts / $total) * 100, 2) : 0;

        $chart = (new LarapexChart)->pieChart()
            ->setTitle('Dropout Probability')
            ->addData([$percentage, 100 - $percentage])
            ->setLabels(['Dropout', 'Not Dropout']);

        $blogs = Post::latest()->get();

        return view('blog.index', compact('blogs', 'percentage', 'chart'));
    }
}
