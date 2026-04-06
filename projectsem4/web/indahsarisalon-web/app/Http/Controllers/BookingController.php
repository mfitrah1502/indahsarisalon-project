<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\User;
use App\Models\Treatment;
use Carbon\Carbon;

class BookingController extends Controller
{
    // STEP 0: Halaman daftar treatment
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Treatment::with(['details','category']);

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->search) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $treatments = $query->get();

        return view('booking.index', compact('treatments', 'categories'));
    }

    // STEP 1: Pilih stylist & waktu
    public function select($treatmentId)
{
    $treatment = Treatment::with('details')->findOrFail($treatmentId);
    $stylists = User::where('role', 'karyawan')->get();

    return view('booking.select', compact('treatment', 'stylists'));
}
    // STEP 2: Simpan booking
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'treatment_id' => 'required|exists:treatments,id',
            'stylist_id' => 'nullable|exists:users,id',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required'
        ]);

        $treatment = Treatment::with('details')->findOrFail($request->treatment_id);
        $stylist = $request->stylist_id ? User::find($request->stylist_id) : null;

        $total_price = 0;
        $booking_details = [];

        foreach ($treatment->details as $detail) {
            $price = $detail->price;
            
            // Logika custom jika detail mengaktifkan harga stylist khusus
            if ($detail->has_stylist_price) {
                if ($stylist && strtolower($stylist->kategori) == 'senior') {
                    $price = $detail->price_senior ?? $price;
                } elseif ($stylist && strtolower($stylist->kategori) == 'junior') {
                    $price = $detail->price_junior ?? $price;
                }
            }

            $booking_details[] = [
                'treatment_detail_id' => $detail->id,
                'price' => $price
            ];
            $total_price += $price;
        }

        $booking = Booking::create([
            'user_id' => Auth::id(), // ID Akun pembuat booking
            'customer_name' => $request->customer_name,
            'cashier_id' => Auth::id(), // Kasir yang login saat itu
            'stylist_id' => $request->stylist_id,
            'treatment_id' => $request->treatment_id,
            'reservation_datetime' => Carbon::parse($request->reservation_date.' '.$request->reservation_time),
            'total_price' => $total_price,
            'status' => 'pending',
            'payment_status' => 'unpaid'
        ]);

        foreach ($booking_details as $item) {
            BookingDetail::create([
                'booking_id' => $booking->id,
                'treatment_detail_id' => $item['treatment_detail_id'],
                'price' => $item['price']
            ]);
        }

        return redirect()->route('booking.summary', $booking->id);
    }

    // STEP 3: Ringkasan booking
    public function summary($bookingId)
    {
        $booking = Booking::with(['user','stylist','treatment','details.treatmentDetail'])
                    ->findOrFail($bookingId);

        return view('booking.summary', compact('booking'));
    }

    // STEP 4: Bayar
    public function pay(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $booking->payment_status = 'paid';
        $booking->status = 'confirmed';
        $booking->save();

        return redirect()->route('booking.history')->with('success','Pembayaran berhasil!');
    }

    // Riwayat booking
    public function history()
    {
        $bookings = Booking::with(['treatment','stylist'])
                    ->where('user_id', Auth::id())
                    ->orderBy('reservation_datetime','desc')
                    ->get();

        return view('booking.history', compact('bookings'));
    }
}