<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ContentService
{
    protected string $contentPath;

    public function __construct()
    {
        $this->contentPath = storage_path('app/content');
    }

    /**
     * Read content from JSON file
     */
    public function get(string $type): array
    {
        $path = $this->getContentPath($type);

        if (!File::exists($path)) {
            return [];
        }

        $content = File::get($path);
        return json_decode($content, true) ?? [];
    }

    /**
     * Save content to JSON file
     */
    public function save(string $type, array $data): bool
    {
        $path = $this->getContentPath($type);

        // Create directory if not exists
        if (!File::isDirectory(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return File::put($path, $json) !== false;
    }

    /**
     * Get all items from a collection type
     */
    public function getAll(string $type): array
    {
        $data = $this->get($type);

        // If it's an array of items, return sorted by order
        if (isset($data[0])) {
            usort($data, fn($a, $b) => ($a['order'] ?? 0) - ($b['order'] ?? 0));
        }

        return $data;
    }

    /**
     * Get only active items
     */
    public function getActive(string $type): array
    {
        $data = $this->getAll($type);

        if (isset($data[0])) {
            return array_filter($data, fn($item) => $item['active'] ?? true);
        }

        return $data;
    }

    /**
     * Get single item by ID
     */
    public function find(string $type, int $id): ?array
    {
        $data = $this->getAll($type);

        foreach ($data as $item) {
            if (($item['id'] ?? null) === $id) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Add new item to collection
     */
    public function add(string $type, array $item): array
    {
        $data = $this->get($type);

        // Generate new ID
        $maxId = 0;
        foreach ($data as $existing) {
            if (($existing['id'] ?? 0) > $maxId) {
                $maxId = $existing['id'];
            }
        }
        $item['id'] = $maxId + 1;

        // Set order if not provided
        if (!isset($item['order'])) {
            $item['order'] = count($data) + 1;
        }

        $data[] = $item;
        $this->save($type, $data);

        return $item;
    }

    /**
     * Update existing item
     */
    public function update(string $type, int $id, array $updates): bool
    {
        $data = $this->get($type);

        foreach ($data as &$item) {
            if (($item['id'] ?? null) === $id) {
                $item = array_merge($item, $updates);
                $this->save($type, $data);
                return true;
            }
        }

        return false;
    }

    /**
     * Delete item by ID
     */
    public function delete(string $type, int $id): bool
    {
        $data = $this->get($type);

        $data = array_filter($data, fn($item) => ($item['id'] ?? null) !== $id);

        // Re-index array
        $data = array_values($data);

        return $this->save($type, $data);
    }

    /**
     * Get content file path
     */
    protected function getContentPath(string $type): string
    {
        return $this->contentPath . '/' . $type . '.json';
    }
}
