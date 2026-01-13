<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProjectStoreRequest;
use App\Http\Requests\Admin\ProjectUpdateRequest;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with('category')
            ->latest()
            ->paginate(10);

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.projects.create', compact('categories'));
    }

    public function store(ProjectStoreRequest $request): RedirectResponse
    {
        $data = $this->buildProjectData($request);
        Project::create($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project): View
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(ProjectUpdateRequest $request, Project $project): RedirectResponse
    {
        $data = $this->buildProjectData($request, $project);
        $project->update($data);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->deleteProjectImages($project);
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    private function buildProjectData(ProjectStoreRequest|ProjectUpdateRequest $request, ?Project $project = null): array
    {
        $data = $request->validated();
        $data['tags'] = $this->normalizeTags($data['tags'] ?? null);
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('cover_image')) {
            if ($project?->cover_image) {
                $this->deleteImage($project->cover_image);
                $this->deleteImage($this->thumbnailPath($project->cover_image));
            }
            $data['cover_image'] = $this->storeImage($request->file('cover_image'), 'projects/covers');
            $this->generateThumbnail($data['cover_image']);
        } elseif ($project) {
            $data['cover_image'] = $project->cover_image;
        }

        if ($request->hasFile('gallery_images')) {
            if ($project?->gallery_images) {
                foreach ($project->gallery_images as $galleryImage) {
                    $this->deleteImage($galleryImage);
                }
            }
            $data['gallery_images'] = $this->storeGalleryImages($request->file('gallery_images'));
        } elseif ($project) {
            $data['gallery_images'] = $project->gallery_images;
        }

        if ($request->hasFile('before_image')) {
            if ($project?->before_image) {
                $this->deleteImage($project->before_image);
            }
            $data['before_image'] = $this->storeImage($request->file('before_image'), 'projects/before-after');
        } elseif ($project) {
            $data['before_image'] = $project->before_image;
        }

        if ($request->hasFile('after_image')) {
            if ($project?->after_image) {
                $this->deleteImage($project->after_image);
            }
            $data['after_image'] = $this->storeImage($request->file('after_image'), 'projects/before-after');
        } elseif ($project) {
            $data['after_image'] = $project->after_image;
        }

        return $data;
    }

    private function storeImage(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, 'public');
    }

    private function storeGalleryImages(array $files): array
    {
        $paths = [];

        foreach ($files as $file) {
            $paths[] = $this->storeImage($file, 'projects/gallery');
        }

        return $paths;
    }

    private function normalizeTags(?string $tags): array
    {
        if (!$tags) {
            return [];
        }

        return collect(explode(',', $tags))
            ->map(fn (string $tag) => trim($tag))
            ->filter()
            ->values()
            ->all();
    }

    private function deleteProjectImages(Project $project): void
    {
        if ($project->cover_image) {
            $this->deleteImage($project->cover_image);
            $this->deleteImage($this->thumbnailPath($project->cover_image));
        }

        if ($project->gallery_images) {
            foreach ($project->gallery_images as $galleryImage) {
                $this->deleteImage($galleryImage);
            }
        }

        if ($project->before_image) {
            $this->deleteImage($project->before_image);
        }

        if ($project->after_image) {
            $this->deleteImage($project->after_image);
        }
    }

    private function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    private function generateThumbnail(string $path, int $targetWidth = 640): ?string
    {
        $disk = Storage::disk('public');

        if (!$disk->exists($path)) {
            return null;
        }

        $imageData = $disk->get($path);
        $image = @imagecreatefromstring($imageData);

        if (!$image) {
            $thumbPath = $this->thumbnailPath($path);
            $disk->copy($path, $thumbPath);

            return $thumbPath;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width === 0 || $height === 0) {
            imagedestroy($image);

            return null;
        }

        $ratio = $height / $width;
        $targetHeight = (int) round($targetWidth * $ratio);

        $thumbnail = imagecreatetruecolor($targetWidth, $targetHeight);
        imagecopyresampled($thumbnail, $image, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);

        $thumbPath = $this->thumbnailPath($path);
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        ob_start();
        switch ($extension) {
            case 'png':
                imagepng($thumbnail);
                break;
            case 'webp':
                imagewebp($thumbnail);
                break;
            default:
                imagejpeg($thumbnail, null, 85);
                break;
        }
        $thumbnailData = ob_get_clean();

        $disk->put($thumbPath, $thumbnailData);

        imagedestroy($image);
        imagedestroy($thumbnail);

        return $thumbPath;
    }

    private function thumbnailPath(string $path): string
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        $base = substr($path, 0, -strlen($extension) - 1);

        return $base.'_thumb.'.$extension;
    }
}
