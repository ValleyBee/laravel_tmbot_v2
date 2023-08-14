@extends('layout')
@section('content')

{{ csrf_field() }}

<div class="form-group">
	@foreach( $allusers as $key => $user)
	<table>
		<td>
			<tr>
				<hr>
				ID : <b> {{ ($user->id) ?? 0}} </b>
				<em>
					TM USER ID :<b>
						{{ ($user->botuser_id) ?? 0 }} </b>
					STATUS : <b style="border:1px solid #800080"> {{\App\Enums\Users\Status::cases()[($user->status_usr) ?? 0 ]->name}} </b>
					CREATED_AT : {{ ($user->created_at) ?? 0 }}
				</em>
			</tr>
		<td>
			<div class="btn-group">
				<a href=" {{ route('user.edit', ($user->id) ?? 0)}}" class="btn btn-primary mr-2 mb-2 btn-sm">user profile details</a>
				<a href=" {{ route('userallmsg.messages', ($user->id) ?? 0) }}" class="btn btn-primary mr-2 mb-2 btn-sm">show messages</a>
				<a href=" {{ route('userallmsg.messages', ($user->id) ?? 0) }}" class="btn btn-primary mr-2 mb-2 btn-sm">send msg to user</a>
			</div>
		</td>

	</table>


	@endforeach

</div>
@endsection
{{--
	btn border button
	<div class="grid grid-cols-2 gap-x-2">
	<a href="{{ route('userallmsg.stored',$user['id']) }}"> SHOW </a>
<a href="{{ route('userallmsg.stored', $user['id']) }}"> show more... </a>
</div>
--}}
