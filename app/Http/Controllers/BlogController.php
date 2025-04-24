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
use App\Models\Comment;
use App\Models\Like;
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
     * Display a single blog post with its comments.
     */
    public function show($id)
    {
        $blog = Post::findOrFail($id);
        $comments = $blog->comments()->with('user')->latest()->get();
        return view('blog.show', compact('blog', 'comments'));
    }

    /**
     * Store a new comment for a blog post.
     */
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->route('blogs.show', $id)->with('success', 'Comment submitted!');
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

    /**
     * Toggle like status for a blog post.
     */
    public function toggleLike($id)
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $post = Post::findOrFail($id);
        $user = auth()->user();
        $liked = false;
        
        // Check if already liked
        $existingLike = Like::where('post_id', $post->id)
                            ->where('user_id', $user->id)
                            ->first();
        
        if ($existingLike) {
            // Unlike
            $existingLike->delete();
        } else {
            // Like
            Like::create([
                'post_id' => $post->id,
                'user_id' => $user->id
            ]);
            $liked = true;
        }
        
        $likesCount = $post->likes()->count();
        
        return response()->json([
            'liked' => $liked,
            'likesCount' => $likesCount
        ]);
    }

    /**
     * Like a blog post.
     */
    public function like($id)
    {
        $user = auth()->user();
        $post = Post::findOrFail($id);

        // Prevent duplicate likes
        $existingLike = Like::where('post_id', $post->id)
                            ->where('user_id', $user->id)
                            ->first();

        if (!$existingLike) {
            Like::create([
                'post_id' => $post->id,
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('blogs.show', $id)->with('success', 'You liked this blog!');
    }

    /**
     * Unlike a blog post.
     */
    public function unlike($id)
    {
        $user = auth()->user();
        $post = Post::findOrFail($id);

        $existingLike = Like::where('post_id', $post->id)
                            ->where('user_id', $user->id)
                            ->first();

        if ($existingLike) {
            $existingLike->delete();
        }

        return redirect()->route('blogs.show', $id)->with('success', 'You unliked this blog!');
    }
}
