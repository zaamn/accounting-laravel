<?php

namespace App\Http\Controllers;

use PDF;
use Toastr;
use App\Sale;
use App\Invoice;
use App\Product;
use App\Customer;
use Carbon\Carbon;
use App\InvoiceCart;
use Illuminate\Http\Request;

class AccountingController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function createCustomer(){
        return view('main.customer.customer-create');
    }

    public function storeCustomer(Request $request){
        $this->validate($request,[
            'name' => 'required|string',
            'email' => 'required|string|email|unique:customers',
            'address' => 'required|string',
        ]);

        $customer_id = Customer::insertGetId([
            'name' => $request->name,
            'email' => strtolower(trim($request->email)),
            'address' => $request->address,
            'created_at' => Carbon::now(),
        ]);
        session()->put('customer_id',$customer_id);
        session()->flash('status', 'Customer Successfully Added');
        return redirect()->route('invoice.create');
    }

    public function createProduct(){
        return view('main.product.product-create');
    }

    public function storeProduct(Request $request){
        $this->validate($request,[
            'product_name' => 'required|string',
            'category' => 'required|string|',
            'description' => 'required',
        ]);
        Product::insert([
            'product_name' => $request->product_name,
            'category' => $request->category,
            'description' => $request->description,
            'created_at' => Carbon::now(),
        ]);
        session()->flash('status', 'Product Successfully Added');
        return redirect()->back();
    }


    public function createInvoice(){
        $customers = Customer::all();
        $products = Product::all();
        $invoices = InvoiceCart::latest()->get();
        return view('main.invoice.invoice-create', [
            'customers' => $customers,
            'products' => $products,
            'invoices' => $invoices,
        ]);
    }

    public function invoiceCart(Request $request){

        //return response()->json($request->all(),200);
        $this->validate($request,[
            'customer' => 'required|string',
            'currency' => 'required|string',
            'date_time' => 'required',
            'item_code' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'unit_price' => 'required',
            'discount' => 'required',
            'total_price' => 'required',
        ]);

        InvoiceCart::insert([
            'customer' => $request->customer,
            'currency' => $request->currency,
            'date_time' => $request->date_time,
            'item_code' => $request->item_code,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'discount' => $request->discount,
            'total_price' => $request->total_price,
            'created_at' => Carbon::now(),
        ]);

        if (session()->get('customer_id') != $request->customer){
            session()->forget('customer_id');
            session()->put('customer_id', $request->customer);
        }
        session()->flash('status', 'Product Successfully Added');
        return redirect()->back();

        //return response()->json($request->all(),200);
    }

    public function totalCount(Request $request){
        $pars = $request->unit_price * $request->discount/100;
        $parsVal = $request->unit_price-$pars;
        return $parsVal*$request->quantity;
    }

    public function invoiceCartDelete($id){
        InvoiceCart::where('id', $id)->delete();
        session()->flash('status', 'Product Successfully Deleted');
        return redirect()->back();
    }

    public function invoiceStore(Request $request){
        //return $request->all();
        $invoiceCarts =  InvoiceCart::where('customer', session()->get('customer_id'))->first();
        $invoice_id = Invoice::insertGetId([
            'customer_id' => $invoiceCarts->customer,
            'email' => Customer::where('id', $invoiceCarts->customer)->first()->email,
            'order_date' => $invoiceCarts->date_time ,
            'required_by' => $invoiceCarts->date_time,
            'delivery_to' => Customer::where('id', $invoiceCarts->customer)->first()->name,
            'order_total' => $request->total_amount,
            'order_due' => $request->total_amount,
            'currency' => $invoiceCarts->currency,
            'transaction_id' => substr(md5(time()),0,10).$invoiceCarts->customer,
            'created_at' => Carbon::now(),
        ]);
        foreach (InvoiceCart::where('customer', session()->get('customer_id'))->get() as $invoiceKey => $invoiceCart){
            Sale::insert([
                'invoice_id' => $invoice_id,
                'item_code' => $invoiceCart->item_code,
                'product_id' => $invoiceCart->product_id,
                'quantity' => $invoiceCart->quantity,
                'unit_price' => $invoiceCart->unit_price,
                'discount' => $invoiceCart->discount,
                'sub_total' => $invoiceCart->total_price,
                'created_at' => Carbon::now(),
            ]);
        }
        InvoiceCart::truncate();
        session()->forget('customer_id');
        return redirect()->route('invoice.view');

    }

    public function invoiceCartClear(){
        InvoiceCart::truncate();
        session()->forget('customer_id');
        return back();
    }


    public function invoiceView(){
        $invoices = Invoice::latest()->get();
        return view('main.invoice.invoice-view',['invoices' => $invoices]);
    }

    public function customerInvoiceView($id){
        
        if (Invoice::where('id',$id)->exists()) {
            $invoice =  Invoice::find($id);
            $sales = Sale::where('invoice_id',$id)->get();
            $pdf = PDF::loadView('main.invoice.invoice-download',['invoice' => $invoice, 'sales' => $sales]);
            return $pdf->stream();
        }
        else {
            return redirect()->route('invoice.view');
        }

    }

    public function invoiceDownload($id){
        Sale::where('invoice_id',$id)->get();
    }
}
