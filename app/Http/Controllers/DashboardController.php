<?php

namespace App\Http\Controllers;

use App\Models\Admin\Quote;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(){
        $user = auth()->user();

        $totalQuotes = Quote::where('status',Quote::STATUS_ACTIVE)->get()->count();
        $approvedQuotes = Quote::where('action_type',Quote::ACTION_STATUS_APPROVED)->get()->count();
        $rejectedQuotes = Quote::where('action_type',Quote::ACTION_STATUS_REJECTED)->get()->count();
        $otherQuotes = Quote::whereNotIn('action_type',[Quote::ACTION_STATUS_APPROVED,Quote::ACTION_STATUS_REJECTED])->get()->count();

        if(Auth::user()->role_id == Role::ROLE_EXECUTIVE){
            $totalQuotes = Quote::where('status',Quote::STATUS_ACTIVE)->where('created_by',Auth::user()->id)->get()->count();
            $approvedQuotes = Quote::where('created_by',Auth::user()->id)->where('action_type',Quote::ACTION_STATUS_APPROVED)->get()->count();
            $rejectedQuotes = Quote::where('created_by',Auth::user()->id)->where('action_type',Quote::ACTION_STATUS_REJECTED)->get()->count();
            $otherQuotes = Quote::where('created_by',Auth::user()->id)->whereNotIn('action_type',[Quote::ACTION_STATUS_APPROVED,Quote::ACTION_STATUS_REJECTED])->get()->count();
        }else if(Auth::user()->role_id == Role::ROLE_BUSINESS_HEAD){
            $subordinates = $user->businessHeadSubordinates;
            $subordinateIds = $subordinates->pluck('id')->toArray();
            $totalQuotes = Quote::where('status',Quote::STATUS_ACTIVE)->whereIn('created_by', $subordinateIds)->get()->count();
            $approvedQuotes = Quote::whereIn('created_by', $subordinateIds)->where('action_type',Quote::ACTION_STATUS_APPROVED)->get()->count();
            $rejectedQuotes = Quote::whereIn('created_by', $subordinateIds)->where('action_type',Quote::ACTION_STATUS_REJECTED)->get()->count();
            $otherQuotes = Quote::whereIn('created_by', $subordinateIds)->whereNotIn('action_type',[Quote::ACTION_STATUS_APPROVED,Quote::ACTION_STATUS_REJECTED])->get()->count();
        }
        return view('admin.dashboard',[
            'totalQuotes' => $totalQuotes,
            'approvedQuotes' => $approvedQuotes,
            'rejectedQuotes' => $rejectedQuotes,
            'otherQuotes' => $otherQuotes
        ]);
        // return view('admin.pdf.proposal');
    }


    public function quoteChart(Request $request){
        $year = $request->get('year');

        $user = auth()->user();

        $totalQuotes = Quote::where('status',Quote::STATUS_ACTIVE);
        $approvedQuotes = Quote::where('action_type',Quote::ACTION_STATUS_APPROVED);
        $rejectedQuotes = Quote::where('action_type',Quote::ACTION_STATUS_REJECTED);
        $otherQuotes = Quote::whereNotIn('action_type',[Quote::ACTION_STATUS_APPROVED,Quote::ACTION_STATUS_REJECTED]);

        if(Auth::user()->role_id == Role::ROLE_EXECUTIVE){
            $totalQuotes = Quote::where('status',Quote::STATUS_ACTIVE)->where('created_by',Auth::user()->id);
            $approvedQuotes = Quote::where('created_by',Auth::user()->id)->where('action_type',Quote::ACTION_STATUS_APPROVED);
            $rejectedQuotes = Quote::where('created_by',Auth::user()->id)->where('action_type',Quote::ACTION_STATUS_REJECTED);
            $otherQuotes = Quote::where('created_by',Auth::user()->id)->whereNotIn('action_type',[Quote::ACTION_STATUS_APPROVED,Quote::ACTION_STATUS_REJECTED]);
        }else if(Auth::user()->role_id == Role::ROLE_BUSINESS_HEAD){
            $subordinates = $user->businessHeadSubordinates;
            $subordinateIds = $subordinates->pluck('id')->toArray();
            $totalQuotes = Quote::where('status',Quote::STATUS_ACTIVE)->whereIn('created_by', $subordinateIds);
            $approvedQuotes = Quote::whereIn('created_by', $subordinateIds)->where('action_type',Quote::ACTION_STATUS_APPROVED);
            $rejectedQuotes = Quote::whereIn('created_by', $subordinateIds)->where('action_type',Quote::ACTION_STATUS_REJECTED);
            $otherQuotes = Quote::whereIn('created_by', $subordinateIds)->whereNotIn('action_type',[Quote::ACTION_STATUS_APPROVED,Quote::ACTION_STATUS_REJECTED]);
        }

        if($year){
            $totalQuotes = $totalQuotes->whereYear('created_at', $year);
            $approvedQuotes = $approvedQuotes->whereYear('created_at', $year);
            $rejectedQuotes = $rejectedQuotes->whereYear('created_at', $year);
            $otherQuotes = $otherQuotes->whereYear('created_at', $year);
        }

        $totalQuotes = $totalQuotes->get()->count();
        $approvedQuotes = $approvedQuotes->get()->count();
        $rejectedQuotes = $rejectedQuotes->get()->count();
        $otherQuotes = $otherQuotes->get()->count();
        return response()->json(
            ["data" =>
                [
                    "New Quotation" => $totalQuotes,
                    "Approved Quotation" => $approvedQuotes,
                    "Other Quotation" => $otherQuotes,
                    "Rejected Quotation" => $rejectedQuotes
                ]
            ]);
    }
}
