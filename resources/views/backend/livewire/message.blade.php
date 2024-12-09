@extends('backend.layouts.master')

@section('styles')
@endsection

@section('content')
<div id="app">
<!--begin::App-->
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
  <!--begin::Page-->
  <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
    <!--begin::Header-->
    <div id="kt_app_header" class="app-header d-flex" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}" data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
      <!--begin::Header container-->
      <div class="app-container container-fluid d-flex align-items-stretch" id="kt_app_header_container">
        <!--begin::Header wrapper-->
        <div class="app-header-wrapper d-flex flex-stack w-100">
          <!--begin::Logo wrapper-->
          @include('backend.layouts.mobile-logo')
          <!--end::Logo wrapper-->
          <!--begin::Page title wrapper-->
          <div id="kt_app_header_page_title_wrapper">
            <!--begin::Page title-->
            <div data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_page_title_wrapper'}" class="page-title d-flex flex-column justify-content-center me-3 mb-6 mb-lg-0">
              <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center me-3 my-0">Chat</h1>
              <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('home')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <span class="bullet bg-gray-500 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">
                  <a href="{{route('inbox.index')}}" class="text-muted text-hover-primary">Chat</a>
                </li>
              </ul>
            </div>
          </div>
          @include('backend.layouts.usermenu')
        </div>
      </div>
    </div>
    <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    @include('backend.layouts.leftmenu')

        <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
          <div class="d-flex flex-column flex-column-fluid">
            <div id="kt_app_content" class="app-content flex-column-fluid">
              <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card">
                  <div class="card-body py-4">
                    <div>
                        <div class="row justify-content-center" wire:poll="mountComponent()">
                            @if(auth()->user()->is_admin == true)
                                <div class="col-md-4" wire:init>
                                    <div class="card">
                                        <div class="card-header">
                                            Users
                                        </div>
                                        <div class="card-body chatbox p-0">
                                            <ul class="list-group list-group-flush" wire:poll="render">
                                                @foreach($users as $user)
                                                    @php
                                                        $not_seen = \App\Models\Message::where('user_id', $user->id)->where('receiver', auth()->id())->where('is_seen', false)->get() ?? null
                                                    @endphp
                                                    <a href="{{ route('inbox.show', $user->id) }}" class="text-dark link">
                                                        <li class="list-group-item" wire:click="getUser({{ $user->id }})" id="user_{{ $user->id }}">
                                                            <img class="img-fluid avatar" src="https://cdn.pixabay.com/photo/2017/06/13/12/53/profile-2398782_1280.png">
                                                            @if($user->is_online) <i class="fa fa-circle text-success online-icon"></i> @endif {{ $user->name }}
                                                            @if(filled($not_seen))
                                                                <div class="badge badge-success rounded">{{ $not_seen->count() }}</div>
                                                            @endif
                                                        </li>
                                                    </a>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="card-header">
                                        @if(isset($clicked_user)) {{ $clicked_user->name }}
                                        @elseif(auth()->user()->is_admin == true)
                                            Select a user to see the chat
                                        @elseif(auth()->user()->is_online)
                                            <i class="fa fa-circle text-success"></i> We are online
                                        @else
                                            Messages
                                        @endif
                                    </div>
                                        <div class="card-body message-box">
                                            @if(!$messages)
                                                No messages to show
                                            @else
                                                @if(isset($messages))
                                                    @foreach($messages as $message)
                                                        <div class="single-message @if($message->user_id !== auth()->id()) received @else sent @endif">
                                                            <p class="font-weight-bolder my-0">{{ $message->user->name }}</p>
                                                            <p class="my-0">{{ $message->message }}</p>
                                                            @if (isPhoto($message->file))
                                                                <div class="w-100 my-2">
                                                                    <img class="img-fluid rounded" loading="lazy" style="height: 250px" src="{{ $message->file }}">
                                                                </div>
                                                            @elseif (isVideo($message->file))
                                                                <div class="w-100 my-2">
                                                                    <video style="height: 250px" class="img-fluid rounded" controls>
                                                                        <source src="{{ $message->file }}">
                                                                    </video>
                                                                </div>
                                                            @elseif ($message->file)
                                                                <div class="w-100 my-2">
                                                                    <a href="{{ $message->file}}" class="bg-light p-2 rounded-pill" target="_blank"><i class="fa fa-download"></i>
                                                                        {{ $message->file_name }}
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            <small class="text-muted w-100">Sent <em>{{ $message->created_at }}</em></small>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    No messages to show
                                                @endif
                                                @if(!isset($clicked_user) and auth()->user()->is_admin == true)
                                                    Click on a user to see the messages
                                                @endif
                                            @endif
                                        </div>
                                    @if(auth()->user()->is_admin == false)
                                        <div class="card-footer">
                                            <form wire:submit.prevent="SendMessage" enctype="multipart/form-data">
                                                <div wire:loading wire:target='SendMessage'>
                                                    Sending message . . .
                                                </div>
                                                <div wire:loading wire:target="file">
                                                    Uploading file . . .
                                                </div>
                                                @if($file)
                                                    <div class="mb-2">
                                                       You have an uploaded file <button type="button" wire:click="resetFile" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Remove {{ $file->getClientOriginalName() }}</button>
                                                    </div>
                                                @else
                                                    No file is uploaded.
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <input wire:model="message" class="form-control input shadow-none w-100 d-inline-block" placeholder="Type a message" @if(!$file) required @endif>
                                                    </div>
                                                    @if(empty($file))
                                                    <div class="col-md-1">
                                                        <button type="button" class="border" id="file-area">
                                                            <label>
                                                                <i class="fa fa-file-upload"></i>
                                                                <input type="file" wire:model="file">
                                                            </label>
                                                        </button>
                                                    </div>
                                                    @endif
                                                    <div class="col-md-4">
                                                        <button class="btn btn-primary d-inline-block w-100"><i class="far fa-paper-plane"></i> Send</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @include('backend.layouts.copyrights')
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
@endsection
