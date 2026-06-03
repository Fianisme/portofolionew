<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ContentService;

class DashboardController extends Controller
{
    public function index(ContentService $content)
    {
        return view('admin.dashboard', [
            'title' => 'Admin Dashboard',
            'projects' => $content->getAll('projects'),
            'articles' => $content->getAll('articles'),
            'certificates' => $content->getAll('certificates'),
        ]);
    }
}
