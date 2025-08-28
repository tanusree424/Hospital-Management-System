<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\support\Facades\Log;
use Illuminate\support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
class BlogController extends Controller
{
    public function index()
    {

        if (Gate::none(['blog_access'])) {
            abort(403);
        }
        $blogs = Blog::with('author')->get();
        // foreach ($blogs as $key => $blog) {
        //     return response()->json(["blog"=> $blog]);
        // }

         return view('pages.AdminPages.Blogs.index', compact('blogs'));

    }
    public function store(Request $request)
{
    $validated = $request->validate([
        "title"       => "required|min:3",
        "slug"        => "required|unique:blogs,slug",
        "description" => "nullable|string",
        "image"       => "nullable|mimes:jpg,png,jpeg|max:2048",
    ]);

    // Log incoming request data
    \Log::info("Incoming Data:", $request->all());

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('blog_image', 'public');
    }
    if (auth()->user()->hasRole('Doctor')) {
       $userId = auth()->user()->doctor?->id;
    }else  {
        $userId =auth()->user()->admin?->id;
    }

    $blog = Blog::create([
        "title"       => $request->title,
        "slug"        => $request->slug,
        "author_id" => $userId,
       // "author"      => auth()->user()->name,  // storing logged-in user id
        "description" => $request->description,
        "image"       => $imagePath,
    ]);

    if (!$blog) {
        return redirect()->back()->with('error', "Blog not created successfully");
    }
    return redirect()->route('admin.blogs.index')->with('success', "Blog '{$blog->title}' created successfully");
}
 public function update(Request $request, $id)
{
    $request->validate([
        "title"       => "sometimes|required|string|min:3",
        "slug"        => "sometimes|required|string|unique:blogs,slug,$id",
        "description" => "nullable|string",
        "image"       => "nullable|image|mimes:jpg,jpeg,png|max:2048",
    ]);
    $blog = Blog::find($id);
    if (!$blog) {
        return redirect()->back()->with('error', "Blog Not Found");
    }
    $data = [];

    if ($request->has('title')) {
        $data['title'] = $request->title;
    }
    if ($request->has('slug')) {
        $data['slug'] = $request->slug;
    }
    if ($request->has('description')) {
        $data['description'] = $request->description;
    }
    if ($request->hasFile('image')) {
        // delete old image if exists
        if ($blog->image && Storage::disk('public')->exists($blog->image)) {
            Storage::disk('public')->delete($blog->image);
        }
        $data['image'] = $request->file('image')->store('blog_image', 'public');
    }
    $blog->update($data);
    return redirect()->route('admin.blogs.index')
        ->with('success', "Blog {$blog->title} Updated Successfully");
}

public function destroy($id)
{
    $blog = Blog::findOrFail($id);
    $blog->delete();
    return redirect()->route('admin.blogs.index')->with('success',"Blog {$blog->title} Deeletd Successfully");
}
}
