<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use Livewire\WithPagination;

class ArticleIndexPage extends Component
{
    use WithPagination;

    public string $search = '';
    public string $selectedCategory = 'all'; // 'all', 'Info Visa', 'Tips Tour', 'Panduan Travel', 'Destinasi'

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function selectCategory(string $category): void
    {
        $this->selectedCategory = $category;
        $this->resetPage();
    }

    public function render()
    {
        $categories = ['all' => 'Semua Artikel', 'Info Visa' => 'Info Visa', 'Tips Tour' => 'Tips Tour', 'Panduan Travel' => 'Panduan Travel', 'Destinasi' => 'Destinasi'];

        $articlesQuery = Article::query()
            ->where('is_published', true)
            ->when($this->search !== '', function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedCategory !== 'all', function ($query) {
                $query->where('category', $this->selectedCategory);
            });

        $articles = $articlesQuery->orderBy('published_at', 'desc')->paginate(6);

        return view('livewire.article-index-page', [
            'articles'   => $articles,
            'categories' => $categories,
        ])->layout('components.layouts.app', [
            'title' => 'Artikel & Edukasi Wisata | TravelGo'
        ]);
    }
}
