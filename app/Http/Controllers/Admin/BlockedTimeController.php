<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlockedTimeController extends Controller
{
    public function index(): View
    {
        $blockedTimes = BlockedTime::query()
            ->orderByDesc('start_at')
            ->get();

        return view('admin.blocked-times.index', compact('blockedTimes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'reason' => ['nullable', 'string', 'max:255'],
        ]);

        BlockedTime::query()->create($data);

        return redirect()
            ->route('admin.blocked-times.index')
            ->with('success', 'Blocked time added.');
    }

    public function destroy(BlockedTime $blockedTime): RedirectResponse
    {
        $blockedTime->delete();

        return redirect()
            ->route('admin.blocked-times.index')
            ->with('success', 'Blocked time removed.');
    }
}
