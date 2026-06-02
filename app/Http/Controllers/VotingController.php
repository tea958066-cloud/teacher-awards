<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Setting;
use App\Models\Teacher;
use App\Models\Vote;
use Illuminate\Http\Request;

class VotingController extends Controller
{
    public function welcome()
    {
        $votingOpen = Setting::get('voting_open', '1') === '1';
        return view('voting.welcome', compact('votingOpen'));
    }

    public function selectTeacher()
    {
        $votingOpen = Setting::get('voting_open', '1') === '1';
        if (!$votingOpen) {
            return redirect()->route('welcome')->with('error', 'Voting is currently closed.');
        }
        $teachers = Teacher::active()->orderBy('name')->get();
        return view('voting.select', compact('teachers'));
    }

    public function processSelect(Request $request)
    {
        $votingOpen = Setting::get('voting_open', '1') === '1';
        if (!$votingOpen) {
            return redirect()->route('welcome')->with('error', 'Voting is currently closed.');
        }

        $request->validate(['teacher_id' => 'required|exists:teachers,id']);

        $teacher = Teacher::findOrFail($request->teacher_id);

        if ($teacher->has_voted) {
            return redirect()->route('vote.select')
                ->with('error', 'You have already voted. Each teacher may only vote once.');
        }

        session(['voter_id' => $teacher->id, 'voter_name' => $teacher->name]);
        return redirect()->route('vote.rules');
    }

    public function rules()
    {
        if (!session('voter_id')) {
            return redirect()->route('vote.select');
        }
        return view('voting.rules');
    }

    public function agreeRules(Request $request)
    {
        if (!session('voter_id')) {
            return redirect()->route('vote.select');
        }

        $request->validate(['agree' => 'required|accepted']);
        session(['rules_agreed' => true]);
        return redirect()->route('vote.cast');
    }

    public function castVote()
    {
        if (!session('voter_id') || !session('rules_agreed')) {
            return redirect()->route('vote.select');
        }

        $votingOpen = Setting::get('voting_open', '1') === '1';
        if (!$votingOpen) {
            return redirect()->route('welcome')->with('error', 'Voting is currently closed.');
        }

        $voter = Teacher::findOrFail(session('voter_id'));
        if ($voter->has_voted) {
            session()->forget(['voter_id', 'voter_name', 'rules_agreed']);
            return redirect()->route('welcome')->with('error', 'You have already voted.');
        }

        $categories = Category::active()->get();
        $teachers = Teacher::active()->orderBy('name')->get();

        return view('voting.cast', compact('categories', 'teachers', 'voter'));
    }

    public function submitVote(Request $request)
    {
        if (!session('voter_id') || !session('rules_agreed')) {
            return redirect()->route('vote.select');
        }

        $votingOpen = Setting::get('voting_open', '1') === '1';
        if (!$votingOpen) {
            return redirect()->route('welcome')->with('error', 'Voting is currently closed.');
        }

        $voter = Teacher::findOrFail(session('voter_id'));
        if ($voter->has_voted) {
            session()->forget(['voter_id', 'voter_name', 'rules_agreed']);
            return redirect()->route('welcome')->with('error', 'You have already voted.');
        }

        $categories = Category::active()->get();
        $rules = ['votes' => 'required|array'];
        foreach ($categories as $category) {
            $rules["votes.{$category->id}"] = 'required|exists:teachers,id';
        }

        $validated = $request->validate($rules);

        foreach ($validated['votes'] as $categoryId => $nomineeId) {
            if ($nomineeId == $voter->id) {
                return back()->withErrors(['votes' => 'You cannot vote for yourself in any category.'])->withInput();
            }
        }

        foreach ($validated['votes'] as $categoryId => $nomineeId) {
            Vote::create([
                'voter_id'    => $voter->id,
                'nominee_id'  => $nomineeId,
                'category_id' => $categoryId,
            ]);
        }

        $voter->update(['has_voted' => true]);
        session()->forget(['voter_id', 'voter_name', 'rules_agreed']);

        return redirect()->route('vote.thankyou');
    }

    public function thankyou()
    {
        return view('voting.thankyou');
    }
}
