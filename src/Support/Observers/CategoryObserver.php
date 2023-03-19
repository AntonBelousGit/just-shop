<?php

declare(strict_types=1);

namespace Support\Observers;

use Domain\Catalog\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function created(Category $category): void
    {
        Cache::forget('category_home_page');
    }

    public function updated(Category $category): void
    {
        Cache::forget('category_home_page');
    }

    public function deleted(Category $category): void
    {
        Cache::forget('category_home_page');
    }

    public function restored(Category $category): void
    {
    }

    public function forceDeleted(Category $category): void
    {
    }
}
