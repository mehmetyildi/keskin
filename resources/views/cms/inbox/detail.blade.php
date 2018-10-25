@extends('layouts.cms')

@section('title') <title>{{ config('app.cms_name') }} | Inbox</title> @endsection

@section('styles')
    <link href="{{ url('cms/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            @include('cms.includes.inbox-menu')
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="mail-box-header">
                <div class="pull-right tooltip-demo">
                    @can('compose_mail')
                    <a href="{{ route('cms.inbox.reply', ['mail' => $mail->id]) }}" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Yanıtla"><i class="fa fa-reply"></i> Yanıtla</a>
                    @endcan
                    <a href="#" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Yazdır"><i class="fa fa-print"></i> </a>
                    <form style="display:inline" method="POST" action="{{ route('cms.inbox.move-to-trash', ['mail' => $mail->id]) }}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-white btn-sm" data-toggle="tooltip" data-placement="top" title="Çöp kutusuna taşı"><i class="fa fa-trash-o"></i> </button>
                        </button>
                    </form>
                </div>
                <div class="mail-tools tooltip-demo m-t-md">
                    <h3>
                        {{ $mail->subject }}
                    </h3>
                    <h5>
                        <span class="pull-right font-normal">{{ $mail->created_at->format('d.m.y @ h:i') }}</span>
                        <span class="font-normal">Gönderen: </span>{{ $mail->from }} <br>
                        <span class="font-normal">Alıcı: </span>{{ $mail->to }}
                    </h5>
                </div>
            </div>
            <div class="mail-box">


                <div class="mail-body">
                    {!! $mail->body !!}
                </div>
                @if($mail->attachments->count())
                <div class="mail-attachment">
                    <p>
                        <span><i class="fa fa-paperclip"></i> {{ $mail->attachments->count() }} Ek </span>
                    </p>
                    <div class="attachment">
                        @foreach($mail->attachments as $attachment)
                        <div class="file-box">
                            <div class="file">
                                <a href="{{ url('storage/'.$attachment->path) }}" download>
                                    <span class="corner"></span>

                                    <div class="icon">
                                        <i class="fa fa-file"></i>
                                    </div>
                                    <div class="file-name">
                                        {{ $attachment->path }}
                                        <br/>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        <div class="clearfix"></div>
                    </div>
                </div>
                @endif
                
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ url('cms/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
@endsection