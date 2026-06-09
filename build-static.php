<?php

/**
 * Static Site Builder for GitHub Pages
 * Supports Markdown articles from content/articles/ folder
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

use App\Services\ContentService;
use Illuminate\Support\Facades\View;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;

// Setup Markdown converter
$environment = new Environment([]);
$environment->addExtension(new CommonMarkCoreExtension());
$environment->addExtension(new TableExtension());
$environment->addExtension(new AutolinkExtension());
$environment->addExtension(new StrikethroughExtension());
$markdown = new CommonMarkConverter([], $environment);

$content = app(ContentService::class);
$outputDir = __DIR__.'/docs';

// Clean docs directory
if (is_dir($outputDir)) {
    exec("rm -rf {$outputDir}");
}
mkdir($outputDir, 0755, true);

echo "Building static site...\n";

// --- Load data ---
$profile = $content->get('profile') ?? [];
$projects = array_values(array_filter($content->getAll('projects') ?? [], fn($p) => $p['active'] ?? false));
$certificates = array_values(array_filter($content->getAll('certificates') ?? [], fn($c) => $c['active'] ?? false));

// --- Load articles from Markdown files ---
$articles = loadMarkdownArticles(__DIR__.'/content/articles', $markdown);
echo "Loaded " . count($articles) . " article(s) from content/articles/\n";

// --- Render home page ---
echo "Rendering index.html...\n";
$html = View::make('home', [
    'profile' => $profile,
    'projects' => $projects,
    'articles' => $articles,
    'certificates' => $certificates,
])->render();

$html = fixAssetPaths($html, '');

file_put_contents($outputDir.'/index.html', $html);

// --- Render article pages ---
foreach ($articles as $article) {
    $id = $article['id'];
    echo "Rendering article/{$id}.html...\n";
    @mkdir($outputDir.'/article', 0755, true);

    $articleHtml = View::make('article-show', [
        'article' => $article,
        'articles' => $articles,
    ])->render();

    $articleHtml = fixAssetPaths($articleHtml, '../');
    $articleHtml = str_replace('href="/#article"', 'href="../index.html#article"', $articleHtml);
    $articleHtml = preg_replace('/href="\/article\/(\d+)"/', 'href="$1.html"', $articleHtml);
    $articleHtml = preg_replace('/href="http:\/\/:[^"]*article\/(\d+)[^"]*"/', 'href="$1.html"', $articleHtml);
    $articleHtml = str_replace('href="/"', 'href="../index.html"', $articleHtml);

    file_put_contents($outputDir."/article/{$id}.html", $articleHtml);
}

// --- Copy assets ---
echo "Copying assets...\n";

copyDir(__DIR__.'/public/build', $outputDir.'/build');
copyDir(__DIR__.'/public/images', $outputDir.'/images');

$storageSrc = __DIR__.'/storage/app/public/uploads';
if (is_dir($storageSrc)) {
    @mkdir($outputDir.'/storage', 0755, true);
    copyDir($storageSrc, $outputDir.'/storage/uploads');
}

if (file_exists(__DIR__.'/public/favicon.ico')) {
    copy(__DIR__.'/public/favicon.ico', $outputDir.'/favicon.ico');
}

file_put_contents($outputDir.'/.nojekyll', '');
file_put_contents($outputDir.'/CNAME', "fianism.my.id\n");

echo "\nDone! Static site built in docs/\n";
echo "Files:\n";
exec("find {$outputDir} -type f | sort", $files);
foreach ($files as $file) {
    $short = str_replace($outputDir.'/', '', $file);
    $size = filesize($file);
    echo sprintf("  %-55s %s\n", $short, formatSize($size));
}

// ============================================================
// FUNCTIONS
// ============================================================

function loadMarkdownArticles(string $dir, CommonMarkConverter $markdown): array {
    $articles = [];
    if (!is_dir($dir)) return $articles;

    $files = glob($dir.'/*.md');
    $id = 1;

    foreach ($files as $file) {
        $raw = file_get_contents($file);
        $article = parseFrontmatter($raw, $markdown);
        $article['id'] = $id++;
        $article['active'] = true;
        $article['order'] = $article['id'];
        $articles[] = $article;
    }

    // Sort by date descending
    usort($articles, fn($a, $b) => strtotime($b['date'] ?? 'now') - strtotime($a['date'] ?? 'now'));

    // Re-assign IDs after sort
    foreach ($articles as $i => &$article) {
        $article['id'] = $i + 1;
    }

    return $articles;
}

function parseFrontmatter(string $raw, CommonMarkConverter $markdown): array {
    $article = [
        'title' => 'Untitled',
        'excerpt' => '',
        'category' => '',
        'date' => date('Y-m-d'),
        'image' => '',
        'content' => '',
        'link' => null,
    ];

    // Check for YAML frontmatter (--- ... ---)
    if (preg_match('/^---\s*\n(.*?)\n---\s*\n(.*)/s', $raw, $matches)) {
        $frontmatter = $matches[1];
        $body = $matches[2];

        // Parse simple YAML key-value pairs
        foreach (explode("\n", $frontmatter) as $line) {
            if (preg_match('/^(\w+):\s*"?([^"]*)"?$/', $line, $kv)) {
                $article[trim($kv[1])] = trim($kv[2]);
            }
        }
    } else {
        $body = $raw;
    }

    // Convert Markdown to HTML
    $article['content'] = (string) $markdown->convert($body);

    return $article;
}

function fixAssetPaths(string $html, string $prefix): string {
    $html = preg_replace('/href="http:\/\/:[^"]*\/build\//', 'href="'.$prefix.'build/', $html);
    $html = preg_replace('/src="http:\/\/:[^"]*\/build\//', 'src="'.$prefix.'build/', $html);
    $html = preg_replace('/src="http:\/\/:[^"]*\/images\//', 'src="'.$prefix.'images/', $html);
    $html = preg_replace('/src="http:\/\/:[^"]*\/storage\//', 'src="'.$prefix.'storage/', $html);
    $html = preg_replace('/href="http:\/\/:[^"]*\/storage\//', 'href="'.$prefix.'storage/', $html);
    $html = str_replace('href="/build/', 'href="'.$prefix.'build/', $html);
    $html = str_replace('src="/build/', 'src="'.$prefix.'build/', $html);
    $html = str_replace('src="/images/', 'src="'.$prefix.'images/', $html);
    $html = str_replace('src="/storage/', 'src="'.$prefix.'storage/', $html);
    $html = str_replace('href="/storage/', 'href="'.$prefix.'storage/', $html);
    $html = preg_replace('/href="\/article\/(\d+)"/', 'href="'.$prefix.'article/$1.html"', $html);
    $html = preg_replace('/href="http:\/\/:[^"]*article\/(\d+)[^"]*"/', 'href="'.$prefix.'article/$1.html"', $html);
    $html = str_replace('href="/#', 'href="'.$prefix.'#', $html);
    return $html;
}

function copyDir(string $src, string $dst): void {
    if (!is_dir($src)) return;
    @mkdir($dst, 0755, true);
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($items as $item) {
        $target = $dst . '/' . $items->getSubPathName();
        if ($item->isDir()) {
            @mkdir($target, 0755, true);
        } else {
            copy($item, $target);
        }
    }
}

function formatSize(int $bytes): string {
    if ($bytes < 1024) return $bytes . ' B';
    if ($bytes < 1048576) return round($bytes/1024, 1) . ' KB';
    return round($bytes/1048576, 1) . ' MB';
}
