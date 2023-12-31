<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Employee;
use App\IncomeExpenseHead;
use App\PurchaseRequisition;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class PurchaseRequisitionController extends Controller
{
    //Important properties
    public $parentModel = PurchaseRequisition::class;
    public $parentRoute = 'purchase_requisition';
    public $parentView = "admin.purchase.requisition";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->parentModel::with('branch', 'employee')->orderBy('created_at', 'desc')->paginate(60);
        return view($this->parentView . '.index', $this->get_count())->with('items', $items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['branches'] = Branch::orderBy('created_at', 'desc')->get();
        $data['employees'] = Employee::orderBy('created_at', 'desc')->get();
        $data['income_expense_heads'] = IncomeExpenseHead::orderBy('created_at', 'desc')->get();
        return view($this->parentView . '.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'not_in:0',
            'employee_id' => 'not_in:0',
            'requisition_date' => 'required',
            'required_date' => 'required',
        ]);
        $items = array();
        foreach ($request->income_expense_head_id as $key => $value) {
            if ($value == 0) {
                break;
            }
            $item = array(
                'income_expense_head_id' => $request->income_expense_head_id[$key],
                'income_expense_head_name' => IncomeExpenseHead::find($request->income_expense_head_id[$key])->name,
                'unit' => IncomeExpenseHead::find($request->income_expense_head_id[$key])->unit,
                'description' => $request->description[$key],
                'qntity' => $request->qntity[$key],
                'rate' => $request->rate[$key],
                'amount' => $request->amount[$key],
            );
            array_push($items, $item);
        }
        $array_zip = [
            'items' => $items
        ];
        $item = json_encode($array_zip);
        $this->parentModel::create([
            'branch_id' => $request->branch_id,
            'employee_id' => $request->employee_id,
            'purpose' => $request->purpose,
            'requisition_date' => $request->requisition_date,
            'required_date' => $request->required_date,
            'comment' => $request->comment,
            'contract_person' => $request->contract_person,
            'remark' => $request->remark,
            'item' => $item,
            'amount' => $request->total_requisition_amount,
            'created_by' => auth()->user()->email,
        ]);
        Session::flash('success', "Successfully  Create");
        $this->forget_count();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $item = $this->parentModel::with('branch', 'employee')->where('id', $request->id)->first();
        if (empty($item)) {
            Session::flash('error', "Item not found");
            return redirect()->back();
        }
        $now = new \DateTime();
        $date = $now->format(Config('settings.date_format') . ' h:i:s');
        $extra = array(
            'current_date_time' => $date,
            'module_name' => 'Purchase Requisition'
        );
        return view($this->parentView . '.show')->with('items', $item)->with('extra', $extra);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $items = $this->parentModel::find($id);
        if (empty($items)) {
            Session::flash('error', "Item not found");
            return redirect()->back();
        }
        if (!empty($items->requisition_id)) {
            Session::flash('error', "You can not Edit it. Because this requisition already Confirmed");
            return redirect()->back();
        }
        $data['branches'] = Branch::orderBy('created_at', 'desc')->get();
        $data['employees'] = Employee::orderBy('created_at', 'desc')->get();
        $data['income_expense_heads'] = IncomeExpenseHead::orderBy('created_at', 'desc')->get();
        return view($this->parentView . '.edit', $data)->with('item', $items);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'branch_id' => 'not_in:0',
            'employee_id' => 'not_in:0',
            'requisition_date' => 'required',
            'required_date' => 'required',
        ]);
        $items = array();
        foreach ($request->income_expense_head_id as $key => $value) {
            if ($value == 0) {
                break;
            }
            $item = array(
                'income_expense_head_id' => $request->income_expense_head_id[$key],
                'income_expense_head_name' => IncomeExpenseHead::find($request->income_expense_head_id[$key])->name,
                'unit' => IncomeExpenseHead::find($request->income_expense_head_id[$key])->unit,
                'description' => $request->description[$key],
                'qntity' => $request->qntity[$key],
                'rate' => $request->rate[$key],
                'amount' => $request->amount[$key],
            );
            array_push($items, $item);
        }
        $array_zip = [
            'items' => $items
        ];
        $item = json_encode($array_zip);
        $items = $this->parentModel::find($id);
        $items->branch_id = $request->branch_id;
        $items->employee_id = $request->employee_id;
        $items->purpose = $request->purpose;
        $items->requisition_date = $request->requisition_date;
        $items->required_date = $request->required_date;
        $items->comment = $request->comment;
        $items->contract_person = $request->contract_person;
        $items->remark = $request->remark;
        $items->amount = $request->total_requisition_amount;
        $items->item = $item;
        $items->updated_by = auth()->user()->email;
        $items->save();
        Session::flash('success', "Update Successfully");
        return redirect()->route($this->parentRoute);
    }

    public function pdf(Request $request)
    {
        $item = $this->parentModel::find($request->id);
        if (empty($item)) {
            Session::flash('error', "Item not found");
            return redirect()->back();
        }
        $now = new \DateTime();
        $date = $now->format(Config('settings.date_format') . ' h:i:s');
        $extra = array(
            'current_date_time' => $date,
            'module_name' => 'Vendor Manage'
        );
        $pdf = PDF::loadView($this->parentView . '.pdf', ['items' => $item, 'extra' => $extra])->setPaper('a4', 'landscape');
        //return $pdf->stream('invoice.pdf');
        return $pdf->download($extra['current_date_time'] . '_' . $extra['module_name'] . '.pdf');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $items = $this->parentModel::find($id);
        if (!empty($items->requisition_id)) {
            Session::flash('error', "You can not delete it.Because this requisition already Confirmed");
            return redirect()->back();
        }
        $items->deleted_by = auth()->user()->email;
        $items->delete();
        $this->forget_count();
        Session::flash('success', "Successfully Trashed");
        return redirect()->back();
    }


    public function trashed()
    {
        $items = $this->parentModel::with('branch', 'employee')->onlyTrashed()->paginate(60);
        return view($this->parentView . '.trashed', $this->get_count())->with("items", $items);
    }

    public function restore($id)
    {
        $items = $this->parentModel::onlyTrashed()->where('id', $id)->first();
        if (!empty($items->requisition_id)) {
            Session::flash('error', "You can not Restore it.Because this requisition already Confirmed");
            return redirect()->back();
        }
        $items->restore();
        $this->forget_count();
        Session::flash('success', 'Successfully Restore');
        return redirect()->back();
    }

    public function kill($id)
    {
        $items = $this->parentModel::withTrashed()->where('id', $id)->first();
        if (!empty($items->requisition_id)) {
            Session::flash('error', "You can not delete it.Because this requisition already Confirmed");
            return redirect()->back();
        }
        $items->forceDelete();
        $this->forget_count();
        Session::flash('success', 'Permanently Delete');
        return redirect()->back();
    }

    public function activeSearch(Request $request)
    {
        $request->validate([
            'search' => 'min:1'
        ]);
        $search = $request["search"];
        $items = $this->parentModel::whereHas('branch', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->orWhereHas('employee', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->orWhere('amount', 'like', $search)
            ->orWhere('requisition_id', 'like', $search)
            ->orWhere('requisition_date', 'like', date("m/d/Y", strtotime($search)))
            ->orWhere('required_date', 'like', date("m/d/Y", strtotime($search)))
            ->paginate(60);

        return view($this->parentView . '.index', $this->get_count())
            ->with('items', $items);
    }

    public function trashedSearch(Request $request)
    {
        $request->validate([
            'search' => 'min:1'
        ]);
        $search = $request["search"];
        $items = $this->parentModel::whereHas('branch', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        })
            ->onlyTrashed()
            ->orWhereHas('employee', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })
            ->onlyTrashed()
            ->orWhere('amount', 'like', $search)
            ->onlyTrashed()
            ->orWhere('requisition_id', 'like', $search)
            ->onlyTrashed()
            ->orWhere('requisition_date', 'like', date("m/d/Y", strtotime($search)))
            ->onlyTrashed()
            ->orWhere('required_date', 'like', date("m/d/Y", strtotime($search)))
            ->onlyTrashed()
            ->paginate(60);
        return view($this->parentView . '.trashed', $this->get_count())
            ->with('items', $items);
    }

    //    Fixed Method for all
    public function activeAction(Request $request)
    {
        $request->validate([
            'items' => 'required'
        ]);
        $this->forget_count();
        if ($request->apply_comand_top == 3 || $request->apply_comand_bottom == 3) {
            foreach ($request->items["id"] as $id) {
                $this->destroy($id);
            }
            return redirect()->back();
        } elseif ($request->apply_comand_top == 2 || $request->apply_comand_bottom == 2) {
            foreach ($request->items["id"] as $id) {
                $this->kill($id);
            }
            return redirect()->back();
        } else {
            Session::flash('error', "Something is wrong.Try again");
            return redirect()->back();
        }
    }

    public function trashedAction(Request $request)
    {
        $request->validate([
            'items' => 'required'
        ]);
        $this->forget_count();
        if ($request->apply_comand_top == 1 || $request->apply_comand_bottom == 1) {
            foreach ($request->items["id"] as $id) {
                $this->restore($id);
            }
        } elseif ($request->apply_comand_top == 2 || $request->apply_comand_bottom == 2) {
            foreach ($request->items["id"] as $id) {
                $this->kill($id);
            }
            return redirect()->back();
        } else {
            Session::flash('error', "Something is wrong.Try again");
            return redirect()->back();
        }
        return redirect()->back();
    }

    /**
     * This function return get totals
     *
     * @author      Md. Al-Mahmud <mamun120520@gmail.com>
     * @version     1.0
     * @see         
     * @since       11/12/2022
     * Time         13:18:45
     * @param       
     * @return      
     */
    public function get_count()
    {
        # code...   
        $data = [];
        if (Cache::get('total_purchase_requisitions') && Cache::get('total_purchase_requisitions') != null) {
            $data['total_purchase_requisitions'] = Cache::get('total_purchase_requisitions');
        } else {
            $data['total_purchase_requisitions'] = $this->parentModel::count();
            Cache::put('total_purchase_requisitions', $data['total_purchase_requisitions']);
        }
        if (Cache::get('total_trashed_purchase_requisitions') && Cache::get('total_trashed_purchase_requisitions') != null) {
            $data['total_trashed_purchase_requisitions'] = Cache::get('total_trashed_purchase_requisitions');
        } else {
            $data['total_trashed_purchase_requisitions'] = $this->parentModel::onlyTrashed()->count();
            Cache::put('total_trashed_purchase_requisitions', $data['total_trashed_purchase_requisitions']);
        }
        return $data;
    }
    #end

    /**
     * This function forget count
     *
     * @author      Md. Al-Mahmud <mamun120520@gmail.com>
     * @version     1.0
     * @see         
     * @since       11/12/2022
     * Time         14:23:01
     * @param       
     * @return      
     */
    public function forget_count()
    {
        # code...  
        Cache::forget('total_purchase_requisitions');
        Cache::forget('total_trashed_purchase_requisitions');
    }
    #end
}
