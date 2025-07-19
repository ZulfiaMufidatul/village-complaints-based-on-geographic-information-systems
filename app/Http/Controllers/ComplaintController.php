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
use Twilio\Rest\Client;

class ComplaintController extends Controller
{
    public $twilio_id;
    public $twilio_token;
    public $twilio_from_number;

    public function __construct()
    {
        $this->twilio_id = config('services.twilio.sid');
        $this->twilio_token = config('services.twilio.token');
        $this->twilio_from_number = config('services.twilio.whatsapp_from');
    }
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
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'nullable|email',
            'hamlet' => 'required|string',
            'rw' => 'required|string',
            'rt' => 'required|string',
            'infrastructure_category' => 'required|string',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $last = Complaint::latest('id')->first();
        $number = $last ? intval(substr($last->complaints_code, -4)) + 1 : 1;
        $validatedData['complaints_code'] = 'ADUAN-' . str_pad($number, 4, '0', STR_PAD_LEFT);

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('complaints', 'public');
        } else {
            $validatedData['photo'] = '';
        }

        $validatedData['date_time'] = now();

        $complaint = Complaint::create($validatedData);

        if (!empty($complaint->email)) {
            Notification::route('mail', $complaint->email)
                ->notify(new ComplaintCreatedNotification($complaint));
        }

        $client = new Client(
            $this->twilio_id,
            $this->twilio_token
        );

        $client->messages->create('whatsapp:+62895422622021', [
            'from' => 'whatsapp:' . $this->twilio_from_number,
            'body' => 'Terima kasih sudah mengirimkan aduan. Kode aduan Anda: ' . $complaint->complaints_code,
        ]);

        return redirect('/')->with([
            'success' => 'Aduan berhasil dikirim!',
            'complaints_code' => $complaint->complaints_code
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

    public function showDetail($complaints_code)
    {
        $complaint = Complaint::where('complaints_code', $complaints_code)->firstOrFail();

        return view('complaints.detail', compact('complaint'));
    }
}
