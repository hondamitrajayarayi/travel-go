<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleDetailPage extends Component
{
    public Article $article;

    public function mount(string $slug)
    {
        $this->article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment views count
        $this->article->increment('views_count');
    }

    public function render()
    {
        $relatedArticles = Article::where('is_published', true)
            ->where('id', '!=', $this->article->id)
            ->where(function ($q) {
                $q->where('category', $this->article->category);
            })
            ->latest()
            ->take(3)
            ->get();

        if ($relatedArticles->count() < 3) {
            $extra = Article::where('is_published', true)
                ->where('id', '!=', $this->article->id)
                ->whereNotIn('id', $relatedArticles->pluck('id'))
                ->latest()
                ->take(3 - $relatedArticles->count())
                ->get();
            $relatedArticles = $relatedArticles->merge($extra);
        }

        return view('livewire.article-detail-page', [
            'relatedArticles' => $relatedArticles,
        ])->layout('components.layouts.app', [
            'title'           => ($this->article->meta_title ?: $this->article->title) . ' | Super Vacation',
            'metaDescription' => $this->article->meta_description
                                    ?: ($this->article->excerpt
                                        ?: strip_tags(substr($this->article->content ?? '', 0, 160))),
            'metaKeywords'    => $this->article->meta_keywords,
            'ogTitle'         => $this->article->meta_title ?: $this->article->title,
            'ogDescription'   => $this->article->meta_description
                                    ?: ($this->article->excerpt
                                        ?: strip_tags(substr($this->article->content ?? '', 0, 160))),
            'ogImage'         => $this->article->og_image
                                    ?: ($this->article->thumbnail ? asset('storage/' . $this->article->thumbnail) : null),
        ]);
    }
}
