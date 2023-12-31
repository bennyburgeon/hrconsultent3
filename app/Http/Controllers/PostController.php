<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Laracasts\Flash\Flash;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PostController extends AppBaseController
{
    /** @var PostRepository */
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * Display a listing of the Blog.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('blogs.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $blogCategories = PostCategory::orderBy('name')->toBase()->pluck('name', 'id');

        return view('blogs.create', compact('blogCategories'));
    }

    /**
     * Store a newly created Blog in storage.
     *
     * @param  CreatePostRequest  $request
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function store(CreatePostRequest $request)
    {
        $input = $request->all();
 
        $blog = $this->postRepository->store($input);

        Flash::success(__('messages.flash.post_save'));

        return redirect(route('posts.index'));
    }

    /**
     * Show the form for editing the specified Blog.
     *
     * @param  Post  $post
     *
     * @return Application|Factory|View
     */
    public function show(Post $post)
    {
        return view('blogs.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     *
     * @return Application|Factory|View
     */
    public function edit(Post $post)
    {
        $selectedBlogCategories = $post->postAssignCategories()->pluck('post_categories_id');
        $blogCategories = PostCategory::orderBy('name')->pluck('name', 'id');

        return view('blogs.edit', compact('blogCategories', 'post', 'selectedBlogCategories'));
    }

    /**
     * Update the specified Blog in storage.
     *
     * @param  UpdatePostRequest  $request
     *
     * @param  Post  $post
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $input = $request->all();
        
        $this->postRepository->updateBlog($post, $input);

        Flash::success(__('messages.flash.post_update'));

        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified Blog from storage.
     *
     * @param  Post  $post
     *
     * @return JsonResource
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return $this->sendSuccess(__('messages.flash.post_delete'));
    }

    /**
     * @param $media
     *
     * @return Media
     */
    public function downloadPost($media): Media
    {
        return Media::findOrFail($media);
    }

    /**
     * @param  Request  $request
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View
     */
    public function getAllComments()
    {
        return view('post_comments.index');
    }

    /**
     * @param  int  $id
     *
     * @return JsonResponse
     */
    public function showComment(int $id): JsonResponse
    {
        $postComment = PostComment::with('post')->findOrFail($id);

        return $this->sendResponse($postComment, __('messages.flash.post_comment'));
    }
}
