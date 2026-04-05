<?php

namespace App\Filament\Resources\BlogPosts\Pages;

use App\Filament\Resources\BlogPosts\BlogPostResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogPost extends CreateRecord
{
    protected static string $resource = BlogPostResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        unset($data['tags']);

        if (isset($data['featured_image']) && is_array($data['featured_image'])) {
            $data['featured_image'] = $data['featured_image'][array_key_first($data['featured_image'])] ?? ($data['featured_image'][0] ?? null);
        }

        return $data;
    }

    protected function afterCreate(): void
    {
        $tags = $this->form->getState()['tags'] ?? [];
        if (! empty($tags)) {
            $this->record->tags()->sync($tags);
        }
    }
}
