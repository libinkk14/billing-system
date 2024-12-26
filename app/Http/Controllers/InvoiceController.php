<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Contracts\Process\InvokedProcess;
use PDF;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = Carbon::now()->format('Y-m-d');
        $service = Service::all();
        return view('billing.index')->with(['today' => $today, 'services' => $service]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $customer = Customer::create([
            'name' => $request->customer_name,
            'phone' => $request->customer_phone ?? null,
            'address' => $request->customer_address,
        ]);

        $invoiceNumber = $this->generateInvoiceNumber();

        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'customer_id' => $customer->id,
            'invoice_date' => $request->invoice_date,
            'total_hours' => $request->total_hours,
            'sub_total' => $request->invoice_amount,
            'tax_amount' => $request->total_vat ?? null,
            'total_discount' => $request->total_discount ?? null,
            'grand_total' => $request->grand_total,
            'notes' => $request->additional_notes,
        ]);

        foreach ($request->service as $index) {
            $service = $request->service[$index];
            $hours = $request->hours[$index];
            $price = $request->price[$index];
            $total = $request->total[$index];

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'service_id' => $service,
                'hours_used' => $hours,
                'rate_per_hour' => $price,
                'total' => $total,
            ]);
        }

        return redirect()->back()->with([
            'success' => 'Invoice generated successfully!',
            'invoice_link' => route('generate.invoice', $invoice->id),
        ]);
    }

    public function generateInvoice($id)
    {
        $invoice = Invoice::with(['customer', 'invoiceItems.service'])->find($id);

        if (!$invoice) {
            return response()->json(['message' => 'Invoice not found'], 404);
        }

        $data = [
            'customer' => [
                'name' => $invoice->customer->name,
                'phone' => $invoice->customer->phone,
                'address' => $invoice->customer->address,
            ],
            'invoice' => [
                'invoice_number' => $invoice->invoice_number,
                'invoice_date' => $invoice->invoice_date,
                'total_hours' => $invoice->total_hours,
                'sub_total' => $invoice->sub_total,
                'tax_amount' => $invoice->tax_amount,
                'total_discount' => $invoice->total_discount,
                'grand_total' => $invoice->grand_total,
                'notes' => $invoice->notes,
            ],
            'invoice_items' => $invoice->invoiceItems->map(function ($item) {
                return [
                    'service_name' => $item->service->service_name,
                    'hourly_rate' => $item->service->hourly_rate,
                    'hours_used' => $item->hours_used,
                    'rate_per_hour' => $item->rate_per_hour,
                    'total' => $item->total,
                ];
            }),
        ];

        $pdf = PDF::loadView('invoice.invoice', compact('data'));
        return $pdf->stream($invoice->invoice_number . '-invoice.pdf');
    }

    public function checkInvoice()
    {
        return view('invoice.check-invoice');
    }

    public function checkInvoicePost(Request $request)
    {
        $invoiceNumber = $request->invoiceNumber;

        $invoice = Invoice::where('invoice_number', $invoiceNumber)->first();

        if (!$invoice) {
            return redirect()->back()->with(['error' => 'Invoice number not found.']);
        }

        return redirect()->route('generate.invoice', ['id' => $invoice->id]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function generateInvoiceNumber()
    {
        $today = Carbon::today();
        $formattedDate = $today->format('ymd');

        $lastInvoice = Invoice::whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->first();

        $serialNumber = $lastInvoice ? intval(substr($lastInvoice->invoice_number, -4)) + 1 : 1;

        $formattedSerialNumber = str_pad($serialNumber, 4, '0', STR_PAD_LEFT);

        return "INV-{$formattedDate}{$formattedSerialNumber}";
    }
}
