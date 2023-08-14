@extends('layout')
@section('content')
<form action="{{ url('/send-message') }}" method="post">
	{{ csrf_field() }}
	<div class="form-group">
		<label for="tm_user_id ">
			<h4> TM USER ID : {{$botuser['botuser_id']}} </h4>
		</label>
		<br>
		@foreach( $msg as $m)
		ID: <b> {{$m->id}} </b>
		First name: <b> {{$m->first_name}} </b>
		Last: <b>{{$m->last_name}}</b>
		Msg_id: <b> {{$m->message_id}} </b>
		Created: {{$m->created_at}} Status: <b style="border:1px solid #800080">
			{{ \App\Enums\Messages\Status::cases()[$m->status_msg]->name}} </b> <br>
		<b>User_msg: </b><em style="color:#800080"> {{$m->content}}</em><br>
		<b>Ai_reply: </b><em style="color:#1589FF"> {{$m->reply_from_ai}}</em><br>
		<a href=" {{ route('message.edit', $m->id) }}" class="btn btn-primary mr-2 mb-2 btn-sm">Edit</a>
		<a href="{{route('showallusers.all') }}" type="button" class="btn btn-secondary mr-2 mb-2 btn-sm" name="submit">Back</a>
		<hr>
		@endforeach
		<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">Submit</button>
	</div>
</form>
@endsection