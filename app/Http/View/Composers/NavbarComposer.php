<?php

namespace App\Http\View\Composers;

use App\Services\ContentService;
use Illuminate\View\View;

class NavbarComposer
{
    protected ContentService $content;

    public function __construct(ContentService $content)
    {
        $this->content = $content;
    }

    public function compose(View $view): void
    {
        $view->with('navArticles', $this->content->getActive('articles'));
        $view->with('navProjects', $this->content->getActive('projects'));
        $view->with('navCertificates', $this->content->getActive('certificates'));
    }
}
