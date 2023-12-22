<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        return inertia('Loans/Index', [
            'loans' => Loan::all(),
        ]);
    }

    public function create()
    {
        return inertia('Loans/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'amount' => 'required|numeric',
            'due_date' => 'required|date',
        ]);

        Loan::create($request->all());

        return redirect()->route('loans.index');
    }
}
