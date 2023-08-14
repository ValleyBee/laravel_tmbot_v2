<div class="btn-group">
	<form name="submit_one" id="submit_one">
		@csrf
		@method('put')
		<button formaction="{{route('message.update') }}" formmethod="POST" name="submit" type="submit" value="PUT">Update</button>
		<input type="hidden" name="id" value="{{$userMsg->id}}">
	</form>
	<form name="submit_two" action="{{route('message.delete', $userMsg->id) }}" id="submit_two">
		@csrf
		@method('delete')
		<button formaction="{{route('message.delete', $userMsg->id) }}" formmethod="POST" name="submit" type="submit" method="delete" value="POST">Delete</button>
		<input type="hidden" name="id" value="{{$userMsg->id}}">
	</form>
</div>

@endsection

@vite(['resources/css/app.css','resources/js/app.js'])

{{-- <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"> 
		<form action="{{ route('message.delete', $userMsg->id) }}" name="action2" method="post">
@csrf
@method('post')
<button formaction="{{route('message.delete', $userMsg->id) }}" type="submit" name="action" value=" " class="btn btn-primary" form="submit_two">Delete</button>
</form>

<button type="submit" name="action" value=" " class="btn btn-primary" form="submit_two" formmethod="POST">Delete2</button>
--}}
<style>
	.btn-group button {
		background-color: #04AA6D;
		/* Green background */
		border: 2px solid green;
		/* Green border */
		color: white;
		/* White text */
		padding: 10px 34px;
		/* Some padding */
		cursor: pointer;
		/* Pointer/hand icon */
		width: 50%;
		/* Set a width if needed */
		display: block;
		/* Make the buttons appear below each other */
	}

	.btn-group button:not(:last-child) {
		border-bottom: none;
		/* Prevent double borders */
	}

	/* Add a background color on hover */
	.btn-group button:hover {
		background-color: #3e8e41;
	}
</style>
