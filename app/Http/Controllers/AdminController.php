<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalTeachers = Teacher::active()->count();
        $votedTeachers = Teacher::active()->where('has_voted', true)->count();
        $notVotedTeachers = $totalTeachers - $votedTeachers;
        $participationPct = $totalTeachers > 0
            ? round(($votedTeachers / $totalTeachers) * 100, 1)
            : 0;
        $totalVotes = Vote::count();
        $votingOpen = Setting::get('voting_open', '1') === '1';
        $pendingTeachers = Teacher::active()->where('has_voted', false)->orderBy('name')->get();

        return view('admin.dashboard', compact(
            'totalTeachers', 'votedTeachers', 'notVotedTeachers',
            'participationPct', 'totalVotes', 'votingOpen', 'pendingTeachers'
        ));
    }

    public function results()
    {
        $categories = Category::active()->with(['votes.nominee'])->get();

        $categoryResults = $categories->map(function ($category) {
            $results = $category->votes
                ->groupBy('nominee_id')
                ->map(function ($votes) {
                    return [
                        'teacher' => $votes->first()->nominee,
                        'votes'   => $votes->count(),
                    ];
                })
                ->sortByDesc('votes')
                ->values();

            return [
                'category' => $category,
                'results'  => $results,
                'winner'   => $results->first(),
            ];
        });

        return view('admin.results', compact('categoryResults'));
    }

    public function analytics()
    {
        $categories = Category::active()->get();
        $teachers   = Teacher::active()->orderBy('name')->get();
        $chartData  = [];

        foreach ($categories as $category) {
            $voteCounts = Vote::where('category_id', $category->id)
                ->select('nominee_id', DB::raw('count(*) as total'))
                ->groupBy('nominee_id')
                ->with('nominee')
                ->get()
                ->mapWithKeys(fn($v) => [$v->nominee->name ?? 'Unknown' => $v->total]);

            $chartData[] = [
                'category' => $category->name,
                'labels'   => $voteCounts->keys()->toArray(),
                'data'     => $voteCounts->values()->toArray(),
            ];
        }

        $participationData = [
            'voted'     => Teacher::active()->where('has_voted', true)->count(),
            'not_voted' => Teacher::active()->where('has_voted', false)->count(),
        ];

        return view('admin.analytics', compact('chartData', 'participationData', 'categories'));
    }

    public function openVoting()
    {
        Setting::set('voting_open', '1');
        return back()->with('success', 'Voting has been opened successfully.');
    }

    public function closeVoting()
    {
        Setting::set('voting_open', '0');
        return back()->with('success', 'Voting has been closed successfully.');
    }

    public function resetVoting()
    {
        Vote::truncate();
        Teacher::query()->update(['has_voted' => false]);
        return back()->with('success', 'All votes have been reset successfully.');
    }

    public function teachers()
    {
        $teachers = Teacher::orderBy('name')->get();
        return view('admin.teachers', compact('teachers'));
    }

    public function addTeacher(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100|unique:teachers,name']);
        Teacher::create(['name' => $request->name, 'is_active' => true]);
        return back()->with('success', "Teacher '{$request->name}' added successfully.");
    }

    public function updateTeacher(Request $request, Teacher $teacher)
    {
        $request->validate(['name' => 'required|string|max:100|unique:teachers,name,' . $teacher->id]);
        $teacher->update(['name' => $request->name]);
        return back()->with('success', 'Teacher name updated successfully.');
    }

    public function toggleTeacher(Teacher $teacher)
    {
        $teacher->update(['is_active' => !$teacher->is_active]);
        $status = $teacher->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Teacher has been {$status}.");
    }

    public function deleteTeacher(Teacher $teacher)
    {
        $teacher->delete();
        return back()->with('success', 'Teacher removed successfully.');
    }

    public function exportCsv()
    {
        $categories = Category::active()->get();
        $teachers   = Teacher::active()->orderBy('name')->get();

        $lines = ["Teacher Excellence Awards - Results\n"];
        $lines[] = "Generated: " . now()->format('Y-m-d H:i:s') . "\n\n";

        foreach ($categories as $category) {
            $lines[] = "Category: {$category->name}\n";
            $lines[] = "Teacher,Votes,Percentage\n";

            $totalVotes = Vote::where('category_id', $category->id)->count();
            $results    = Vote::where('category_id', $category->id)
                ->select('nominee_id', DB::raw('count(*) as total'))
                ->groupBy('nominee_id')
                ->with('nominee')
                ->orderByDesc('total')
                ->get();

            foreach ($results as $result) {
                $pct     = $totalVotes > 0 ? round(($result->total / $totalVotes) * 100, 1) : 0;
                $lines[] = "{$result->nominee->name},{$result->total},{$pct}%\n";
            }
            $lines[] = "\n";
        }

        $lines[] = "Participation Summary\n";
        $lines[] = "Total Teachers," . Teacher::active()->count() . "\n";
        $lines[] = "Voted," . Teacher::active()->where('has_voted', true)->count() . "\n";
        $lines[] = "Not Voted," . Teacher::active()->where('has_voted', false)->count() . "\n";

        $content  = implode('', $lines);
        $filename = 'teacher-awards-results-' . now()->format('Y-m-d') . '.csv';

        return response($content, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ]);
    }

    public function printResults()
    {
        $categories = Category::active()->get();
        $categoryResults = $categories->map(function ($category) {
            $results = Vote::where('category_id', $category->id)
                ->select('nominee_id', DB::raw('count(*) as total'))
                ->groupBy('nominee_id')
                ->with('nominee')
                ->orderByDesc('total')
                ->get();

            $totalVotes = $results->sum('total');
            return [
                'category'   => $category,
                'results'    => $results,
                'totalVotes' => $totalVotes,
            ];
        });

        $stats = [
            'total'      => Teacher::active()->count(),
            'voted'      => Teacher::active()->where('has_voted', true)->count(),
            'not_voted'  => Teacher::active()->where('has_voted', false)->count(),
        ];

        return view('admin.print', compact('categoryResults', 'stats'));
    }
}
