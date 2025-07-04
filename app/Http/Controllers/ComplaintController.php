<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Hamlet;
use App\Models\InfrastructureCategory;
use App\Models\RT;
use App\Models\RW;
use App\Notifications\ComplaintCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ComplaintController extends Controller
{
    public function index()
    {
        $pending = Complaint::where('status_complaint', 'pending')->count();
        $processed = Complaint::where('status_complaint', 'process')->count();
        $finished = Complaint::where('status_complaint', 'done')->count();

        $total = $processed + $finished + $pending;

        $processedPercentage = $total > 0 ? round(($processed / $total) * 100, 1) : 0;
        $finishedPercentage = $total > 0 ? round(($finished / $total) * 100, 1) : 0;
        $pendingPercentage = $total > 0 ? round(($pending / $total) * 100, 1) : 0;

        return view('complaints.index', compact(
            'processedPercentage',
            'finishedPercentage',
            'pendingPercentage'
        ));
    }

    public function create()
    {
        $hamlets = Hamlet::all();
        $categories = InfrastructureCategory::where('is_active', true)->get();

        return view('complaints.create', compact('hamlets', 'categories'));
    }

    public function getRW($hamletId)
    {
        $rw = RW::where('hamlet_id', $hamletId)->get();
        return response()->json($rw);
    }

    public function getRT($hamletId, $rwId)
    {
        $rt = RT::where('hamlet_id', $hamletId)
            ->where('rw_id', $rwId)
            ->get();
        return response()->json($rt);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'hamlet' => 'required|string',
            'rw' => 'required|string',
            'rt' => 'required|string',
            'infrastructure_category' => 'required|string',
            'description' => 'required|string',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        // Buat kode aduan
        $last = Complaint::latest('id')->first();
        $number = $last ? intval(substr($last->complaints_code, -4)) + 1 : 1;
        $data['complaints_code'] = 'ADUAN-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $data['photo'] = $request->file('photo')->store('complaints', 'public');
        $data['date_time'] = now();
        // Simpan ke database
        $complaint = Complaint::create($data);

        if ($complaint->email) {
            Notification::route('mail', $complaint->email)
                ->notify(new ComplaintCreatedNotification($complaint));
        }

        // 

        return redirect('/')->with([
            'success' => 'Aduan berhasil dikirim!',
            'complaints_code' => $data['complaints_code']
        ]);
    }

    public function track(Request $request)
    {
        $request->validate([
            'complaints_code' => 'required|string'
        ]);

        return redirect()->route('complaints.track', ['complaints_code' => $request->complaints_code]);
    }

    public function trackCode($complaints_code)
    {
        $complaint = Complaint::where('complaints_code', $complaints_code)->first();
        $searchedCode = $complaints_code;

        $pending = Complaint::where('status_complaint', 'pending')->count();
        $processed = Complaint::where('status_complaint', 'process')->count();
        $finished = Complaint::where('status_complaint', 'done')->count();

        $total = $pending + $processed + $finished;

        $processedPercentage = $total > 0 ? round(($processed / $total) * 100, 1) : 0;
        $finishedPercentage = $total > 0 ? round(($finished / $total) * 100, 1) : 0;
        $pendingPercentage = $total > 0 ? round(($pending / $total) * 100, 1) : 0;

        return view('complaints.index', compact(
            'complaint',
            'searchedCode',
            'processedPercentage',
            'finishedPercentage',
            'pendingPercentage'
        ));
    }
}
