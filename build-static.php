<?php

/**
 * Static Site Builder for GitHub Pages
 * Renders Laravel views to static HTML files in docs/
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

// Boot the application and resolve the kernel properly
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$request = Illuminate\Http\Request::capture();
$kernel->handle($request);

use App\Services\ContentService;
use Illuminate\Support\Facades\View;

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
$articles = array_values(array_filter($content->getAll('articles') ?? [], fn($a) => $a['active'] ?? false));
$certificates = array_values(array_filter($content->getAll('certificates') ?? [], fn($c) => $c['active'] ?? false));

// --- Render home page ---
echo "Rendering index.html...\n";
$html = View::make('home', [
    'profile' => $profile,
    'projects' => $projects,
    'articles' => $articles,
    'certificates' => $certificates,
])->render();

// Fix asset paths for static site
$html = preg_replace('/href="http:\/\/:[^"]*\/build\//', 'href="build/', $html);
$html = preg_replace('/src="http:\/\/:[^"]*\/build\//', 'src="build/', $html);
$html = preg_replace('/src="http:\/\/:[^"]*\/images\//', 'src="images/', $html);
$html = preg_replace('/src="http:\/\/:[^"]*\/storage\//', 'src="storage/', $html);
$html = preg_replace('/href="http:\/\/:[^"]*\/storage\//', 'href="storage/', $html);
$html = str_replace('href="/build/', 'href="build/', $html);
$html = str_replace('src="/build/', 'src="build/', $html);
$html = str_replace('src="/images/', 'src="images/', $html);
$html = str_replace('src="/storage/', 'src="storage/', $html);
$html = str_replace('href="/storage/', 'href="storage/', $html);
$html = preg_replace('/href="\/article\/(\d+)"/', 'href="article/$1.html"', $html);
$html = preg_replace('/href="http:\/\/:[^"]*article\/(\d+)[^"]*"/', 'href="article/$1.html"', $html);
$html = str_replace('href="/#', 'href="#', $html);

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

    $articleHtml = preg_replace('/href="http:\/\/:[^"]*\/build\//', 'href="../build/', $articleHtml);
    $articleHtml = preg_replace('/src="http:\/\/:[^"]*\/build\//', 'src="../build/', $articleHtml);
    $articleHtml = preg_replace('/src="http:\/\/:[^"]*\/images\//', 'src="../images/', $articleHtml);
    $articleHtml = preg_replace('/src="http:\/\/:[^"]*\/storage\//', 'src="../storage/', $articleHtml);
    $articleHtml = preg_replace('/href="http:\/\/:[^"]*\/storage\//', 'href="../storage/', $articleHtml);
    $articleHtml = str_replace('href="/build/', 'href="../build/', $articleHtml);
    $articleHtml = str_replace('src="/build/', 'src="../build/', $articleHtml);
    $articleHtml = str_replace('src="/images/', 'src="../images/', $articleHtml);
    $articleHtml = str_replace('src="/storage/', 'src="../storage/', $articleHtml);
    $articleHtml = str_replace('href="/storage/', 'href="../storage/', $articleHtml);
    $articleHtml = str_replace('href="/#article"', 'href="../index.html#article"', $articleHtml);
    $articleHtml = preg_replace('/href="\/article\/(\d+)"/', 'href="$1.html"', $articleHtml);
    $articleHtml = str_replace('href="/"', 'href="../index.html"', $articleHtml);

    file_put_contents($outputDir."/article/{$id}.html", $articleHtml);
}

// --- Copy assets ---
echo "Copying assets...\n";

$buildSrc = __DIR__.'/public/build';
$buildDst = $outputDir.'/build';
if (is_dir($buildSrc)) {
    exec("cp -r {$buildSrc} {$buildDst}");
}

$imagesSrc = __DIR__.'/public/images';
$imagesDst = $outputDir.'/images';
if (is_dir($imagesSrc)) {
    exec("cp -r {$imagesSrc} {$imagesDst}");
}

$storageSrc = __DIR__.'/storage/app/public/uploads';
$storageDst = $outputDir.'/storage/uploads';
if (is_dir($storageSrc)) {
    @mkdir($outputDir.'/storage', 0755, true);
    exec("cp -r {$storageSrc} {$storageDst}");
}

if (file_exists(__DIR__.'/public/favicon.ico')) {
    copy(__DIR__.'/public/favicon.ico', $outputDir.'/favicon.ico');
}

file_put_contents($outputDir.'/.nojekyll', '');

echo "\nDone! Static site built in docs/\n";
echo "Files:\n";
exec("find {$outputDir} -type f | sort", $files);
foreach ($files as $file) {
    $short = str_replace($outputDir.'/', '', $file);
    $size = filesize($file);
    echo sprintf("  %-50s %s\n", $short, formatSize($size));
}

function formatSize($bytes) {
    if ($bytes < 1024) return $bytes . ' B';
    if ($bytes < 1048576) return round($bytes/1024, 1) . ' KB';
    return round($bytes/1048576, 1) . ' MB';
}
