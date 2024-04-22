<?php

namespace App\Http\Controllers;

//import Model "Post
use App\Models\Post;

use Illuminate\Http\Request;

//return type View
use Illuminate\View\View;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

//import Facade "Storage"
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{    
    /**
     * index
     *
     * @return View
     */
    public function index(): View
    {
        //get foods
        $foods = Post::latest()->paginate(5);

        //render view with posts
        return view('foods.index', compact('foods'));
    }

    /**
     * create
     *
     * @return View
     */
    public function create(): View
    {
        return view('foods.create');
    }
 
    /**
     * store
     *
     * @param  mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'     => 'required|min:5',
            'harga'     => 'required',
            'content'   => 'required|min:10'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/foods', $image->hashName());

        //create post
        Post::create([
            'image'     => $image->hashName(),
            'title'     => $request->title,
            'harga'     => $request->harga,
            'content'   => $request->content
        ]);

        //redirect to index
        return redirect()->route('foods.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    
    /**
     * show
     *
     * @param  mixed $id
     * @return View
     */
    public function show(string $id): View
    {
        //get post by ID
        $food = Post::findOrFail($id);

        //render view with post
        return view('foods.show', compact('food'));
    }

    /**
     * edit
     *
     * @param  mixed $id
     * @return View
     */
    public function edit(string $id): View
    {
        //get post by ID
        $food = Post::findOrFail($id);

        //render view with post
        return view('foods.edit', compact('food'));
    }
        
    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $this->validate($request, [
            'image'     => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'     => 'required|min:1',
            'harga'     => 'required',
            'content'   => 'required|min:1'
        ]);

        //get post by ID
        $food = Post::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/foods', $image->hashName());

            //delete old image
            Storage::delete('public/foods/'.$food->image);

            //update post with new image
            $food->update([
                'image'     => $image->hashName(),
                'title'     => $request->title,
                'harga'     => $request->harga,
                'content'   => $request->content
            ]);

        } else {

            //update post without image
            $food->update([
                'title'     => $request->title,
                'harga'     => $request->harga,
                'content'   => $request->content
            ]);
        }

        //redirect to index
        return redirect()->route('foods.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    /**
     * destroy
     *
     * @param  mixed $food
     * @return void
     */
    public function destroy($id): RedirectResponse
    {
        //get post by ID
         $food = Post::findOrFail($id);

        //delete image
        Storage::delete('public/foods/'. $food->image);

        //delete post
        $food->delete();

        //redirect to index
        return redirect()->route('foods.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}  