@extends('layouts.admin.master')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Bottom  Banner</h5>
                    <small class="text-muted float-end"></small>
                </div>
                <div class="card-body">
                <form action="{{ route('admin.update_bottom_banner') }}" method="POST" enctype="multipart/form-data">
                            @csrf   
                            <input type="hidden" name="id" value="{{ $banner_data->id }}">
                            <input type="hidden" name="image1" value="{{ $banner_data->image }}">             
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Title</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" id="basic-default-company" value="{!! $banner_data->title !!}" placeholder="" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-company">Title_k</label>
                            <div class="col-sm-10">
                                <input type="text" name="title_k" class="form-control" id="basic-default-company" value="{!! $banner_data->title_k !!}" placeholder="">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-email">sub Title</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" name="sub_title" id="basic-default-email" class="form-control" value="{!! $banner_data->sub_title !!}" placeholder="" aria-label="john.doe" aria-describedby="basic-default-email2" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-phone">Image</label>
                            <div class="col-sm-10">
                                <input type="file" name="image" id="basic-default-phone" class="form-control phone-mask" value="{!! $banner_data->image !!}" placeholder="658 799 8941" aria-label="658 799 8941" aria-describedby="basic-default-phone">
                                <img src="{{ asset('upload/bottom_banner').'/'.$banner_data->image }}" style="width: 100px; height: 100px;">

                            </div>
                        </div>
                       
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Add Bottom Banner</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endsection
