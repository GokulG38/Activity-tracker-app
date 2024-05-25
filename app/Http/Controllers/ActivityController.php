<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->query('date');
        $activity = Activity::when($selectedDate, function ($query) use ($selectedDate) {
            return $query->whereDate('date', $selectedDate);
        })->latest()->get();

        return view('activity', compact('activity'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'completed' => 'nullable|boolean', 
        ]);

        $activityId = $request->input('activityId');

        if ($activityId) {
            $activity = Activity::findOrFail($activityId);

            $activity->update($validatedData);
        } else {
            Activity::create($validatedData);
        }
    
        return redirect()->route('activity.index')->with('success', 'Activity ' . ($activityId ? 'updated' : 'created') . ' successfully.');
    }
    public function update(Request $request, $id)
{
    $activity = Activity::findOrFail($id);

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'date' => 'required|date',
        'description' => 'required|string|max:255',
        'completed' => 'nullable|boolean', 
    ]);

    $validatedData['completed'] = $request->filled('completed');

    $activity->update($validatedData);

    return redirect()->route('activity.index')->with('success', 'Activity updated successfully');
}

    
    public function delete($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
        return redirect()->back()->with('success', 'Activity deleted successfully');
    }


    public function markAsDone($id)
    {
        $activity = Activity::findorFail($id);
        $activity->completed = true;
        $activity->save();
        return redirect()->back()->with('success', 'Activity updated successfully.');
    }
}
