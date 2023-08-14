@extends('layout')
@section('content')
<div class="form-group">
	<form name="submit_one" id="submit_one" action="{{route('message.update') }}" method="POST">
		@csrf
		@method('put')
		<label>
			<h4> TM USER ID&nbsp;:&nbsp;{{$userMsg->botuser_id}}</h4>
		</label>
		<hr>
		MSG ID:&nbsp;<b4 style="color:#800080"> {{$userMsg->message_id}}</b4><br>
		First name:&nbsp;<b4><em style="color:#800080">{{$userMsg->first_name}}</b4></em><br>
		Last name:&nbsp;<b4> <em style="color:#800080">{{$userMsg->last_name}}</b4></em><br>
		Content:&nbsp;<em style="color:#800080"> {{$userMsg->content}}</em><br>
		Message created:&nbsp;<em style="color:#800080">{{$userMsg->created_at}}</em><br>
		Last AI reply:&nbsp;<em style="color:#1589FF">{{$userMsg->reply_from_ai}}</em><br>
		Status:&nbsp;
		<select id="mySelect" onchange="myFunction()" name="status" class="block w-full mt-1 rounded-md" style="background-color: #e3f2fd;">
			<option disabled selected> Select status</option>
			@foreach ($statuses as $status)
			<option value="{{ $status['id'] }}" {{$status['name'] == \App\Enums\Messages\Status::cases()[$userMsg->status_msg]->name ? 'selected' : ''}}> {{$status['name']}}
			</option>
			@endforeach
		</select>
		<b><em id="data-d" style="color: #101010"> </b></em>
		<hr>
		<div class="btn-group">
			<button type="submit" class="btn btn-primary mr-2 mb-2 btn-sm">Update</button>
			<button type=" submit" class="btn btn-primary mr-2 mb-2 btn-sm" form="submit_two" name="submit">Delete</button>
			<a href="{{route('userallmsg.messages', $userMsg->user_id) }}" type="button" class="btn btn-secondary mr-2 mb-2 btn-sm">Back</a>
			<input type="hidden" name="id" value="{{$userMsg->id}}">
		</div>
	</form>
	<form name="submit_two" id="submit_two" action="{{route('message.delete', $userMsg->id)}}" method="POST">
		@csrf
		@method('delete') <input type="hidden" name="id" value="{{$userMsg->id}}">
	</form>
</div>
@endsection
<script>
	function myFunction() {
		let x = document.getElementById("mySelect").value;
		document.getElementById("data-d").innerHTML = "You selected : " + x;
	}
</script>