<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_developers = Developer::count();
        $total_projects = Project::count();

        $unassigned_developers = Developer::whereDoesntHave('projects')->orderBy('created_at', 'asc')->limit(3)->get();
        $unassigned_projects = Project::whereDoesntHave('developers')->orderBy('created_at', 'asc')->limit(3)->get();

        return response()->json([
            'total_developers' => $total_developers,
            'total_projects' => $total_projects,
            'unassigned_developers' => $unassigned_developers,
            'unassigned_projects' => $unassigned_projects,
        ], 200);
    }
}
