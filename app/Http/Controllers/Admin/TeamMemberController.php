<?php

namespace App\Http\Controllers\Admin;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;

class TeamMemberController extends Controller
{
    public function index()
    {
        $pageTitle = "Team Members Create";
        $members = Team::orderBy('order')->get();
        return view('admin.team.index', compact('members', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = "Team Member Create";
        return view('admin.team.create',  compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        Team::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member added successfully.');
    }

    public function edit(Team $team)
    {
        $pageTitle = "Team Member Create";
        return view('admin.team.edit', compact('team', 'pageTitle'));
    }

    public function update(Request $request, Team $team)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($team->photo) {
                Storage::disk('public')->delete($team->photo);
            }
            $data['photo'] = $request->file('photo')->store('team', 'public');
        }

        $team->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Team member updated successfully.');
    }

    public function destroy(Team $team)
    {
        if ($team->photo) {
            Storage::disk('public')->delete($team->photo);
        }

        $team->delete();

        return redirect()->route('admin.team.index')->with('success', 'Team member deleted.');
    }
}
