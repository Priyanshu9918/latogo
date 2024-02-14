<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Models\Bottom_banner;
use App\Models\Order;
use App\Models\BookSession;

class AdminController extends Controller
{

  ////bottom banner section////
  function add_bottom_banner()
  {
    return view('admin.add_bottom_banner');
  }
  function save_banner(Request $request)
  {

    $file       = $request->file('image');
    $filename   = 'img_' . time() . '.' . $file->getClientOriginalExtension();
    $file->move(public_path('upload/bottom_banner'), $filename);

    Bottom_banner::create([
      'title' => $request->title,
      'title_k' => $request->title_k ?? '',
      'sub_title' => $request->sub_title,
      'image' => $filename,
    ]);
    return redirect('admin/View-Bottom-Banner')->with('msg', ' Data Added Successfully !');
  }
  function View_bottom_banner()
  {
    $banner_data = Bottom_banner::get();
    return view('admin.view_bottom_banner', compact('banner_data'));
  }
  function edit_bottom_banner(Request $request)
  {
    $banner_data =  Bottom_banner::find($request->id);
    return view('admin/edit_bottom_banner', compact('banner_data'));
  }
  function update_bottom_banner(Request $request)
  {
    if (!empty($_FILES['image']['name'])) {
      $file       = $request->file('image');
      $image   = 'img_' . time() . '.' . $file->getClientOriginalExtension();
      $file->move(public_path('upload/bottom_banner'), $image);
    } else {
      $image = $request->image1;
    }
    DB::table('bottom_banners')->where('id', $request->id)->update([
      'title' => $request->title,
      'title_k' => $request->title_k ?? '',
      'sub_title' => $request->sub_title,
      'image' => $image,
    ]);
    return redirect('admin/View-Bottom-Banner')->with('msg', ' Data Updated Successfully !');
  }
  function delete_bottom_banner(Request $request)
  {
    Bottom_banner::where('id', $request->id)->delete();
    return redirect('admin/View-Bottom-Banner')->with('msg', 'Data Deleted Successfully !');
  }

  function banner_status(Request $request)
  {
    $banner_data = Bottom_banner::where('id', $request->id)->first();
    $old_status = $banner_data->status;
    if ($old_status == '0') {
      $new_status = '1';
    } else {
      $new_status = '0';
    }
    DB::table('bottom_banners')->where('id', $request->id)->update([
      'status' => $new_status,
    ]);
    return redirect('admin/View-Bottom-Banner')->with('msg', 'Status Changed Successfully !');
  }

  function view_order()
  {
    $order_data = Order::where('is_completed', 1)->orderBy('id','DESC')->get();
    return view('admin.view_order', compact('order_data'));
  }
  function order_details(Request $request)
  {
    $order_data = Order::find($request->id);
    return view('admin.order_details', compact('order_data'));
  }

  function book_session()
  {
    $booking_data = BookSession::select('book_sessions.*', 'u1.name as s_name', 'u2.name as t_name', 'price_masters.title','pricings.totle_class')
      -> leftJoin('users as u1', 'u1.id', '=', 'book_sessions.student_id')->where('u1.user_type', '1')
      ->leftJoin('users as u2', 'u2.id', '=', 'book_sessions.teacher_id')->where('u2.user_type', '2')
      ->leftJoin('pricings', 'pricings.id', '=', 'book_sessions.class_id')
      ->leftJoin('price_masters', 'pricings.price_master', '=', 'price_masters.id')
      ->orderBy('book_sessions.id','DESC')
      ->get();
      return view('admin.book_session', compact('booking_data'));
     
}

}
